<?php 

class LivePos_LivePosOrder extends Stackable {

	protected $_order;
	protected $_orderId;
	protected $_locationData;
	protected $_orderType;

	public function __construct( $sOrderId, $aOrder, $locationData ){

		$this->_order = json_decode( $aOrder['receipt_string'], true );
		$this->orderType = $aOrder['receipt_type'];
		$this->receiptId = $aOrder['receipt_id'];
		$this->_locationData = $locationData;
		$this->_orderId = $sOrderId;
	}


	public function run(){

		spl_autoload_register(function ($sClass) {
			$sClass = str_replace( "_", "/", $sClass );
			include $sClass . '.php';
		});

			$errors = array();
			$this->worker->addData( array('receiptId' => $this->receiptId) );
			$this->worker->addData( array('order_id' => $this->_orderId ) );

			try{

				switch( $this->orderType ){

					case('ERROR'):
						$this->worker->addData( array('ignore' => true ) );
						break;

					case('EXCHANGE'):
						$this->worker->addData( array('ignore' => true ) );
						break;

					case('REFUND'):
						$this->worker->addData( array('ignore' => true ) );
						break;
							
					case( 'SALE'):
							
						$items = LivePos_Maps_MapFactory::create( 'itemlist', $this->_order[0]['enumProductsSold'], $this->_locationData );

						// WEB Only Items or Empty Order
						if( !$items->hasItems() ){
							$this->worker->addData( array('ignore' => true ) );
							$errors[] = 'WEB Only Items or Empty Item List';
							break;
						}

						$customer = LivePos_Maps_MapFactory::create( 'customer', $this->_order, $this->_locationData );
						$customer = Netsuite_Record::factory()->customer( $customer->getPublicVars() );

						$order = LivePos_Maps_MapFactory::create( 'order', $this->_order, $this->_locationData, $this->_orderId );

						$discounts = LivePos_Maps_MapFactory::create( 'discountlist', $this->_order[0]['enumCouponDiscounts']);
						
						if( $discounts->hasDiscounts() ){
							
							$items->popPreDiscountPrices();
							$discountTotal = ( $items->getPreDiscountTotal() - $order->getSubTotal() );
							$order->setNewTotal( $items->getPreDiscountTotal() );
							$order->setDiscount( $discountTotal );
							$items->removeDiscount();
						}

						$order->addItems( $items->getItemsArray() );
						//$order = Netsuite_Record::factory()->salesOrder( $order->getPublicVars(), $customer );
						

						$this->worker->addData( array('encrypted' => $this->_getEncryptedJson( $customer, $order ) ) );
						$this->worker->addData( array('entityId' => $this->_locationData['location_entity'] ) );
						$this->worker->addData( array('web_items' => $items->hasWebItems ) );
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

	private function _getEncryptedJson( Netsuite_Record_Customer $customer, LivePos_Maps_Order $order ){

		//$aToEncrypt = array( 'order' => $order->getFields(), 'customer' => $customer->getFields() );
		$aToEncrypt = array( 'order' => $order->getPublicVars(), 'customer' => $customer->getFields() );
		//return(  json_encode( $aToEncrypt ) );
		return( Netsuite_Crypt::encrypt( json_encode( $aToEncrypt ) ) );
	}
}