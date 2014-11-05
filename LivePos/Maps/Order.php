<?php 
class LivePos_Maps_Order extends LivePos_Maps_Map {

	public $authcode;
	public $billaddress;
	public $ccexpiredate;
	public $ccname;
	public $ccnumber;
	public $ccprocessor = 1;
	public $custbody_order_source;
	public $custbody_order_source_id;
	public $custbody_source_code;
	public $custbody_pos_trans_id;
	public $custbody_pos_postranstime;
	public $customform = 107;
	public $department;
	public $discountitem;
	public $discounttotal;
	public $discountrate;
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

	protected $_subtotal;
	protected $_customer_firstname;
	protected $_customer_lastname;
	protected $_paymentmethod_flag;
	protected $_location;

	protected $_mapArray = array(
			'dblTax1' => 'taxtotal',
			'dblGrandTotal' => 'total',
			'intInvoiceNumber' => 'otherrefnum',
			'strCustomerFirstName' => '_customer_firstname',
			'strCustomerLastName' => '_customer_lastname',
			'strPaymentTypeLabel' => '_paymentmethod_flag',
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
	}

	
	public function setGiftCert( LivePos_Maps_Payment $oPayment ){
		
		$this->giftcertificateitem[] = array('giftcertcode' => $oPayment->getGiftCertId()  );
	}
	
	public function getPaymentType(){

		return( $this->_paymentmethod_flag );
	}
	public function setCcData( LivePos_Maps_Payment $oPayment ){

		//$this->ccexpiredate = $oPayment->getCcExpire();
		//$this->ccname = $this->_customer_firstname . ' ' . $this->_customer_lastname;
		//$this->ccnumber = $oPayment->getCcNumber();
		//$this->authcode =$oPayment->getAuthCode();
		$this->custbody_pos_trans_id = $oPayment->getTransactionId();
		//$this->cczipcode = 11111;
		//$this->pnrefnum = $oPayment->getTransactionId();
	}

	public function setPaymentType( $sPaymentType ){

		$this->_paymentmethod_flag = $sPaymentType;
	}

	public function setDiscount( $fDiscount, $sDiscountCode = NETSUITE_DEFAULT_DISCOUNT ){

		//$this->discounttotal = $fDiscount;
		$this->discountrate = ( $fDiscount * -1 );
		$this->discountitem = $sDiscountCode;
	}

	/**
	 * Always Returns the Order's Original SubTotal
	 */
	public function getSubTotal(){
		return( $this->_subtotal );
	}

	/**
	 *
	 */
	public function setNewTotal( $fTotal ){
		$this->total = $fTotal;
	}

	public function getTax(){
		return( $this->taxtotal );
	}

	private function _logic(){


		// Set Shipping/ Billing Dates
		$date = new DateTime( $this->custbody_pos_postranstime );
		$this->trandate = $this->shipdate = $date->format('m/d/Y');

		$this->custbody_pos_postranstime = $date->format('g:i a');

		// Set Total
		$this->total = $this->_subtotal = ( $this->total - $this->taxtotal );
	}

	private function _setInternalSources( $locationData ){

		$this->billaddress = $this->shipaddress = stripcslashes( $locationData['location_addresstxt']);
		$this->custbody_order_source = (int) $locationData['location_netsuite_order_source'];
		$this->location = (int) $locationData['location_netsuite_id'];
		$this->department = (int) $locationData['location_netsuite_department'];
		$this->leadsource = (int) $locationData['location_netsuite_lead'];
	}
}