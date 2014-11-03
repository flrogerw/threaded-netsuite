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
	public $discountrate;
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
	public $zip;

	protected $_originalprice;
	protected $_sku;

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

	public function getSku(){
		return( $this->_sku );
	}

	/**
	 * Sets Price Back to PreDiscount Amount and Sets
	 * discounttotal to the diference.
	 */
	public function removeDiscount( $bItemLevel = false, $sDiscountItem = NETSUITE_DEFAULT_DISCOUNT ){

		if( $bItemLevel ){
				
			$this->discounttotal = (  $this->rate - ( $this->getPreDiscountPrice() * $this->quantity ) );
			$this->discountitem = $sDiscountItem;
		}

		$this->rate = $this->getPreDiscountPrice();
	}

	public function getPreDiscountPrice(){

		return( $this->_originalprice );
	}

	public function setPreDiscountPrice( $fPrice ){

		$this->_originalprice = (float) $fPrice;
	}

	public function getQuantity(){
		return( $this->quantity );
	}

	private function _logic(){

		// Set Item to Match Store Location
		$this->location = $this->_aLocationData['location_netsuite_id'];
		$this->_sku = $this->item;
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
		});
	}
}