<?php


class Netsuite_Netsuite extends Stackable {

	public $response = null;
	protected $_queueId;
	protected $_customer;
	protected $_order;
	protected $_client;
	protected $_results = array();

	public function __construct( array $aOrder, $iQueueId, $sOrderID ){

		$this->_order = $aOrder;

		$this->_order['customer']['_source'] = $this->_order['order']['_source'];
		$this->_queueId = $iQueueId;
		//$this->_orderId = $this->_order['order']['custbody_order_source_id'];
		$this->_orderId = $sOrderID;

	}

	protected function _isCustomer( $sCustomerId ){

		$activa = new Netsuite_Db_Activa();
		$sInternalId = $activa->getCustomer( $sCustomerId );
		return( $sInternalId );
	}

	public function run(){

		spl_autoload_register(function ($sClass) {
			$sClass = str_replace( "_", "/", $sClass );
			include $sClass . '.php';
		});

			try{

				$this->worker->addData( array( 'queue_id' => $this->_queueId ) );

				switch( true ){

					case( isset( $this->_order['refund'] ) ):

						$this->_createRefund();
						break;

					default:

						$customer = $this->_createCustomer();

						if( $customer !== false  ){
							$this->_createSalesOrder( $customer );
						}
						break;
				}

			} catch( Exception $e ) {
				Netsuite_Db_Model::logError( $e->getMessage() );
				$results['system']['error'] = $e->getMessage();
				$this->worker->addData( $results );
			}

			$this->_logResults();
	}

	protected function _createRefund(){

		$refund = Netsuite_Record::factory()->refund( $this->_order['refund'] );

		if( !$refund->isOk() ){

			$aJsonReturn['success'] = false;
			$aJsonReturn['error'] = implode( ',', $refund->getErrors() );
			$aJsonReturn['warn'] = ( $refund->hasWarnings() )? implode( ',', $refund->getWarnings() ):null;
			$aJsonReturn['json'] = json_encode( $this->_order['refund'] );
			$this->worker->addData( $aJsonReturn );
			return;
		}

		$results = $this->_process('refund', $refund );
		$this->worker->addData( array( 'refund' => $results ) );
	}

	protected function _createSalesOrder( $customer ){

		$salesOrder = Netsuite_Record::factory()->salesOrder( $this->_order['order'], $customer );

		if( !$salesOrder->isOk() ){

			$aJsonReturn['success'] = false;
			$aJsonReturn['error'] = implode( ',', $salesOrder->getErrors());
			$aJsonReturn['warn'] = ( $salesOrder->hasWarnings() )? implode( ',', $salesOrder->getWarnings() ):null;
			$aJsonReturn['json'] = json_encode( $this->_order['order'] );
			$this->worker->addData( $aJsonReturn );
			return;
		}

		$results = $this->_process('salesorder', $salesOrder );
		$this->worker->addData( array( 'order' => $results ) );

	}

	protected function _createCustomer(){

		$customer = Netsuite_Record::factory()->customer( $this->_order['customer'] );

		if( !$customer->isOk() ){
			$aJsonReturn['success'] = false;
			$aJsonReturn['error'] = implode( ',', $customer->getErrors());
			$aJsonReturn['warn'] = ( $customer->hasWarnings() )? $customer->getWarnings():null;
			$this->worker->addData( array('customer' => $aJsonReturn ) );
			return;
		}

		switch( true ){

			case( $customer->custentity_customer_source_id == 'bongo' ):
				$results = $this->_process('bongocontact', $customer );

				if( $results['success'] === true ){
					//$customer->entityid = $results['netsuite']['record_id'];
					$results['message'] = 'Added Contact to Bongo with Id: ' . $customer->entityid;
					$results['json'] = json_encode( $this->_order['customer'] );
				}
				// $this->worker->addData( $results );
				break;

			case( empty( $customer->entityid ) ):

				$results = $this->_process('customer', $customer );

				if( $results['success'] === true ){

					$model = new Netsuite_Db_Model();
					$activa = new Netsuite_Db_Activa();
					$customer->entityid = $results['netsuite']['record_id'];
					$model->insertCustomer( $customer->custentity_customer_source_id, $customer->entityid );
					$activa->updateCustomer( $customer->custentity_customer_source_id, $customer->entityid );
					$activa = $model = null;
				}
				// $this->worker->addData( $results );
				break;

			default:
				$results['netsuite']['record_id'] = $customer->entityid;
				$results['success'] = true;
				$results['json'] = 'Using Existing Netsuite Id: ' . $customer->entityid;
				//$this->worker->addData( $results );
				break;
		}

		$this->worker->addData( array('customer' => $results ) );
		// updateAddressBook( $customer );  add this functionality

		$mReturn = ( $results['success'] !== false )? $customer: false;
		return( $mReturn );
	}


	protected function _logResults() {

		$sSystemError = '';

		$aResults = $this->worker->getData();
		$sIsSuccess = ( $aResults['customer']['success'] == true && $aResults['order']['success'] == true )? 'complete': 'error';
		$sCustomerStatus = ( $aResults['customer']['success'] == true )? 'success': 'fail';
		$sOrderStatus = ( $aResults['order']['success'] == true )? 'success': 'fail';

		switch( true )
		{
			case( !empty( $aResults['customer']['system']['error'] ) ):
				$sSystemError .= $aResults['customer']['system']['error'] . ' ';

			case( !empty( $aResults['order']['system']['error'] ) ):
				$sSystemError .= $aResults['order']['system']['error'];
				break;
		}

		$aUpdateData = array(
				':status' => $sIsSuccess,
				':order_activa_id' => $this->_orderId,
				':system_error' => $sSystemError,
				':process_date' => date("Y-m-d H:i:s"),
				':customer_status' => $sCustomerStatus,
				':customer_id' => $aResults['customer']['netsuite']['record_id'],
				':customer_warnings' => ( is_array( $aResults['customer']['warn'] ) )?implode( ',',$aResults['customer']['warn']):$aResults['customer']['warn'],
				':customer_errors' => $aResults['customer']['error'],
				':customer_json' => $aResults['customer']['json'],
				':order_status' => $sOrderStatus,
				':order_id' => $aResults['order']['netsuite']['record_id'],
				':order_warnings' => ( is_array( $aResults['order']['warn'] ) )?implode( ',',$aResults['order']['warn']):$aResults['order']['warn'],
				':order_errors' => $aResults['order']['error'],
				':order_json' => $this->_maskCcNumber( $aResults['order']['json'] )
		);

		$sOutcome = ( $sCustomerStatus == 'fail' || $sOrderStatus == 'fail' )? 'error' : 'complete';
		$model = new Netsuite_Db_Model();
		$activa = new Netsuite_Db_Activa();
		$model->updateOrderQueue( $aResults['queue_id'], $sOutcome );
		$model->logProcess( $aUpdateData );
		$activa->logProcess( $aUpdateData );
		$activa = $model = null;
	}


	/**
	 * Mask Credit Card Number for Storage in the Database
	 *
	 * @access protected
	 * @param string $sJson
	 * @return string
	 */
	protected function _maskCcNumber( $sJson ){

		$aTempData = json_decode( $sJson, true );

		if( isset( $aTempData['ccnumber'] ) && $aTempData['ccnumber'] != '' ){
			$aTempData['ccnumber'] = '**** **** **** ' . substr( $aTempData['ccnumber'], -4);
			$aTempData['authcode'] = '*****';
		}

		return( json_encode(  $aTempData ) );
	}

	protected function _process( $sRecordName, $oRecord ){

		$aJsonReturn = array('system' => array( 'error' => null ), 'netsuite' => array( 'error' => null ));

		$oSetRecord = new Netsuite_Job_SetRecord( $sRecordName, $oRecord->getJSON() );

		if( !$oSetRecord->isOk() ){
			$aJsonReturn['success'] = false;
			$aJsonReturn['error'] = $oSetRecord->response;
			$aJsonReturn['netsuite']['success'] = false;
			$aJsonReturn['netsuite']['error'] = $oSetRecord->response;

			return( $aJsonReturn );
		}

		$record = ( !is_numeric( $oSetRecord->response ) )? json_decode( $oSetRecord->response ): $oSetRecord->response;

		switch( true ){

			case( $record == null ):

				$aJsonReturn['success'] = false;
				$aJsonReturn['netsuite']['success'] = false;
				$aJsonReturn['system']['error'] = ( is_array( $oSetRecord->response ) || is_object( $oSetRecord->response ) )? json_encode($oSetRecord->response): $oSetRecord->response;
				break;

			case( $record->status == 'failure' ):
				$aJsonReturn['success'] = false;
				$aJsonReturn['netsuite']['success'] = false;
				$aJsonReturn['netsuite']['error'] = $record->payload->code . ' - ' . $record->payload->details;
				$aJsonReturn['error'] = $record->payload->code . ' - ' . $record->payload->details;
				$aJsonReturn['json'] = $oRecord->getJSON();
				break;

			case( $record->status == 'warn' ):
					
				$aJsonReturn['netsuite']['record_id'] = $record->recordid;
				$aJsonReturn['success'] = true;
				$aJsonReturn['warn'] = $record->payload->details . ', ' . $oRecord->getWarnings();
				$aJsonReturn['json'] = $oRecord->getJSON();
				break;
					
			default:

				$aJsonReturn['netsuite']['record_id'] = $record->recordid;
				$aJsonReturn['success'] = true;
				$aJsonReturn['warn'] = $oRecord->getWarnings();
				$aJsonReturn['json'] = $oRecord->getJSON();
				break;
		}

		return( $aJsonReturn );
	}
}
