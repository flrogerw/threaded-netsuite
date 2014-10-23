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

		if( DEBUG ){
			foreach($this->_pool->workers as $worker) {
				printf("%s made %d attempts ...\n", $worker->getName(), $worker->getAttempts());
				print_r($worker->getData());
					
			}
		}
	}
}