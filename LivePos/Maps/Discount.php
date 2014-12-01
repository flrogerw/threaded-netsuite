<?php 
class LivePos_Maps_Discount extends LivePos_Maps_Map {

	public $discountscope;
	public $discounttotal = 0;
	public $discountid;
	public $discountstart;
	public $discountend;
	public $discountuse;
	public $discounttype;
	protected $_discounteditems = array();

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
		$this->_getDiscountedItems();
	}
	
	public function hasDiscountedItems(){
		
		$bReturn = ( !empty( $this->_discounteditems ) )? true: false;
		return( $bReturn );
	}
	
	public function getDiscountItems(){
		
		return( $this->_discounteditems );
	}

	public function getType(){
		return( $this->discounttype );
	}

	public function getDiscountTotal( $fTotal ){

		switch( $this->getType() ){
				
			case( 'percent' ):
				$fReturn = $fTotal * ( $this->getAmount() * .01);
				break;

			case( 'price' ):
				$fReturn = $this->getAmount();
				break;
		}

		return( $fReturn );
	}

	public function getAmount(){

		return( (float) $this->discounttotal );
	}

	public function getId(){
		return( $this->discountid );
	}

	public function getScope(){
		return( $this->discountscope );
	}
	
	private function _getDiscountedItems(){
		
		$model = new LivePos_Db_Model();
		$this->_discounteditems = $model->getDiscountedItems( $this->getId() );
		$model = null;
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