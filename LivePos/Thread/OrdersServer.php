<?php

class LivePos_Thread_OrdersServer {

	private $_orders = array();
	protected $_pool;
	private $_locationsData = array();
	private $_webOrders = array();

	public function __construct(){

		$this->_pool = new Thread_Pool( MAX_ORDER_RECORDS );
		$this->_getPosOrders();
		$this->_getWebOrders();
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

		$aOrderData = json_decode( $aOrder['receipt_string'], true );
		return( 'POS_' . $aOrderData[0]['intReceiptNumber']);
		//return( $aOrderData[0]['strActivaNumber'] );
	}

	private function _getWebOrders(){

		$currentOrders = array();
		
		foreach( $this->_orders as $aOrder ){

			$currentOrders[] = $this->_getOrderId( $aOrder );
		}

		$model = new LivePos_Db_Model();
		$this->_webOrders = $model->getWebOrders( $currentOrders );
		$model = null;
	}

	private function _getLocation( $iLocationId, $sOrderId ){

		if( !isset( $this->_locationsData[ $iLocationId ] ) ){

			$model = new LivePos_Db_Model();
			$this->_locationsData[ $iLocationId ] = $model->getEntity( $iLocationId );
			$model = null;
		}

		$aTempLocation = $this->_locationsData[ $iLocationId ];

		if( in_array( $sOrderId, array_keys( $this->_webOrders ) ) ){
			$aTempLocation['location_entity'] = $this->_webOrders[ $sOrderId ];
		}

		return( $aTempLocation );
	}

	private function _getPosOrders(){

		$model = new LivePos_Db_Model();
		$this->_orders = $model->getPosOrders( LIVEPOS_MAX_PROCESSED );
		$model = null;
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
		
		$oModel = new LivePos_Db_Model();
		$oModel->queueOrders( $aOrdersArray );
		$oModel->updateIgnoredOrders( $aIgnoredOrders );
		$oModel = null;
	}
}