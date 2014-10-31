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
	
	public function getPrice(){
		return( $this->productprice );
	}

	private function _logic(){

	}
}