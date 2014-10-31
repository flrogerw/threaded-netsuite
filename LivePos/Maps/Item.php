<?php

class LivePos_Maps_Item extends LivePos_Maps_Map {

	protected $_aLocationData;

	public $amount = 0;
	public $addressee;
	public $addr1;
	public $addr2;
	public $attention;
	public $city;
	public $country = 'US';
	public $custcol_image_url;
	public $custcol_page_count;
	public $custcol_produce_in_store = 'F';
	public $custcol_store_pickup = 'T';
	public $custcol162 = null;
	public $description;
	public $discountitem;
	public $discounttotal = 0;
	public $giftcertfrom;
	public $giftcertmessage;
	public $giftcertnumber;
	public $giftcertrecipientemail;
	public $giftcertrecipientname;
	public $isclosed = 'F';
	public $isresidential = 'T';
	public $isestimate = 'F';
	public $istaxable = 'T';
	public $item;
	public $location;
	public $phone;
	public $price = -1;
	public $quantity = 0;
	public $rate;
	public $shipaddress;
	public $shipmethod = 10;
	public $state;
	//public $taxcode = -125;
	public $zip;

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
	public function __construct( array $aItem, $locationData ) {

		parent::__construct();
		$this->_aData = $aItem;
		$this->_aLocationData = $locationData;
		$this->_map();
		$this->_setAddress();
		$this->_logic();
	}
	
	private function _logic(){
		
		// Set Item to Match Store Location
		$this->location = $this->_aLocationData['location_netsuite_id'];
	}

/**
 * 
 * @param array $this->_aLocationData
 * @return void
 */
	private function _setAddress(){

		array_walk( array_filter($this->_aLocationData), function($value, $key) {
			
			$sProperty = str_replace('location_', '',$key);
			if(property_exists($this, $sProperty)){
				$this->$sProperty = $value;
			}
			return;
		});
	}
}