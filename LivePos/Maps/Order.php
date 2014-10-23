<?php 
class LivePos_Maps_Order extends LivePos_Maps_Map {

	public $authcode;
	public $billaddress;
	public $ccexpiredate;
	public $ccname;
	public $ccnumber;
	public $ccprocessor = 1;
	public $custbody_order_source;
	public $custbody_order_source_id = "FTEST";
	public $custbody_source_code;
	public $customform = 107;
	public $department;
	public $entity;
	public $item;
	public $leadsource;
	public $location;
	public $orderstatus = 'B';
	public $otherrefnum;
	public $paymentmethod;
	public $pnrefnum;
	public $shipaddress;
	public $taxtotal;
	public $total;
	public $trandate;

	protected $_source; // convert to NS ID;
	protected $_aData;
	protected $_paymentmethod_flag;

	protected $_mapArray = array(
			'intLocationID'  => '_source', // convert to NS ID
			//'strFNUMBER' => 'custbody_order_source_id',
			'dtTransactionDate' => 'trandate',
			//'OrderStatus',
			'dblTax1' => 'taxtotal',
			//'OrderDiscountAmount',
			'dblGrandTotal' => 'total',
			'intReceiptNumber' => 'otherrefnum',
			'SalespersonSalespersonID',
			//'GiftCertificateAmount',
			//'SourceCode' => 'custbody_source_code',
			//'PromoCode',
			//'PromoCodeAmount',
			'strAuthorizationTransactionID' => 'pnrefnum',
			'strAuthorizationCode' => 'authcode',
			'strCreditCardExpiration' => 'ccexpiredate',
			'strCreditCardTypeLabel'  => 'paymentmethod',
			'strCustomPaymentName' => 'ccname',
			'strCreditCardNumberLast4' => 'ccnumber',
			'strPaymentTypeLabel' => '_paymentmethod_flag'
	);


	/**
	 *
	 * @access public
	 * @return void
	*/
	public function __construct( array $aOrder, $locationData ) {

		parent::__construct();
		$this->_aData = $aOrder;
		$this->_map();
		$this-> _setInternalSources( $locationData );
	}
	
	public function getEncrypted(){
		return( Netsuite_Crypt::encrypt( $this->getJson() ) );
	}

	public function addItems( array $items ){
		$this->item = $items;
	}

	private function _setInternalSources( $locationData ){
		
		//$this->entity = (int) $locationData['location_entity'];
		$this->entity = 279308;
		$this->billaddress = $this->shipaddress = $locationData['location_address'];
		$this->custbody_order_source = (int) $locationData['location_netsuite_order_source'];
		$this->location = (int) $locationData['location_netsuite_id'];
		$this->department = (int) $locationData['location_netsuite_department'];
		$this->leadsource = (int) $locationData['location_netsuite_lead'];		
	}
}