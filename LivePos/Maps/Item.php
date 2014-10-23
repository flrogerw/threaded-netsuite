<?php

class LivePos_Maps_Item extends LivePos_Maps_Map {

	protected $_aData;
	
	public $amount = 0;
	public $addressee = 'sssss';
	public $addr1 = '123 main st';
	public $addr2;
	public $attention = 'rrrrrr';
	public $city = 'Boca Raton';
	public $country = 'US';
	public $custcol_image_url;
	public $custcol_page_count_formattedValue;
	public $custcol_produce_in_store = false;
	public $custcol_store_pickup = false;
	public $custcol162 = null;
	public $description;
	public $discountitem;
	public $discounttotal = 0;
	public $giftcertfrom;
	public $giftcertmessage;
	public $giftcertnumber;
	public $giftcertrecipientemail;
	public $giftcertrecipientname;
	public $isclosed = false;
	public $isresidential = true;
	public $isestimate = false;
	public $istaxable = true;
	public $item;
	public $location;
	public $phone;
	public $price = -1;
	public $quantity = 0;
	public $rate;
	public $shipaddress;
	public $shipmethod = 10;
	public $state = 'FL';
	//public $taxcode = -125;
	public $zip = '33484';

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