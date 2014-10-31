<?php 
class LivePos_Maps_Discountlist extends LivePos_Maps_Map {

	protected $_discountList = array();
	protected $_discountIds = array();

	protected $_discountMap = array( 'strCouponCode' => 'discountid' );


	/**
	 *
	 * @access public
	 * @return void
	*/
	public function __construct( array $aDiscounts ) {

		parent::__construct();
		$this->_getDiscountIds( $aDiscounts );
		$this->_getDiscountList();
	}

	public function hasDiscounts(){

		$bReturn = ( !empty( $this->_discountIds ) )? true: false;
		return( $bReturn );
	}

	public function calculateDiscounts( LivePos_Maps_Itemlist $oItems ){

		foreach( $oItems->getItems() as $oItem ){
			var_dump( $oItem->getSku() );
		}
	}

	public function getDiscountIds(){

		return( $this->_discountIds );
	}

	public function getDiscounts(){

		return( $this->_discountList );
	}

	private function _getDiscountIds( array $aDiscounts ){

		$aTempIds = array();
		$aDiscounts =  $this->_map( $aDiscounts, $this->_discountMap );

		array_walk( $aDiscounts, function($aData, $sKey) use(&$aTempIds){
			$aTempIds[] = $aData['discountid'];
		});

			$this->_discountIds = array_unique( $aTempIds );
	}

	private function _getDiscountList(){

		$model = new LivePos_Db_Model();
		$aDiscountsData = $model->getDiscounts(  $this->_discountIds );
		$model = null;

		foreach( $aDiscountsData as $aDiscount ){

			$discount = LivePos_Maps_MapFactory::create( 'discount', array( $aDiscount ) );
			$this->_discountList[] = $discount->getPublicVars();
		}
	}
}