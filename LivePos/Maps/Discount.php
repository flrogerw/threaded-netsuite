<?php 
class LivePos_Maps_Discount extends LivePos_Maps_Map {

	public $discountitem = null;
	public $discountrate = 0;
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



	/**
	 * Returns Original Price of Item based on the Discount
	 * Price and Discount.
	 *
	 * @access public
	 * @static
	 * @param float $fPrice - Discounted Price
	 * @param float $fDiscountPercent - Percent of Discount
	 * @return float
	 */
	public static function calculateOriginalPrice( $fPrice, $fDiscount, $sType = 'percent' ){


		switch( $sType ){

			case( 'percent' ):

				$fOriginalPrice = $fPrice/( 100 - $fDiscount ) * 100;
				return( $fOriginalPrice );
				break;

			case( 'price' ):

				$fOriginalPrice = $fPrice + $fDiscount;
				return( $fOriginalPrice );
				break;

			default:
				return( $fOriginalPrice );
				break;
		}
	}

	private function _logic(){

	}
}