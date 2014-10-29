<?php 
class LivePos_Maps_Coupon extends LivePos_Maps_Map {

	
	protected $_mapArray = array(
			'intCouponID'  => '',
			'strCouponCode' => '',
			'strCouponTargetType' => '',
			'intItemID' => '',
			'dblDiscountAmount' => '');
	
	
	
	/**
	 *
	 * @access public
	 * @return void
	 */
	public function __construct( array $aCoupons ) {
	
		parent::__construct();
		$this->_aData = $aCoupons;
		$this->_map();
		$this->_logic();
	}
	
	private function _logic(){
		
	}
}