<?php 
class LivePos_Maps_Discountlist extends LivePos_Maps_Map {

	protected $_discountList = array();
	protected $_discountListMap = array( 'strCouponCode' => 'discount_code', 'strCouponTargetType' => 'discount_scope' );
	protected $_doscountTotal = 0;

	/**
	 *
	 * @access public
	 * @return void
	 */
	public function __construct( array $aDiscounts ) {

		parent::__construct();
		if( !empty( $aDiscounts ) ){
			$this->_getDiscountList( $aDiscounts );
		}
	}

	public function getDiscountTotal(){

		return( $this->_doscountTotal );
	}

	public function updateDiscountTotal( $fDiscount ){

		$this->_doscountTotal += $fDiscount;
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
		
		array_walk( $aDiscounts, function($aData, $sKey){
			
			$aMappedDiscount = $this->_map( $aData, $this->_discountListMap );
			$discount = LivePos_Maps_MapFactory::create( 'discount',  $aMappedDiscount );			
			
			if( !$this->isDiscount( $discount->getId() ) ){
				$this->_discountList[ $discount->getId() ] = $discount;
			}
		});
	}
}