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
	public $entity;
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
	public $shipmethod = 10;
	public $shipdate;
	public $taxtotal = 0;
	public $total = 0;
	public $trandate;

	protected $_source; // convert to NS ID;
	protected $_paymentmethod_flag;

	protected $_mapArray = array(
			'intLocationID'  => '_source', // convert to NS ID
			//'strFNUMBER' => 'custbody_order_source_id',
			//'dtTransactionDate' => 'trandate',
			'dblTax1' => 'taxtotal',
			'dblGrandTotal' => 'total',
			'intInvoiceNumber' => 'otherrefnum',
			'strAuthorizationTransactionID' => 'custbody_pos_trans_id',
			'strAuthorizationCode' => 'authcode',
			'strCreditCardExpiration' => 'ccexpiredate',
			'strPaymentTypeLabel' => '_paymentmethod_flag',
			//'intReceiptNumber' => 'custbody_order_source_id',
			'dtTransactionDate' => 'custbody_pos_postranstime'
			
	);


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

	private function _logic(){

		// Reformat ccexpire date string to Netsuite Friendly Format
		if( isset( $this->ccexpiredate ) ){
			$date = DateTime::createFromFormat('my', $this->ccexpiredate);
			$this->ccexpiredate = $date->format('m/Y');
		}
		
		// Set Shipping/ Billing Dates
		$date = new DateTime( $this->custbody_pos_postranstime );
		$this->trandate = $this->shipdate = $date->format('m/d/Y');
		
		// Set Total
		$this->total = ( $this->total - $this->taxtotal );
	}

	private function _setInternalSources( $locationData ){

		$this->billaddress = $this->shipaddress = stripcslashes( $locationData['location_addresstxt']);
		$this->custbody_order_source = (int) $locationData['location_netsuite_order_source'];
		$this->location = (int) $locationData['location_netsuite_id'];
		$this->department = (int) $locationData['location_netsuite_department'];
		$this->leadsource = (int) $locationData['location_netsuite_lead'];
	}
}