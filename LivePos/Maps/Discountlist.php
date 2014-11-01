<?php 
class LivePos_Maps_Discountlist extends LivePos_Maps_Map {

	protected $_discountIds = array();
	protected $_discountMap = array( 'strCouponCode' => 'discountid', 'strCouponTargetType' => 'discountscope' );


	/**
	 *
	 * @access public
	 * @return void
	*/
	public function __construct( array $aDiscounts ) {

		parent::__construct();
		$this->_getDiscountIds( $aDiscounts );
	}

	public function hasDiscounts(){

		$bReturn = ( !empty( $this->_discountIds ) )? true: false;
		return( $bReturn );
	}

	public function getDiscountIds(){

		return( $this->_discountIds );
	}

	private function _getDiscountIds( array $aDiscounts ){

		$aTempIds = array();
		$aDiscounts =  $this->_map( $aDiscounts, $this->_discountMap );

		array_walk( $aDiscounts, function($aData, $sKey) use(&$aTempIds){
			$aTempIds[ $aData['discountid'] ] = $aData['discountscope'];
		});

			$this->_discountIds = array_unique( $aTempIds );
	}

}