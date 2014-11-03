<?php 
class LivePos_Maps_Discount extends LivePos_Maps_Map {

	public $discountscope;
	public $discounttotal = 0;
	public $discountid;
	public $discountstart;
	public $discountend;
	public $discountuse;
	public $discounttype;

	protected $_mapArray = array(
			'discount_code' =>'discountid',
			'discount_start' =>'discountstart',
			'discount_end' => 'discountend',
			'discount_use' => 'discountuse',
			'discount_type' => 'discounttype',
			'discount_amount' => 'discounttotal',
			'discount_scope' => 'discountscope');


	/**
	 *
	 * @access public
	 * @return void
	*/
	public function __construct( array $aDiscount ) {

		parent::__construct();
		$this->_aData = $aDiscount;
		$this->_map();
		$this->_logic();
	}

	public function getType(){
		return( $this->discounttype );
	}

	public function getAmount(){

		return( $this->discounttotal );
	}

	public function getId(){
		return( $this->discountid );
	}

	public function getScope(){
		return( $this->discountscope );
	}

	private function _logic(){

		switch( true ){
			case( stripos( $this->discountscope,'sale' ) !== false ):
				$sScope = 'sale';
				break;

			case( stripos( $this->discountscope,'item' ) !== false ):
				$sScope = 'item';
				break;
		}
		$this->discountscope = $sScope;
	}
}