<?php

class LivePos_Thread_Server {

	public $orderIDs;
	protected $_pool;
	private $_sessionId;
	private $_locationId;

	public function __construct( array $aOrderIds, $sSessionId, $iLocationId ){

		$this->_pool = new Thread_Pool( MAX_THREADS );
		$this->orderIDs = $aOrderIds;
		$this->_sessionId = $sSessionId;
		$this->_locationId = $iLocationId;
	}

	public function hasOrders(){

		$bReturn = ( !empty( $this->orderIDs ) )? true: false;
		return( $bReturn );
	}

	public function poolOrders() {

		foreach( $this->orderIDs as $iOrderId ){

			$aWork[] = $tThread = $this->_pool->submit( new LivePos_LivePos( $iOrderId, $this->_sessionId, $this->_locationId ) );

		}

		$this->_pool->shutdown();
		$this->_queueOrders();

		if( DEBUG ){
			foreach($this->_pool->workers as $worker) {
				print_r($worker->getData());
			}
		}
	}

	private function _queueOrders(){

		$oModel = new LivePos_Db_Model();
		$aOrdersArray = array();

		foreach( $this->_pool->workers as $worker ) {
				
			$aWorkerData = $worker->getData();
			$aOrdersArray[] = array( 
					':customer_activa_id' => $aWorkerData['entityId'],
					':order_activa_id' => 'POS' . $aWorkerData['receiptId'],
					':order_json' => $aWorkerData['encrypted']
			 );
		}
		
		$oModel->queueOrders( $aOrdersArray );
	}
}