<?php 

class LivePos_Maps_Product extends LivePos_Maps_Map {

	protected $_products = array();
	public $productid;
	public $productsku;
	public $productprice;
	public $description;

	protected $_mapArray = array(
			'strProductName' => 'description',
			'dblProductDefaultPrice' => 'productprice',
			'intProductID' => 'productid',
			'strProductSKU' => 'productsku');

	/**
	 *
	 * @access public
	 * @return void
	*/
	public function __construct( array $aProduct ) {

		parent::__construct();
		$this->_aData = $aProduct;
		$this->_map();
		$this->_logic();
	}

	public static function getProductBySku( $sSku ){

		$model = new LivePos_Db_Model();
		$aProductData = $model->getProduct( $sSku );
		$model = null;

		if( $aProductData !== false ){
			$product = LivePos_Maps_MapFactory::create( 'product', array( $aProductData ) );
			return( $product );
		}
		return( $aProductData );
	}

	private function _logic(){

	}
}