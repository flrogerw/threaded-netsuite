<?php 
/**
 * LivePOS Order Object
 *
 * @package Netsuite
 * @subpackage LivePOS
 * @author gWilli
 * @version 1.0
 * @copyright 2014
 * @name LivePOS Order
 */
/**
 * LivePOS Receipt to Netsuite Record Order Object
 *
 * Thread for Processing Receipts into Netsuite.  Captures Order, Discount and Payment Information
 * from LivePOS Receipt and Converts the Data into a Netsuite Order and Inserts into the Queue for Insertion
 * into Netsuite.
 *
 * @uses Configure
 * @uses LivePos_Maps_Map
 * @package Netsuite
 * @subpackage LivePOS
 * @final Can NOT Extend
 */
final class LivePos_Maps_Order extends LivePos_Maps_Map {

	public $authcode;
	public $billaddress;
	public $ccexpiredate;
	public $ccname;
	public $ccnumber;
	public $ccprocessor = 1;
	public $custbody_order_source;
	public $custbody_order_source_id;
	public $custbody_source_code;
	public $custbody_pos_auth_code;	
	public $custbody_pos_cash_total = 0;
	public $custbody_pos_cc_exp_date;
	public $custbody_pos_cc_number;
	public $custbody_pos_cc_total = 0;
	public $custbody_pos_custom_total = 0;
	public $custbody_pos_employee;
	public $custbody_pos_gc_code;
	public $custbody_pos_gc_total = 0;	
	public $custbody_pos_invoice;
	public $custbody_pos_location;
	public $custbody_pos_postranstime;
	public $custbody_pos_promo_code;
	public $custbody_pos_receipt;
	public $custbody_pos_receipt_date;
	public $custbody_pos_receipt_total = 0;
	public $custbody_pos_ref_num;
	public $custbody_pos_shipped_tax = 0;
	public $custbody_pos_shipping_charge = 0;
	public $custbody_pos_tax_total = 0;
	public $custbody_pos_trans_id;
	public $customform = 107;
	public $department;
	public $discountitem;
	public $discounttotal;
	public $discountrate = 0;
	public $entity;
	public $giftcertificateitem = array();
	public $handlingcost;
	public $ismultishipto = 'F';
	public $item;
	public $leadsource;
	public $location;
	public $orderstatus = 'B';
	public $otherrefnum;
	public $paymentmethod = 8;
	public $pnrefnum;
	public $recordtype = "salesorder";
	public $shipaddress;
	public $shipcomplete = 'T';
	public $shipmethod = 10;
	public $shippingcost;
	public $shipdate;
	public $taxtotal = 0;
	public $total = 0;
	public $trandate;

	protected $_employeeid;
	protected $_employeefirst;
	protected $_employeelast;
	protected $_postotal;
	protected $_customer_firstname;
	protected $_customer_lastname;
	protected $_paymentmethod_flag;
	protected $_location;

	protected $_mapArray = array(
			'dblTax1' => 'taxtotal',
			'dblGrandTotal' => 'total',
			'intInvoiceNumber' => 'custbody_pos_invoice',
			'intReceiptNumber' => 'custbody_pos_receipt',
			'strCustomerFirstName' => '_customer_firstname',
			'strCustomerLastName' => '_customer_lastname',
			'strPaymentTypeLabel' => '_paymentmethod_flag',
			'intEmployeeID' => '_employeeid',
			'strEmployeeFirstName' => '_employeefirst',
			'strEmployeeLastName' => '_employeelast',
			'strLocationName' => 'custbody_pos_location',
			'dtTransactionDate' => 'custbody_pos_postranstime');


	/**
	 *
	 * @access public
	 * @return void
	*/
	public function __construct( array $aOrder, $locationData, $sOrderId ) {

		parent::__construct();
		$this->_aData = $aOrder;
		$this->custbody_order_source_id = $sOrderId;
		$this->_map();
		$this-> _setInternalSources( $locationData );
		$this->_logic();
	}

	public function addItems( array $items ){

		$this->item = $items;
		$this->setNewTotal();
	}
	
	public function setFulFillmentTo( $sStatus = 'B' ){
		
		$this->orderstatus = $sStatus;
	}
	
	public function setCustomPaymentTotal( LivePos_Maps_Payment $oPayment  ){
		
		$this->custbody_pos_custom_total = $oPayment->getAmount();		
	}
	
	public function setOrderId( $sOrderId ){
		
		$this->custbody_order_source_id = $sOrderId;
	}
	
	public function setPosPromoCode( $sPromoCode ){
		
		$this->custbody_pos_promo_code = $sPromoCode;
	}

	public function setPosGcCode( $sGcCode ){
		
		$this->custbody_pos_gc_code = $sGcCode;	
	}
	
	public function setShippedTax( $fAmount ){
		
		$this->custbody_pos_shipped_tax += $fAmount;
	}
	
	public function setShippingCharge( $fAmount = 0 ){
		
		$this->custbody_pos_shipping_charge += $fAmount;
	}
	
	public function setCashTotal( $fCashTotal ){
		$this->custbody_pos_cash_total += $fCashTotal;
	}
	
	public function setCCTotal( $fCCTotal ){
		$this->custbody_pos_cc_total += $fCCTotal;
	}
	
	public function setGCTotal( $fGCTotal ){
		$this->custbody_pos_gc_total += $fGCTotal;
	}

	public function getInvoiceId(){

		return( $this->custbody_pos_invoice );
	}

	public function setMultiShipTo( $bIsMultiShipTo ){

		$this->ismultishipto = ( $bIsMultiShipTo )? true: false;
	}

	public function setGiftCert( LivePos_Maps_Payment $oPayment ){

		$this->giftcertificateitem[] = array('giftcertcode' => $oPayment->getGiftCertId()  );
	}

	public function getPaymentType(){

		return( $this->_paymentmethod_flag );
	}

	public function setCcData( LivePos_Maps_Payment $oPayment ){

		$this->custbody_pos_cc_exp_date = $oPayment->getCcExpire();
		$this->custbody_pos_cc_number = $oPayment->getCcNumber();
		$this->custbody_pos_auth_code = $oPayment->getAuthCode();
		$this->custbody_pos_ref_num = $oPayment->getTransactionId();
	}

	public function setPaymentType( $sPaymentType ){

		$this->_paymentmethod_flag = $sPaymentType;
	}

	public function setDiscount( $fDiscount, $sDiscountCode = NETSUITE_DEFAULT_DISCOUNT ){

		//$this->discounttotal = $fDiscount;
		$this->discountrate += ( $fDiscount * -1 );
		$this->discountitem = $sDiscountCode;
	}

	/**
	 * Always Returns the Order's Original SubTotal
	 */
	public function getPosTotal(){
		return( $this->_postotal );
	}

	public function getTotal(){

		return( $this->total );
	}

	public function getItems(){

		return( $this->item );
	}

	/**
	 *
	 */
	public function setNewTotal(){

		$this->total = 0;

		array_walk( $this->getItems(), function( $aItem, $sKey ){
			$this->total += ( $aItem['rate'] * $aItem['quantity'] );

		});
	}

	public function getTax(){
		return( $this->taxtotal );
	}

	private function _logic(){


		// Set Shipping/ Billing Dates
		$date = new DateTime( $this->custbody_pos_postranstime );
		$this->trandate = $this->shipdate = $date->format('m/d/Y');
		$this->custbody_pos_postranstime = $date->format('g:i a');
		$this->custbody_pos_receipt_date = $date->format('m/d/Y h:i:s a');
		
		// Define Employee
		$this->custbody_pos_employee = $this->_employeefirst . ' ' . $this->_employeelast;

		// Set Totals
		$this->custbody_pos_receipt_total = $this->total;
		$this->total = $this->_postotal = ( $this->total - $this->taxtotal );
		$this->custbody_pos_tax_total = $this->taxtotal;
	}

	private function _setInternalSources( $locationData ){

		$this->billaddress = $this->shipaddress = stripcslashes( $locationData['location_addresstxt']);
		$this->custbody_order_source = (int) $locationData['location_netsuite_order_source'];
		$this->location = (int) $locationData['location_netsuite_id'];
		$this->department = (int) $locationData['location_netsuite_department'];
		$this->leadsource = (int) $locationData['location_netsuite_lead'];
	}
}