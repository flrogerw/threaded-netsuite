<?php
/**
 * LivePOS Order Server
 *
 * @package Netsuite
 * @subpackage LivePOS
 * @author gWilli
 * @version 1.0
 * @copyright 2014
 * @name LivePOS Order Server
 */
/**
 * LivePOS Receipt to Netsuite Record Process
 *
 * Thread Server for processing LivePOS Orders.
 *
 * @uses Configure
 * @package Netsuite
 * @subpackage LivePOS
 * @final Can NOT Extend
 */
final class LivePos_Thread_OrdersServer {

	/**
	 * Holds Orders to be Processed
	 *
	 * @var array
	 * @access private
	 */
	private $_orders = array();

	/**
	 * Holds Worker Threads
	 *
	 * @var Thread_Pool
	 * @access protected
	*/
	protected $_pool;

	/**
	 * Holds Information about Locations
	 *
	 * @var array
	 * @access private
	 */
	private $_locationsData = array();

	/**
	 * Array of Orders Marked for Merging
	 *
	 * @access private
	 * @var Array
	*/
	private $_webOrders = array();

	/**
	 * Array of Orders Marked as Merged
	 *
	 * @access private
	 * @var Array
	*/
	private $_webOrdersMerged = array();

	/**
	 * Database Connection
	 *
	 * @access private
	 * @var Resource
	*/
	private $_model;

	/**
	 * Standard Class Constructor
	 *
	 * @access public
	 * @return void
	 */
	public function __construct(){

		$this->_pool = new Thread_Pool( MAX_ORDER_RECORDS );
		$this->_model = new LivePos_Db_Model();
		$this->_getPosOrders();

		if( $this->hasOrders() ){
			$this->_getWebOrders();
		}
	}

	/**
	 * Returns true/false if there are orders to be processed.
	 *
	 * @access public
	 * @return boolean
	 */
	public function hasOrders(){

		$bReturn = ( !empty( $this->_orders ) )? true: false;
		return( $bReturn );
	}

	/**
	 * Sends Stackable Thread to Thread Pool for Processing.
	 *
	 * @return void
	 * @access public
	 */
	public function poolOrders() {

		foreach( $this->_orders as $aOrder ){

			$aOrderData = current( json_decode( $aOrder['receipt_string'], true ) );
			$sOrderId = $this->_getOrderId( $aOrderData );
			$iInvoiceId = $this->_getInvoiceId( $aOrderData );
			$aLocation = $this->_getLocation( $aOrder['location_id'], $sOrderId );
			$sOrderToMerge = null;

			if( isset( $this->_webOrders[ $iInvoiceId ] ) ){
				$sOrderToMerge = Netsuite_Crypt::decrypt( $this->_webOrders[ $iInvoiceId ]['order_data'] , true );
				$this->_webOrdersMerged[] = $this->_webOrders[ $iInvoiceId ]['queue_id'];
			}				
				
			$aWork[] = $tThread = $this->_pool->submit( new LivePos_LivePosOrder( $sOrderId, $aOrder, $aLocation, $sOrderToMerge ) );
		}

		$this->_pool->shutdown();
		$this->_model->updateToMerged( $this->_webOrdersMerged );
		$this->_queueOrders();

		foreach($this->_pool->workers as $worker) {
			$this->_logTestResults($worker->getData() );
		}

		if( DEBUG ){

			foreach($this->_pool->workers as $worker) {

				print_r($worker->getData());
			}
		}
	}

	/**
	 * Returns LivePOS Invoice Id
	 *
	 * @access private
	 * @param array $aOrderData
	 * @return integer
	 */
	private function _getInvoiceId( array $aOrderData ){

		return( $aOrderData['intInvoiceNumber'] );
	}

	/**
	 * Returns Activa Order Id
	 *
	 * @access private
	 * @param array $aOrderData
	 * @return string
	 */
	private function _getOrderId( array $aOrderData ){

		$sOrderId = ( isset( $aOrderData['strReferenceCode'] ) && $aOrderData['strReferenceCode'] != '' )? $aOrderData['strReferenceCode']: 'POS_' . $aOrderData['intReceiptNumber'];
		return( $sOrderId );
	}

	/**
	 * Logs the Conversion Results from LivePOS Receipt to NesSuite Order.
	 *
	 * @access private
	 * @param array $worker
	 * @return void
	 */
	private function _logTestResults( $worker ){

		$aTestResult = array( ':receipt_id' => $worker['receiptId'],
				':invoice_id' => $worker['invoiceId'],
				'pos_total' => $worker['posTotal'],
				'ns_total' => $worker['orderTotal'],
				':discount_scope' => $worker['discount_scope'],
				':discount_type' => $worker['discount_type'],
				':discount_amount' => $worker['discount_amount'],
				':discount_total' => $worker['discount_total'],
				':webitems_total' => $worker['webItems'],
				':ignored_reason' => $worker['error'] );

		$this->_model->insertTestResults( $aTestResult );
	}

	/**
	 * Get Orders Marked as Web Orders from NetSuite Order Queue
	 * for Merging with LivePOS Receipt.
	 *
	 * @access private
	 * @return void
	 */
	private function _getWebOrders(){

		$aSetToMerged = array();
		$aWebOrders = $this->_model->getWebOrders();

		if( !empty( $aWebOrders ) ){

			array_walk( $aWebOrders, function( $aRawOrder, $sKey ) use ( &$aSetToMerged ){

				$this->_webOrders[ $aRawOrder['pos_number'] ]['order_data'] = $aRawOrder['order_json'];
				$this->_webOrders[ $aRawOrder['pos_number'] ]['queue_id'] = $aRawOrder['queue_id'];
			});
		}
	}


	/**
	 * Gets Location Data From the Database for Use in Order
	 * Creation. (i.e. department, entity, lead, etc...)
	 *
	 * @access private
	 * @param int $iLocationId
	 * @param string $sOrderId
	 * @return array
	 */
	private function _getLocation( $iLocationId, $sOrderId ){

		if( !isset( $this->_locationsData[ $iLocationId ] ) ){

			$this->_locationsData[ $iLocationId ] = $this->_model->getEntity( $iLocationId );
		}

		$aTempLocation = $this->_locationsData[ $iLocationId ];

		if( in_array( $sOrderId, array_keys( $this->_webOrders ) ) ){
			$aTempLocation['location_entity'] = $this->_webOrders[ $sOrderId ];
		}

		return( $aTempLocation );
	}

	/**
	 * Gets Receipts From the Database for Processing.
	 *
	 * @access private
	 * @return void
	 */
	private function _getPosOrders(){

		$this->_orders = $this->_model->getPosOrders( LIVEPOS_MAX_PROCESSED );
	}

	/**
	 * Queue encrypted orders into NetSuite Database.
	 *
	 * @access private
	 * @return void
	 */
	private function _queueOrders(){

		$aOrdersArray = array();
		$aIgnoredOrders = array();

		foreach( $this->_pool->workers as $worker ) {

			$aWorkerData = $worker->getData();

			if( $aWorkerData['ignore'] ){

				$aIgnoredOrders[] = array(
						':receipt_id' => $aWorkerData['receiptId'],
						':error_message' => $aWorkerData['error'],
						'sent_to_netsuite' => 'ignored');
				continue;
			}

			$aOrdersArray[] = array(
					':customer_activa_id' => $aWorkerData['entityId'],
					':order_activa_id' => $aWorkerData['order_id'],
					':order_json' => $aWorkerData['encrypted'] );
		}

		$this->_model->queueOrders( $aOrdersArray );
		$this->_model->updateIgnoredOrders( $aIgnoredOrders );
	}
}