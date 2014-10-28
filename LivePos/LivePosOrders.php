<?php 

class LivePos_LivePosOrders extends Stackable {

	protected $_order;
	protected $_locationData;
	protected $_orderType;

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
		
			$errors = array();
			$this->worker->addData( array('receiptId' => $this->receiptId) );
			
			try{
				
				switch( $this->orderType ){

					case( 'SALE'):
						
						$items = new LivePos_Maps_ItemList( $this->_order[0]['enumProductsSold'], $this->_locationData );
						
						// WEB Only Items
						if( !$items->hasItems() ){
							$this->worker->addData( array('ignore' => true ) );
							$errors[] = 'WEB Only Items or Empty Item List';
							break;
						}

						$customer = LivePos_Maps_MapFactory::create( 'customer', $this->_order, $this->_locationData );
						$customer = Netsuite_Record::factory()->customer( $customer->getPublicVars() );

						$order = LivePos_Maps_MapFactory::create( 'order', $this->_order, $this->_locationData );
						$order->addItems( $items->getItems() );
						$order = Netsuite_Record::factory()->salesOrder( $order->getPublicVars(), $customer );

						$this->worker->addData( array('encrypted' => $this->_getEncryptedJson( $customer, $order ) ) );
						$this->worker->addData( array('entityId' => $this->_locationData['location_entity'] ) );
						break;

					default:

						$errors[] = 'Did Not Recognize Transaction Type: ' . $this->orderType;
						break;
				}

				$sFlatErrors = implode( ',', $errors );
				$this->worker->addData( array('error' => $sFlatErrors ) );


			} catch( Exception $e ) {

				LivePos_Db_Model::logError( $e );
				$this->worker->addData( array('error' => $e->getMessage() ) );

			}
	}
	
	private function _getEncryptedJson( Netsuite_Record_Customer $customer, Netsuite_Record_SalesOrder $order ){

		$aToEncrypt = array( 'order' => $order->getFields(), 'customer' => $customer->getFields() );
		//return(  json_encode( $aToEncrypt ) );
		return( Netsuite_Crypt::encrypt( json_encode( $aToEncrypt ) ) );
	}
}