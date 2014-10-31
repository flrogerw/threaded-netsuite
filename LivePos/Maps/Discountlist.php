<?php 
class LivePos_Maps_Discountlist extends LivePos_Maps_Map {

	protected $_discountList = array();
	
		
	/**
	 *
	 * @access public
	 * @return void
	*/
	public function __construct( array $aCoupons ) {

		parent::__construct();
		$this->_aData = $aCoupons;
		$this->_getDiscountList();
	}
	
	public function hasDiscount(){
		
		$bReturn = ( !empty( $this->_discountList ) )? true: false;
		return( $bReturn );
	}
	
	public static function getPosCoupons(){
		
	}
	
	public function getDiscountTotal(){
		
		$fTotal = 0;
		
		array_walk( $this->_discountList, function(&$aData, $sKey) use (&$fTotal){
			$fTotal +=  $aData['discounttotal'];
		});
		
		return( $fTotal );
	}
	
	public function getDiscounts(){
	
		return( $this->_discountList );
	}
	
	private function _getDiscountList(){
	
		foreach( $this->_aData as $aDiscount ){
	
			$discount = LivePos_Maps_MapFactory::create( 'discount', array( $aDiscount ) );
			$this->_discountList[] = $discount->getPublicVars();
		}
	}
}