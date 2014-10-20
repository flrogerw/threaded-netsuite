<?php 

class LivePos_LivePos extends Stackable {

	protected $_receiptId;
	protected $_sessionId;

	public function __construct( $iReceiptId, $sSessionId ){

		$this->_receiptId = $iReceiptId;
		$this->_sessionId = $sSessionId;

	}


	public function run(){

		spl_autoload_register(function ($sClass) {
			$sClass = str_replace( "_", "/", $sClass );
			include $sClass . '.php';
		});

			try{
				$this->worker->addData( $this->_receiptId );
				
				$call = new LivePos_Job_GetRecord( false );

				$call->sendRequest('GetReceiptDetails', $this->_sessionId, array('intReceiptNumber' => $this->_receiptId));
				
				if( $call->isOk() ){
					
					$aResponse = $call->getResponse();
					$this->worker->addData( $aResponse['code'] );
					$this->worker->addData( $aResponse['error'] );
					$this->worker->addData( $aResponse['data'] );
				}

			} catch( Exception $e ) {
				//Netsuite_Db_Model::logError( $e->getMessage() );
				$results['system']['error'] = $e->getMessage();
				$this->worker->addData( $call->getResponse() );
			}

			$this->_logResults();
	}
	
	protected function _logResults() {
	
		$model = new LivePos_Db_Model();
		$sSystemError = '';
	
		$aResults = $this->worker->getData();
	
		$aUpdateData = array(
				':receipt_id' => $aResults[0],
				':response_code' => $aResults[1],
				':receipt_string' => $aResults[3],
				':error_message' => $aResults[2],
		);
	
		$model->insertReceipt( $aUpdateData );

	}
	

}