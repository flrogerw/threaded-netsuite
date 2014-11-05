<?php

class LivePos_Maps_Payment extends LivePos_Maps_Map {

	public $checkstate;
	public $checklicensenumber;
	public $checknumber;
	public $authcode;
	public $authtransactionid;
	public $custompaymentname;
	public $giftcertcode;
	public $giftcertapplied;
	public $giftcardcodepin;
	public $couponcode;
	public $processedexternally;
	public $creditcardexpiration;
	public $creditcardlast4;
	public $creditcardtypelabel;
	public $creditcardtypeid;
	public $amount;
	public $typeid;
	public $typelabel;
	public $receiptnumber;

	protected $_mapArray = array(
			'strCheckState' => 'checkstate',
			'strCheckLicenseNumber' => 'checklicensenumber',
			'strCheckNumber' => 'checknumber',
			'strAuthorizationCode' => 'authcode',
			'strAuthorizationTransactionID' => 'authtransactionid',
			'strCustomPaymentName' => 'custompaymentname',
			'strGiftCardCode' => 'giftcertcode',
			'strGiftCardPIN' => 'giftcardcodepin',
			'strCouponCode' => 'couponcode',
			'bIsProcessedExternally' => 'processedexternally',
			'strCreditCardExpiration' => 'creditcardexpiration',
			'strCreditCardNumberLast4' => 'creditcardlast4',
			'strCreditCardTypeLabel' => 'creditcardtypelabel',
			'intCreditCardTypeID' => 'creditcardtypeid',
			'dblAmount' => 'amount',
			'intPaymentTypeID' => 'typeid',
			'strPaymentTypeLabel' => 'typelabel',
			'intReceiptNumber' => 'receiptnumber');

	/**
	 *
	 * @access public
	 * @return void
	*/
	public function __construct( array $aPayment ) {

		parent::__construct();
		$this->_aData = $aPayment;
		$this->_map();
		$this->_logic();
	}

	public function getCcNumber(){
		return( '414734003282' . $this->creditcardlast4 );
	}
	
	public function getGiftCertId(){
		
		//////////////////////  TEST ONLY  /////////////////////////
		$gcCodes = array('3veqsc6uc', 'store', 'Sotre26', 'store30', 'store38' );		
		$rand_key = array_rand($gcCodes);		
		return( $gcCodes[$rand_key] );
		///////////////////////  TEST ONLY END   ///////////////////////////////
		
		//return( $this->giftcertcode );
	}

	public function getCcExpire(){

		return( $this->creditcardexpiration );
	}
	
	public function getTypeId(){
	
		return( (int) $this->typeid );
	}

	public function getType(){

		return( $this->typelabel );
	}

	public function getId(){
		return( $this->paymentid );
	}

	public function getTransactionId(){
		return( $this->authtransactionid );
	}

	public function getAuthCode(){

		return( $this->authcode );
	}

	public function getAmount(){
		
		return( $this->amount );
	}

	private function _logic(){

		if( $this->getTypeId() == 2 ){

			$date = DateTime::createFromFormat('my', $this->creditcardexpiration );
			$this->creditcardexpiration = $date->format('m/Y');
		}
	}
}