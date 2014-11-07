<?php

class LivePos_Thread_OrdersServer {

	private $_orders = array();
	protected $_pool;
	private $_locationsData = array();
	private $_webOrders = array();
	private $_model;

	public function __construct(){

		$this->_pool = new Thread_Pool( MAX_ORDER_RECORDS );
		$this->_model = new LivePos_Db_Model();
		$this->_getPosOrders();
		
		if( $this->hasOrders() ){
			$this->_getWebOrders();
		}	
	}

	public function hasOrders(){

		$bReturn = ( !empty( $this->_orders ) )? true: false;
		return( $bReturn );
	}


	public function poolOrders() {

		foreach( $this->_orders as $aOrder ){

			$sOrderId = $this->_getOrderId( $aOrder );
			$aLocation = $this->_getLocation( $aOrder['location_id'], $sOrderId );

			$aWork[] = $tThread = $this->_pool->submit( new LivePos_LivePosOrder( $sOrderId, $aOrder, $aLocation ) );
		}

		$this->_pool->shutdown();
		$this->_queueOrders();

		if( DEBUG ){
			foreach($this->_pool->workers as $worker) {
				print_r($worker->getData());
			}
		}
	}

	private function _getOrderId( array $aOrder ){

		$aOrderData = current( json_decode( $aOrder['receipt_string'], true ) );
		return( 'POS_' . $aOrderData['intReceiptNumber']);
		//return( $aOrderData['strActivaNumber'] );
	}

	private function _getWebOrders(){

		$aSetToMerged = array();
		$aErrorIds = array();
		$aErrorMessages = array();
		$aWebOrders = $this->_model->getWebOrders();

		if( !empty( $aWebOrders ) ){

			array_walk( $aWebOrders, function( $aRawOrder, $sKey ) use ( &$aSetToMerged, &$aErrorIds, &$aErrorMessages ){

				try{

					$aSetToMerged[] = $aRawOrder['queue_id'];
					$aSalesOrder = json_decode( Netsuite_Crypt::decrypt( $aRawOrder['order_json'] ), true );

					$customer = Netsuite_Record::factory()->customer( $aSalesOrder['customer'] );

					if( !$customer->isOk() ){
						throw new Exception('Could Not Create Customer for LivePOS Merge');
					}

					$salesOrder = Netsuite_Record::factory()->salesOrder( $aSalesOrder['order'], $customer );

					if( !$salesOrder->isOk() ){
						throw new Exception('Could Not Create SalesOrder for LivePOS Merge');
					}

					$aSetToMerged[] = $aRawOrder['queue_id'];
					$this->_webOrders[] = $salesOrder;

				}catch ( Exception $e ){

					$aErrorIds[] = $aRawOrder['queue_id'];
					$aErrorMessages[ $aRawOrder['order_activa_id'] ] = $e->getMessage();
				}
			});

				if( !empty( $aSetToMerged ) ){
					
					$this->_model->updateToMerged( $aSetToMerged );
				}

				if( !empty( $aErrorIds ) ){
						
					$this->_model->updateToMergeError( $aErrorIds );
					// -> -> -> -> UPDATE ERRORS <- <- <- <-
					//$aErrorMessages
				}
		}
	}

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
					':order_activa_id' => ( $aWorkerData['web_items'] )? $aWorkerData['order_id'] .'-POS': $aWorkerData['order_id'],
					':order_json' => $aWorkerData['encrypted'] );
		}

		$this->_model->queueOrders( $aOrdersArray );
		$this->_model->updateIgnoredOrders( $aIgnoredOrders );

	}
}