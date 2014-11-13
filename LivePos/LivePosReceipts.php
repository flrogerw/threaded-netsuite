<?php 

class LivePos_LivePosReceipts extends Stackable {

	protected $_receiptId;
	protected $_sessionId;
	protected $_errors = array();
	protected $_locationId;

	public function __construct( $iReceiptId, $sSessionId, $iLocationId ){

		$this->_receiptId = $iReceiptId;
		$this->_sessionId = $sSessionId;
		$this->_locationId = $iLocationId;
	}


	public function run(){

		spl_autoload_register(function ($sClass) {
			$sClass = str_replace( "_", "/", $sClass );
			include $sClass . '.php';
		});

			try{
				$this->worker->addData( array('receiptId' => $this->_receiptId) );
				$this->worker->addData( array('locationId' => $this->_locationId) );

				$call = new LivePos_Job_GetRecord( false );

				$call->sendRequest('GetReceiptDetails', $this->_sessionId, array('intReceiptNumber' => $this->_receiptId));

				if( $call->isOk() ){

					$aResponse = $call->getResponse();
					$this->_getReceiptType( $aResponse );
					$this->worker->addData( array('code' => $aResponse['code']) );
					$this->worker->addData( array('data' => $aResponse['data']) );
				}else{

					$aResponse = $call->getResponse();
					$this->worker->addData( array('code' => $aResponse['code']) );
					$this->worker->addData( array('data' => $aResponse['data']) );
					$this->worker->addData( array('error' => implode( ',', $call->getErrors() ) ) );
				}

			} catch( Exception $e ) {

				LivePos_Db_Model::logError( $e->getMessage() );
				$this->worker->addData( array('receiptId' => $this->_receiptId) );
				$this->worker->addData( array('code' => $aResponse['code'] ));
				$this->worker->addData( array('data' => $call->getResponse()) );
				$this->worker->addData( array('error' =>  $e->getMessage() ) );

			}

	}


	private function _getReceiptType( array $aResponse ){

		$aReceiptArray = current( json_decode($aResponse['data'], true ) );

		if( isset( $aReceiptArray['intTransactionTypeID'] ) ) {

			$this->worker->addData( array( 'receiptType' => $aReceiptArray['intTransactionTypeID'] ) );
		}else{
			$this->worker->addData( array( 'receiptType' => 999 ) );
			$this->_errors[] = 'Could NOT get Receipt Transaction Type';
		}


	}

}