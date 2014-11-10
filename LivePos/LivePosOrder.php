<?php 
/**
 * LivePOS Order Processor
 *
 * @package Netsuite
 * @subpackage LivePOS
 * @author gWilli
 * @version 1.0
 * @copyright 2014
 * @name LivePOS Order
 */
/**
 * LivePOS Receipt to Netsuite Record Process
 *
 * Thread for Processing Receipts into Netsuite.  Captures Order, Discount and Payment Information
 * from LivePOS Receipt and Converts the Data into a Netsuite Order and Inserts into the Queue for Insertion
 * into Netsuite.
 *
 * @uses Configure
 * @uses Stackable
 * @package Netsuite
 * @subpackage LivePOS
 * @final Can NOT Extend
 */
final class LivePos_LivePosOrder extends Stackable {

	protected $_raworder;
	protected $_order;
	protected $_orderId;
	protected $_locationData;
	protected $_orderType;
	protected $_orderToMerge;



	public function __construct( $sOrderId, $aOrder, $locationData, $sOrderToMerge = null ){

		$this->_raworder =  current( json_decode( $aOrder['receipt_string'], true ) );
		$this->orderType = $aOrder['receipt_type'];
		$this->receiptId = $aOrder['receipt_id'];
		$this->_locationData = $locationData;
		$this->_orderId = $sOrderId;
		$this->_orderToMerge = $sOrderToMerge;
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

					case( 999 ): // Error
						$this->worker->addData( array('ignore' => true ) );
						$errors[] = 'Error Code 999';
						break;

					case( 2 ): // EXCHANGE ???
						$this->worker->addData( array('ignore' => true ) );
						$errors[] = 'Exchange';
						break;

					case( 1 ): // REFUND
						$this->worker->addData( array('ignore' => true ) );
						$errors[] = 'Refund';
						break;
							
					case( 0 ): // Sale
							
						$items = LivePos_Maps_MapFactory::create( 'itemlist', $this->_raworder['enumProductsSold'], $this->_locationData );

						// WEB Only Items or Empty Order
						if( !$items->hasItems() ){

							$this->worker->addData( array('ignore' => true ) );
							$errors[] = 'WEB Only Items or Empty Item List';
							break;
						}

						$customer = LivePos_Maps_MapFactory::create( 'customer', $this->_raworder, $this->_locationData );


						$order = LivePos_Maps_MapFactory::create( 'order', $this->_raworder, $this->_locationData, $this->_orderId );

						$discounts = LivePos_Maps_MapFactory::create( 'discountlist', $this->_raworder['enumCouponDiscounts'] );
						$payments = LivePos_Maps_MapFactory::create( 'paymentlist', $this->_raworder['enumPayments'] );
						
						$this->_processPayments( $order, $payments, $discounts );

						if( $discounts->hasDiscounts() ){

							$items->popPreDiscountPrices();		
						}

						if( $this->_orderToMerge != null ){
	
							$aOrderToMerge = json_decode( $this->_orderToMerge, true );
							$order->setMultiShipTo( true );
								
							array_walk( $aOrderToMerge['order']['item'], function( $aItem, $sKey ) use ( &$items ){
									
								$item = LivePos_Maps_MapFactory::create( 'item', $aItem, $this->_locationData, true );
								$items->addItem( $item );
							});
						}
						
						$order->addItems( $items->getItemsArray() );
						//$order->setNewTotal( $items->getTotal() );
						$this->_processDiscounts( $order, $items, $discounts );
						
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

	private function _processDiscounts( LivePos_Maps_Order $order, LivePos_Maps_Itemlist $items, LivePos_Maps_Discountlist $discounts ){

		$bItemLevel;
		
		if( $discounts->hasDiscounts() ){

			array_walk( $discounts->getDiscounts(), function( $oDiscount, $sKey ) use ( &$order, &$items, &$discounts, &$bItemLevel ){

				// Check for 'use line item discount' flag
				$sSwitchCompare = ( LIVEPOS_LINE_ITEM_DISCOUNTS )? $oDiscount->getScope(): 'sale';

				switch( $sSwitchCompare ){

					case( 'sale' ):

						$fDiscountAmount = $oDiscount->getDiscountTotal( $order->getTotal() );
						$order->setDiscount( $fDiscountAmount );
						$bItemLevel = false;
						break;

					case( 'item' ):
						
						$items->applyDiscount( $oDiscount );
						$order->addItems( $items->getItemsArray() );
						break;

					case( 'category' ):
						break;
				}
			});
					
				//$items->removeDiscount( $bItemLevel );
		}
	}

	public function _processPayments( LivePos_Maps_Order $order, LivePos_Maps_Paymentlist $payments, LivePos_Maps_Discountlist $discounts ){

		array_walk( $payments->getPayments(), function( $oPayment, $sKey ) use ( &$order, &$payments, &$discounts ){

			switch( $oPayment->getTypeId() ){
					
				case( 2 ): // Credit Card

					$order->setCcData( $oPayment );
					break;

				case( 8 ): // Gift Card

					$order->setGiftCert( $oPayment );
					break;

				case( 1 ): // Cash
				case( 3 ): // Check
				case( 5 ): // Split -- Order Level Only
				case( 9 ): // Custom Payment
					break;

				case( 7 ): // Coupon
					$discounts->updateDiscountTotal( $oPayment->getAmount() );
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