<?php

class LivePos_Maps_Item extends LivePos_Maps_Map {

	protected $_aData;
	
	public $quantity;
	public $rate;
	public $description;
	public $item;

	protected $_mapArray = array(
			"intProductSoldUnits"  => 'quantity',
			"dblProductSoldNetPrice" => 'rate',
			"strProductName" => 'description',
			"strProductSKU" => 'item');

	/**
	 *
	 * @access public
	 * @return void
	*/
	public function __construct( array $aItems ) {
		
		parent::__construct();
		$this->_aData = $aItems;
		$this->_map();
	}	
}