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

	private $_orders = array();
	protected $_pool;
	private $_locationsData = array();
	private $_webOrders = array();
	private $_model;

	/**
	 *
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
	 *
	 * @return boolean
	 */
	public function hasOrders(){

		$bReturn = ( !empty( $this->_orders ) )? true: false;
		return( $bReturn );
	}

	/**
	 *
	 * @return void
	 */
	public function poolOrders() {

		foreach( $this->_orders as $aOrder ){

			$aOrderData = current( json_decode( $aOrder['receipt_string'], true ) );
			$sOrderId = $this->_getOrderId( $aOrderData );
			$iInvoiceId = $this->_getInvoiceId( $aOrderData );
			$aLocation = $this->_getLocation( $aOrder['location_id'], $sOrderId );

			$sOrderToMerge = ( isset( $this->_webOrders[ $iInvoiceId ] ) )? Netsuite_Crypt::decrypt( $this->_webOrders[ $iInvoiceId ] , true ): null;
			$aWork[] = $tThread = $this->_pool->submit( new LivePos_LivePosOrder( $sOrderId, $aOrder, $aLocation, $sOrderToMerge ) );
		}

		$this->_pool->shutdown();
		$this->_queueOrders();

		if( DEBUG ){

		

			foreach($this->_pool->workers as $worker) {
				
				$this->_logTestResults($worker->getData() );
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

		return( 'POS_' . $aOrderData['intReceiptNumber']);
		//return( $aOrderData['strActivaNumber'] );
	}

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
	 *
	 * @throws Exception
	 */
	private function _getWebOrders(){

		$aSetToMerged = array();
		$aWebOrders = $this->_model->getWebOrders();

		if( !empty( $aWebOrders ) ){

			array_walk( $aWebOrders, function( $aRawOrder, $sKey ) use ( &$aSetToMerged ){

				$aSetToMerged[] = $aRawOrder['queue_id'];
				$this->_webOrders[ $aRawOrder['pos_number'] ] = $aRawOrder['order_json'];
			});
		}
	}


	/**
	 *
	 * @param int $iLocationId
	 * @param string $sOrderId
	 * @return array $aTempLocation
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

	private function _getPosOrders(){

		$this->_orders = $this->_model->getPosOrders( LIVEPOS_MAX_PROCESSED );
	}

	/**
	 *
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
					//':order_activa_id' => ( $aWorkerData['web_items'] )? $aWorkerData['order_id'] .'-POS': $aWorkerData['order_id'],
					':order_activa_id' => $aWorkerData['order_id'],
					':order_json' => $aWorkerData['encrypted'] );
		}

		$this->_model->queueOrders( $aOrdersArray );
		$this->_model->updateIgnoredOrders( $aIgnoredOrders );

	}
}