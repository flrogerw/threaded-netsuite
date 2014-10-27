<?php

class LivePos_Thread_OrderServer {

	private $_orders;
	protected $_pool;
	private $_locationsData = array();
	private $_currentOrders = array();

	public function __construct(){

		$this->_pool = new Thread_Pool( MAX_ORDER_RECORDS );
		$this->_getPosOrders();
		$this->_getCurrentOrders();
	}

	public function hasOrders(){

		$bReturn = ( !empty( $this->_orders ) )? true: false;
		return( $bReturn );
	}


	public function poolOrders() {

		foreach( $this->_orders as $aOrder ){

			$sOrderId = $this->_getOrderId( $aOrder );
			$aLocation = $this->_getLocation( $aOrder['location_id'], $sOrderId );
		
			$aWork[] = $tThread = $this->_pool->submit( new LivePos_LivePosOrders( $aOrder, $aLocation ) );
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

	private function _getCurrentOrders(){

		foreach( $this->_orders as $aOrder ){
				
			$currentOrders[] = $this->_getOrderId( $aOrder );
		}

		$model = new LivePos_Db_Model();
		$this->_currentOrders = $model->getCurrentOrders( $currentOrders );
		$model = null;
	}

	private function _getLocation( $iLocationId, $sOrderId ){

		if( !isset( $this->_locationsData[ $iLocationId ] ) ){

			$model = new LivePos_Db_Model();
			$this->_locationsData[ $iLocationId ] = $model->getEntity( $iLocationId );
			$model = null;
		}
		
		$aTempLocation = $this->_locationsData[ $iLocationId ];
		
		if( in_array( $sOrderId, array_keys( $this->_currentOrders ) ) ){
			$aTempLocation['location_entity'] = $this->_currentOrders[ $sOrderId ];
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

		foreach( $this->_pool->workers as $worker ) {

			$aWorkerData = $worker->getData();
			$aOrdersArray[] = array(
					':customer_activa_id' => $aWorkerData['entityId'],
					':order_activa_id' => 'POS_' . $aWorkerData['receiptId'],
					':order_json' => $aWorkerData['encrypted']
			);
		}

		$oModel = new LivePos_Db_Model();
		$oModel->queueOrders( $aOrdersArray );
		$oModel = null;
	}
}