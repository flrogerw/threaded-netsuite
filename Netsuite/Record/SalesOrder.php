<?php

class Netsuite_Record_SalesOrder extends Netsuite_Record_Base implements Netsuite_Interface_INetsuite {

	public $customform = 107;
	public $recordtype = "salesorder";

	public $authcode;
	public $billaddress;
	public $ccapproved = true;
	public $ccname;
	public $ccnumber;
	public $cczipcode;
	public $ccexpiredate;
	public $ccprocessor;
	public $custbody_activa_order_number;
	public $custbody_comments;
	public $custbody_event_date;
	public $custbody_order_source;
	public $custbody_order_source_id; // REMOVE WHEN LIVE
	public $custbody_pickticketnotes;
	public $custbody_pos_trans_id;
	public $custbody_source_code;
	public $custbody_textrequired = false;
	public $custbody_web_discount_code;
	public $custbody_web_payment_error;
	public $custentity_customer_source_id;
	public $department;
	public $discountitem = null;
	public $discounttotal = 0;
	public $discountrate = 0;
	public $email;
	public $entity;
	public $excludecommission = false;
	public $getauth = false;
	public $handlingcost = 0;
	public $ismultishipto = true;
	public $istaxable = true;
	public $item = array();
	public $leadsource;
	public $location;
	public $message;
	//public $orderstatus;
	public $otherrefnum;
	public $paymentmethod;
	public $pnrefnum;
	public $price = -1;
	public $salesrep;
	public $shipaddress;
	public $shipcomplete = false;
	public $shipdate;
	//public $shipmethod;
	public $shippingcost = 0;
	public $taxrate;
	public $taxtotal = 0;
	public $tobeemailed = false;
	public $tobefaxed = false;
	public $tobeprinted;
	public $total = 0;
	public $trandate;
	public $tranid;

	//public $shipoverride= true;

	protected $_source;
	protected $_itemlocation;

	private $_ccexpiremonth;
	private $_ccexpireyear;
	private $_customer;
	private $_gcamount = 0;
	private $_paymentmethod_flag;
	private $_promoamount = 0;
	private $_promocode;
	private $_tmp_items_list = array();


	public function __construct( array $aSalesOrder, Netsuite_Record_Customer $oCustomer ) {

		try{

			$this->_customer = $oCustomer;

			$aSalesOrder = ( array_merge( get_object_vars( $this ), $aSalesOrder ) );

			$this->_setValues( $aSalesOrder );

			if( !$this->_validate( $this->getFields() ) ) {
				return;
			}

			$this->_forwardWarnings( get_class() );
			$this->_forwardErrors( get_class() );

		} catch( Exception $e ) {
			self::logError( 'Could NOT Create SalesOrder: ' . $e->getMessage() );
			return;
		}
	}

	protected function _setValues( array $aSalesOrder ) {

		foreach( $aSalesOrder as $key => $value ) {
			$this->$key = $value;
		}

		$this->_tmp_items_list = $aSalesOrder['item'];

		try{
			$oModel = new Netsuite_Db_Model();

			// Set entity to customer entityid
			$this->entity = $this->_customer->entityid;

			//Set Sales Order Customer's Activa Number
			$this->custentity_customer_source_id = $this->_customer->custentity_customer_source_id;

			// Set Shipdate 3 working days in advance
			//$this->shipdate = date( 'm/d/Y', strtotime( $this->trandate . ' +3 Weekday') );
			//$this->trandate = date( 'm/d/Y', strtotime( $this->trandate ) );

			// Set Shipping Methhod
			//$sLocation = $this->_customer->addressbook['shipping']['state'];
			//$this->shipmethod = (int) $oModel->getShippingMethod( $sLocation, $this->shipmethod );

			// Discount Logic  ADD PUSH TO SANATIZE LOGIC
			//$this->custbody_source_code = ( $this->_promocode == null )?$this->custbody_source_code: $this->_promocode;

			//if( intval( $this->_promoamount ) != 0 || $this->_gcamount != 0 ) {
			//$this->discountitem = $oModel->callXrefTable( 'DiscountType', 'webdiscount' );
			//$this->discounttotal = ( $this->_promoamount + $this->_gcamount );
			//$this->discountrate = $this->discounttotal;
			//}

			// Set Payment Method Record Reference Id
			//switch( $this->_paymentmethod_flag ){

			//case( 'creditcard' ):
			//$this->paymentmethod = $oModel->callXrefTable( 'PaymentMethod', $this->paymentmethod );
			//break;

			//default:
			//$this->paymentmethod = $oModel->callXrefTable( 'PaymentMethod', $this->_paymentmethod_flag );
			//break;
			//}

			// Set CC Expire Date  & CC Zip
			//if( $this->ccnumber != '' ) {
			//$this->ccexpiredate = sprintf("%02d", $this->_ccexpiremonth) . '/' . $this->_ccexpireyear;
			//$this->cczipcode = $this->_customer->addressbook['billing']['zip'];
			//}

			// Set Source Codes ( department, leadsource, location, etc... )
			//$this->_setSources();

			// Billing and Shipping Address Strings
			//$this->billaddress = ( isset( $this->_customer->addressbook['billing'] ) )? $this->getAddressString( $this->_customer->addressbook['billing'] ): $this->getAddressString( $oModel->getStoreAddress( $this->location ) );

			switch( true ){
					
				// Look at AddressBook for Shipping Address First
				case( isset( $this->_customer->addressbook['shipping'] ) ):
					$aAddressString = $this->_customer->addressbook['shipping'];
					break;

					// Look for Shipping Address in Items List
				default:
					foreach( $this->_tmp_items_list as $aItem ){
						$oAddress = new Netsuite_Record_Address( $aItem );
						if( $oAddress->isOk() ){
							$aAddressString = $oAddress->getAddress();
						}
					}
					break;
			}

			// Billing and Shipping Address Strings
			if( isset( $aAddressString ) ){
				$this->shipaddress = $this->getAddressString($aAddressString);
			}else{
				$sLocation = $oModel->getStoreAddress( $this->location );
				if( $sLocation === false ){
					throw new Exception( 'Can NOT set Shipping Address to Store Location using: ' . $this->location );
				}
					
			 $this->shipaddress = $this->getAddressString( $sLocation );
			}

			if( isset( $this->_customer->addressbook['billing'] ) ){
				$this->billaddress = $this->getAddressString( $this->_customer->addressbook['billing'] );
			}else{
				$sLocation = $oModel->getStoreAddress( $this->location );
				if( $sLocation === false ){
					throw new Exception( 'Can NOT set Billing Address to Store Location using: ' . $this->location );
				}
					
				$this->billaddress = $this->getAddressString( $sLocation );
			}
			// Create Item List
			$this->item = $this->setItemList();

		} catch( Exception $e ) {
			self::logError( 'Could NOT Create SalesOrder: ' . $e->getMessage() );
			return;
		}
	}

	protected function _validate( $aSalesOrder ) {

		$this->_filter = Netsuite_Filter::factory()->salesOrder( $this->getFields() );

		if(!$this->_filter->isOk()){

			$this->_forwardErrors( get_class() );
			$this->_forwardWarnings( get_class() );
			return( false );
		}

		return( true );
	}

	public function getSalesOrder() {

		$aSalesOrder =  $this->_filter->optimizeValues( $this->_filter->getRecord() );
		$aSalesOrder['item'] =  $this->item;

		return( $aSalesOrder );
	}

	public function getJSON() {

		return( json_encode( $this->getSalesOrder() ) );
	}

	public function setItemList() {

		$oItemList = new Netsuite_Record_ItemList( $this->_tmp_items_list, $this->location, $this->custentity_customer_source_id, $this->entity );

		if( !$oItemList->isOk() ) {

			$aErrors = $oItemList->getErrors();
			$this->logError( 'Could NOT Create ItemList( '. sizeof( $aErrors ) .' Errors): ' .  implode( ', ', $aErrors ) );
			return;
		}

		return( $oItemList->getItemList() );
	}
}