<?php

class Netsuite_Record_Item extends Netsuite_Record_Base implements Netsuite_Interface_INetsuite {

	public $amount = 0;
	public $addressee;
	public $addr1;
	public $addr2;
	public $attention;
	public $city;
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
	public $shipmethod;
	public $state;
	//public $taxcode = -125;
	public $zip;

	private $_activa_id;
	private $_additionalcustomizations;
	private $_engravingdetails;
	public $_locationId;
	private $_messagedetails;
	private $_model;
	private $_itemtype;

	public function __construct( array $aItem, $iLocationId, $sActivaId, $sItemType = 'Item' ) {

		try{

			$aItem = ( array_merge( get_object_vars( $this ), $aItem ) );

			$this->_setValues( $aItem, $iLocationId, $sActivaId, $sItemType );

			if( !$this->_validate( $this->getFields() ) ) {
				return;
			}

			$this->_forwardWarnings( get_class() );
			$this->_forwardErrors( get_class() );

		} catch( Exception $e ) {
			self::logError( 'Could NOT Create Item: ' . $e->getMessage() );
			return;
		}
	}

	protected function _setValues( array $aItem, $iLocationId, $sActivaId, $sItemType ) {

		foreach( $aItem as $key => $value ) {
			$this->$key = $value;
		}

		//Set Amount
		$this->amount = $this->quantity * $this->rate;

		$oModel = new Netsuite_Db_Model();

		// Set Activa Customer Id
		$this->_activa_id = $sActivaId;
		$this->_locationId = $iLocationId;
	}

	/**
	 *
	 * @param unknown $aItem
	 * @return boolean
	 */
	protected function _validate( $aItem ) {

		$this->_filter = Netsuite_Filter::factory()->item( $aItem );

		if( !$this->_filter->isOk() ) {

			$this->_forwardErrors( get_class() );
			$this->_forwardWarnings( get_class() );

			return( false );
		}

		return( true );
	}

	public function getDiscountItem( $sDiscountType = 'webdiscount', $ismultishipto) {

		$oModel = new Netsuite_Db_Model();

		$aDiscountItem = array(
				'item' =>  $sDiscountType,
				'rate' => $this->discounttotal,
				'quantity' => 1,
				'istaxable' => false,
				'price' => -1
		);

		if( $ismultishipto ){

			$aAddress = array(
					'attention' => $this->attention,
					'addressee' => $this->addressee,
					'addr1' => $this->addr1,
					'addr2' => $this->addr2,
					'addr3' => $this->addr3,
					'city' => $this->city,
					'state' => $this->state,
					'zip' => $this->zip,
					'country' => $this->country,
					'phone' => $this->phone,
			);

			$aDiscountItem = array_merge( $aDiscountItem, $aAddress );
		}

		$oDiscountItem = Netsuite_Record::factory()->discountitem( $aDiscountItem, $this->_locationId, $this->_activa_id );

		return( $oDiscountItem->_filter->optimizeValues( $oDiscountItem->_filter->getRecord() ) );
	}

	public function hasDiscount() {
		$bHasDiscount = ( $this->discounttotal != 0 )? true: false;
		return( $bHasDiscount );
	}

	public function getItem() {
		return( $this->_filter->optimizeValues( $this->_filter->getRecord() ) );
	}

	public function getJSON() {
		return( json_encode( $this->getItem() ) );
	}


}