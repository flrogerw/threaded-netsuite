<?php 

class LivePos_LivePosOrders extends Stackable {

	protected $_order;
	protected $_locationData;
	protected $_orderType;
	protected $_errors = array();

	public function __construct( $aOrder, $locationData ){

		$this->_order = json_decode( $aOrder['receipt_string'], true );
		$this->orderType = $aOrder['receipt_type'];
		$this->receiptId = $aOrder['receipt_id'];
		$this->_locationData = $locationData;
	}


	public function run(){

		spl_autoload_register(function ($sClass) {
			$sClass = str_replace( "_", "/", $sClass );
			include $sClass . '.php';
		});
		
			$this->worker->addData( array('receiptId' => $this->receiptId) );
			
			try{
				
				switch( $this->orderType ){

					case( 'SALE'):

						$customer = LivePos_Maps_MapFactory::create( 'customer', $this->_order, $this->_locationData );
						$customer = Netsuite_Record::factory()->customer( $customer->getPublicVars() );

						$order = LivePos_Maps_MapFactory::create( 'order', $this->_order, $this->_locationData );
						
						$items = new LivePos_Maps_ItemList( $this->_order[0]['enumProductsSold'], $this->_locationData );
						$order->addItems( $items->getItems() );
						$order = Netsuite_Record::factory()->salesOrder( $order->getPublicVars(), $customer );

						$this->worker->addData( array('encrypted' => $this->_getEncryptedJson( $customer, $order ) ) );
						$this->worker->addData( array('entityId' => $this->_locationData['location_entity'] ) );
						break;

					default:

						$this->_errors[] = 'Did Not Recognize Transaction Type: ' . $this->orderType;
						break;
				}
					

				$this->worker->addData( array('error' => implode( ',', $this->_errors ) ) );


			} catch( Exception $e ) {

				//Netsuite_Db_Model::logError( $e->getMessage() );
				$this->_errors[] = $e->getMessage();
				$this->worker->addData( array('error' => implode( ',', $this->_errors ) ) );

			}
	}
	
	private function _getEncryptedJson( Netsuite_Record_Customer $customer, Netsuite_Record_SalesOrder $order ){

		$aToEncrypt = array( 'order' => $order->getFields(), 'customer' => $customer->getFields() );
		//return(  json_encode( $aToEncrypt ) );
		return( Netsuite_Crypt::encrypt( json_encode( $aToEncrypt ) ) );
	}
}