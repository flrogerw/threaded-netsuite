<?php 

class LivePos_LivePosOrder extends Stackable {

	protected $_raworder;
	protected $_order;
	protected $_orderId;
	protected $_locationData;
	protected $_orderType;
	protected $_customer;
	protected $_items;
	protected $_discounts;
	protected $_payments;

	public function __construct( $sOrderId, $aOrder, $locationData ){

		$this->_raworder = json_decode( $aOrder['receipt_string'], true );
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

			$fDiscountTotal = 0;
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
							
						$items = LivePos_Maps_MapFactory::create( 'itemlist', $this->_raworder[0]['enumProductsSold'], $this->_locationData );

						// WEB Only Items or Empty Order
						if( !$items->hasItems() ){

							$this->worker->addData( array('ignore' => true ) );
							$errors[] = 'WEB Only Items or Empty Item List';
							break;
						}

						$customer = LivePos_Maps_MapFactory::create( 'customer', $this->_raworder, $this->_locationData );
						$order = LivePos_Maps_MapFactory::create( 'order', $this->_raworder, $this->_locationData, $this->_raworderId );

						$this->_processPayments( $order );
						$this->_processDiscounts( $items, $order);

						$order->addItems( $items->getItemsArray() );

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

	private function _processDiscounts( LivePos_Maps_Itemlist $items, LivePos_Maps_Order $order ){

		$bItemLevel;
		$discounts = LivePos_Maps_MapFactory::create( 'discountlist', $this->_raworder[0]['enumCouponDiscounts'] );

		if( $discounts->hasDiscounts() ){

			$items->popPreDiscountPrices();
			$order->setNewTotal( $items->getPreDiscountTotal() );
				

			array_walk( $discounts->getDiscounts(), function( $oDiscount, $sKey ) use ( &$order, &$items, &$bItemLevel ){

				$sSwitchCompare = ( LIVEPOS_LINE_ITEM_DISCOUNTS )? $oDiscount->getScope(): 'sale';

				switch( $sSwitchCompare ){

					case( 'sale' ):

						$fDiscountTotal = ( $items->getPreDiscountTotal() - $order->getSubTotal() );
						$order->setDiscount( $fDiscountTotal );
						$bItemLevel = false;
						break;

					case( 'item' ):

						$bItemLevel = true;
						break;
				}
			});
					
				$items->removeDiscount( $bItemLevel );
		}
	}

	public function _processPayments( LivePos_Maps_Order $order ){

		$payments = LivePos_Maps_MapFactory::create( 'paymentlist', $this->_raworder[0]['enumPayments'] );

		array_walk( $payments->getPayments(), function( $oPayment, $sKey ) use ( &$order ){

			switch( $oPayment->getType() ){
					
				case( 'CC' ):

					$order->setCcData( $oPayment );
					break;

				case( 'Cash' ):
				case( 'Check' ):
				case( 'Gift Card' ):
				case( 'Custom Payment' ):
				case( 'Coupon' ):
					break;
			}
		});

	}

	private function _getEncryptedJson( LivePos_Maps_Customer $customer, LivePos_Maps_Order $order ){

		$aToEncrypt = array( 'order' => $order->getPublicVars(), 'customer' => $customer->getPublicVars() );
		return(  json_encode( $aToEncrypt ) );
		//return( Netsuite_Crypt::encrypt( json_encode( $aToEncrypt ) ) );
	}
}