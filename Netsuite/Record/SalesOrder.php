<?php

class Netsuite_Record_SalesOrder extends Netsuite_Record_Base implements Netsuite_Interface_INetsuite {

	//public $customform = 107; // Standard Form
	public $customform = 129; // POS Form
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
	public $giftcertificateitem = array();
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
	
	public static function hasBeenProcessed( array $aNewOrders ){
		
		$oDb = new Netsuite_Db_Model();
		$aBeenProcessed = $oDb->hasBeenProcessed( $aNewOrders );
		return($aBeenProcessed);
	}

	protected function _setValues( array $aSalesOrder ) {

		foreach( $aSalesOrder as $key => $value ) {
			$this->$key = $value;
		}

		$this->entity = $this->_customer->entityid;
		$this->_tmp_items_list = $aSalesOrder['item'];
		
		try{
			
			// Create Item List
			$this->item = $this->setItemList();
			
			// Create Gift Certificate List
			$this->setGiftCertificates();

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
		$aSalesOrder['giftcertificateitem'] =  $this->giftcertificateitem;
		return( $aSalesOrder );
	}

	public function getJSON() {

		return( json_encode( $this->getSalesOrder() ) );
	}
	
	public function setGiftCertificates(){
		
		$aCerts = array();
		
		if( sizeof( $this->giftcertificateitem ) < 1 ){ return( $aCerts );}
		
		foreach( $this->giftcertificateitem as $aCert ){
			$oCert = Netsuite_Record::factory()->giftCertificate( $aCert );
			if( !$oCert->isOk() ) {
			
				$aErrors = $oCert->getErrors();
				$this->logError( 'Could NOT Create Gift Certificate( '. sizeof( $aErrors ) .' Errors): ' .  implode( ', ', $aErrors ) );
				return;
			}
			$aCerts[] = $oCert;
		}
		$this->giftcertificateitem = $aCerts;
	}

	public function setItemList() {

		$oItemList = new Netsuite_Record_ItemList( $this->_tmp_items_list, $this->location, $this->custentity_customer_source_id, $this->entity, $this->ismultishipto );

		if( !$oItemList->isOk() ) {

			$aErrors = $oItemList->getErrors();
			$this->logError( 'Could NOT Create ItemList( '. sizeof( $aErrors ) .' Errors): ' .  implode( ', ', $aErrors ) );
			return;
		}

		return( $oItemList->getItemList() );
	}
}