<?php 

class LivePos_LivePos extends Stackable {

	protected $_receiptId;
	protected $_sessionId;
	protected $_locationId;
	protected $_errors = array();

	public function __construct( $iReceiptId, $sSessionId, $locationData ){

		$this->_receiptId = $iReceiptId;
		$this->_sessionId = $sSessionId;
		$this->_locationData = $locationData;
	}


	public function run(){

		spl_autoload_register(function ($sClass) {
			$sClass = str_replace( "_", "/", $sClass );
			include $sClass . '.php';
		});

			try{
				$this->worker->addData( array('receiptId' => $this->_receiptId) );

				$call = new LivePos_Job_GetRecord( false );

				$call->sendRequest('GetReceiptDetails', $this->_sessionId, array('intReceiptNumber' => $this->_receiptId));

				if( $call->isOk() ){

					$aResponse = $call->getResponse();
					$this->worker->addData( array('code' => $aResponse['code']) );
					$this->worker->addData( array('data' => $aResponse['data']) );

					if( $aResponse['code'] == 200 ){

						$aOrderData = json_decode( $aResponse['data'], true );

						$order = LivePos_Maps_MapFactory::create( 'order', $aOrderData, $this->_locationData );
						$items = new LivePos_Maps_ItemList( $aOrderData[0]['enumProductsSold'] );
						$order->addItems( $items->getItems() );
						//echo($order->getJson() . "\n");
						echo( Netsuite_Crypt::encrypt( $order->getJson() ) . "\n" );
					}

					$this->worker->addData( array('error' => implode( ',', $this->_errors ) ) );
				}

			} catch( Exception $e ) {

				//Netsuite_Db_Model::logError( $e->getMessage() );
				$this->worker->addData( array('receiptId' => $this->_receiptId) );
				$this->worker->addData( array('code' => $aResponse['code'] ));
				$this->worker->addData( array('data' => $call->getResponse()) );
				$this->worker->addData( array('error' => $e->getMessage()) );
			}


			$this->_logReceipt();
	}


	protected function _logReceipt() {

		$model = new LivePos_Db_Model();
		$sSystemError = '';

		$aResults = $this->worker->getData();

		$aUpdateData = array(
				':receipt_id' => $aResults['receiptId'],
				':response_code' => $aResults['code'],
				':receipt_string' => $aResults['data'],
				':error_message' => $aResults['error'],
		);

		$model->insertReceipt( $aUpdateData );

	}


}