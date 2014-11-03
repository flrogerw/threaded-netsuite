<?php 
class LivePos_Maps_Discountlist extends LivePos_Maps_Map {

	protected $_discountList;
	protected $_discountListMap = array( 'strCouponCode' => 'discount_code', 'strCouponTargetType' => 'discount_scope' );


	/**
	 *
	 * @access public
	 * @return void
	*/
	public function __construct( array $aDiscounts ) {

		parent::__construct();
		$aDiscounts =  $this->_map( $aDiscounts, $this->_discountListMap );
		$this->_getDiscountList( $aDiscounts );
	}

	public function hasDiscounts(){

		$bReturn = ( !empty( $this->_discountList ) )? true: false;
		return( $bReturn );
	}

	public function getDiscountIds(){

		return( array_keys( $this->_discountList ) );
	}

	public function isDiscount( $iDiscountId ){

		$bReturn = ( in_array( $iDiscountId, $this->getDiscountIds() ) )? true: false;
		return( $bReturn );
	}

	/**
	 * get all info from DB on cupons
	 * @param boolean $bPopAll - get all coupons [false]
	 */
	public function popDiscounts( $bPopAll = false ){

		$sFunctionToUse = ( $bPopAll )? 'getAllDiscounts': 'getDiscounts';
		$oModel = new LivePos_Db_Model();
		$aDiscounts = $oModel->$sFunctionToUse( $this->getDiscountIds() );
		$oModel = null;
		$this->_getDiscountList( $aDiscounts );
	}



	public function getCount(){

		return( sizeof( $this->_discountList) );
	}

	public function getDiscount( $iDiscountId ){


		return( $this->_discountList[ $iDiscountId ] );
	}

	public function getDiscounts(){

		return( array_values( $this->_discountList ) );
	}

	private function _getDiscountList( array $aDiscounts ){

		$this->_discountList = array();

		array_walk( $aDiscounts, function($aData, $sKey){

			$discount = LivePos_Maps_MapFactory::create( 'discount', array( $aData ) );

			if( !$this->isDiscount( $discount->getId() ) ){
				$this->_discountList[ $discount->getId() ] = $discount;
			}
		});
	}
}