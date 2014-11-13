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
	public $isresidential = 'F';
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
	protected $_netprice;

	protected $_mapArray = array(
			"intProductSoldUnits"  => 'quantity',
			"dblProductSoldNetPrice" => '_netprice',
			"strProductName" => 'description',
			"strProductSKU" => 'item');

	/**
	 *
	 * @access public
	 * @return void
	*/
	public function __construct( array $aItem, $locationData, $bMergeItem = false ) {

		parent::__construct();

		if( !$bMergeItem ){
				
			$this->_aData = $aItem;
			$this->_aLocationData = $locationData;
			$this->_map();
			$this->_setAddress();
			$this->_logic();
		}else{
				
			$aItem = ( array_merge( get_object_vars( $this ), $aItem ) );
			foreach( $aItem as $key => $value ) {
				$this->$key = $value;
			}
			$this->_originalprice = $this->rate;
		}
	}

	public function getSku(){
		return( $this->_sku );
	}

	/**
	 * Sets Price Back to PreDiscount Amount and Sets
	 * discounttotal to the diference.
	 */
	public function applyDiscount( $fDiscountAmount, $sDiscountItem = NETSUITE_DEFAULT_DISCOUNT ){

		$this->discounttotal += ( ( $fDiscountAmount * $this->getQuantity() ) * -1 );
		$this->discountitem = $sDiscountItem;
	}

	public function getPreDiscountPrice(){

		return( $this->_originalprice );
	}

	public function setPreDiscountPrice( $fPrice ){

		$this->_originalprice = $this->rate;
		$this->rate = (float) $fPrice;
	}

	public function getPrice(){

		return( $this->rate );
	}

	public function getQuantity(){

		return( $this->quantity );
	}

	private function _logic(){

		// Set Item to Match Store Location
		$this->location = $this->_aLocationData['location_netsuite_id'];
		$this->_sku = $this->item;
		$this->rate = ( $this->_netprice / $this->quantity );
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

				$this->$sProperty = ( !empty( $value ) )? $value: $this->$sProperty;
			}
		});
	}
}