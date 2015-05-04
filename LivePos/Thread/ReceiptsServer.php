<?php

class LivePos_Thread_ReceiptsServer {

	public $receiptIds = array();
	protected $_pool;
	private $_sessionId;
	private $_locationId;
	private $_transactionDate;

	public function __construct( array $aReceiptIDs, $sSessionId, $iLocationId, $dTransactionDate ){

		$this->_pool = new Thread_Pool( LIVEPOS_MAX_RECORDS );
		$this->receiptIds = $aReceiptIDs;
		$this->_sessionId = $sSessionId;
		$this->_locationId = $iLocationId;
		$this->_transactionDate = $dTransactionDate;
	}

	public function hasReceipts(){

		$bReturn = ( !empty( $this->receiptIds ) )? true: false;
		return( $bReturn );
	}


	public function poolReceipts() {

		if( !$this->hasReceipts() ){
			return;
		}

		foreach( $this->receiptIds as $iReceiptId ){

			$aWork[] = $tThread = $this->_pool->submit( new LivePos_LivePosReceipts( $iReceiptId, $this->_sessionId, $this->_locationId ) );
		}

		$this->_pool->shutdown();
		$this->_logReceipt();

		if( DEBUG ){
			foreach($this->_pool->workers as $worker) {
				print_r($worker->getData());
			}
		}
	}

	private function _logReceipt() {



		foreach($this->_pool->workers as $worker) {

			$aResults = $worker->getData();

			$aReceipts[] = array(
					':receipt_id' => $aResults['receiptId'],
					':receipt_type' => $aResults['receiptType'],
					':response_code' => $aResults['code'],
					':receipt_string' => $aResults['data'],
					':location_id' => $aResults['locationId'],
					':transaction_date' => $this->_transactionDate,
					':error_message' => $aResults['error'] );
		}

		$model = new LivePos_Db_Model();
		$model->insertReceipts( $aReceipts );
		$model = null;

	}
}