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
				$this->worker->addData( $this->_queueId );
				$customer = $this->_createCustomer();

				if( $customer !== false  ){
					$this->_createSalesOrder( $customer );
				}

			} catch( Exception $e ) {
				Netsuite_Db_Model::logError( $e->getMessage() );
				$results['system']['error'] = $e->getMessage();
				$this->worker->addData( $results );
			}

			$this->_logResults();
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
		$this->worker->addData( $results );

	}

	protected function _createCustomer(){

		$customer = Netsuite_Record::factory()->customer( $this->_order['customer'] );

			$model = new Netsuite_Db_Model();
			$activa = new Netsuite_Db_Activa();

			if( !$customer->isOk() ){
				$aJsonReturn['success'] = false;
				$aJsonReturn['error'] = implode( ',', $customer->getErrors());
				$aJsonReturn['warn'] = ( $customer->hasWarnings() )? $customer->getWarnings():null;
				$this->worker->addData( $aJsonReturn );
				return;
			}
			
			
			if( empty( $customer->entityid )  ){
				$results = $this->_process('customer', $customer );
				
				if( $results['success'] === true ){
					$customer->entityid = $results['netsuite']['record_id'];
					$model->insertCustomer( $customer->custentity_customer_source_id, $customer->entityid );
					$activa->updateCustomer( $customer->custentity_customer_source_id, $customer->entityid );
				}
				$this->worker->addData( $results );
			} else {
				//$results['netsuite']['record_id'] = $customer->entityid = $mInternalId;
				$results['success'] = true;
				$results['json'] = 'Using Existing Netsuite Id: ' . $customer->entityid;
				$this->worker->addData( $results );
			}


		// updateAddressBook( $customer );  add this functionality

		$mReturn = ( $results['success'] !== false )? $customer: false;
		return( $mReturn );
	}


	protected function _logResults() {

		$model = new Netsuite_Db_Model();
		$activa = new Netsuite_Db_Activa();
		$sSystemError = '';

		$aResults = $this->worker->getData();
		$sIsSuccess = ( $aResults[1]['success'] == true && $aResults[2]['success'] == true )? 'complete': 'error';
		$sCustomerStatus = ( $aResults[1]['success'] == true )? 'success': 'fail';
		$sOrderStatus = ( $aResults[2]['success'] == true )? 'success': 'fail';

		switch( true )
		{
			case( !empty( $aResults[1]['system']['error'] ) ):
				$sSystemError .= $aResults[1]['system']['error'] . ' ';

			case( !empty( $aResults[2]['system']['error'] ) ):
				$sSystemError .= $aResults[2]['system']['error'];
				break;
		}

		$aUpdateData = array(
				':status' => $sIsSuccess,
				':order_activa_id' => $this->_orderId,
				':system_error' => $sSystemError,
				':process_date' => date("Y-m-d H:i:s"),
				':customer_status' => $sCustomerStatus,
				':customer_id' => $aResults[1]['netsuite']['record_id'],
				':customer_warnings' => ( is_array( $aResults[1]['warn'] ) )?implode( ',',$aResults[1]['warn']):$aResults[1]['warn'],
				':customer_errors' => $aResults[1]['error'],
				':customer_json' => $aResults[1]['json'],
				':order_status' => $sOrderStatus,
				':order_id' => $aResults[2]['netsuite']['record_id'],
				':order_warnings' => $aResults[2]['warn'],
				':order_errors' => $aResults[2]['error'],
				':order_json' => $this->_maskCcNumber( $aResults[2]['json'] )
		);

		$sOutcome = ( $sCustomerStatus == 'fail' || $sOrderStatus == 'fail' )? 'error' : 'complete';
		$model->updateOrderQueue( $aResults[0], $sOutcome );
		$model->logProcess( $aUpdateData );
		$activa->logProcess( $aUpdateData );
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

			default:

				$aJsonReturn['netsuite']['record_id'] = $record;
				$aJsonReturn['success'] = true;
				$aJsonReturn['warn'] = $oRecord->getWarnings();
				$aJsonReturn['json'] = $oRecord->getJSON();
				break;
		}

		return( $aJsonReturn );
	}
}