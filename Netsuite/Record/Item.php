<?php

class Netsuite_Record_Item extends Netsuite_Record_Base implements Netsuite_Interface_INetsuite {

	public $amount = 0;
	public $addressee;
	public $addr1;
	public $addr2;
	public $attention;
	public $city;
	public $country;
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
	public $isestimate = false;
	public $istaxable = true;
	public $item;
	public $location;
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
var_dump($this);
		$oModel = new Netsuite_Db_Model();

		// Set Activa Customer Id
		$this->_activa_id = $sActivaId;
		$this->_locationId = $iLocationId;

		// Set ImageSku Value
		if( isset( $this->custcol162 ) && $this->custcol162 !== false ){
			$this->custcol162 = $oModel->getImageSku( $this->custcol162 );
		} else {
			$this->custcol162 = '';
		}

		// Get Internal Id for Item
		//$sCurrentItem = (int) $oModel->getItem( $sItemType, $this->item );

		//if( $sCurrentItem == 0 ){

		//self::logError( 'Could NOT Find Item in the DataBase Using: '. $this->item );
		//}

		//$this->item = $sCurrentItem;

		//Set Amount
		$this->amount = $this->quantity * $this->rate;

		// Location Logic
		//$sItemLocation = ( $this->custcol_produce_in_store === true )? 'store': 'corporate';
		//$this->location = ( $sItemLocation == 'corporate' )? $oModel->callXrefTable( 'Location', 'corporate' ): $this->_locationId;

		// Set Tax Code Based on Item Location
		//$iTaxCode = $oModel->getTaxCode( $this->_locationId );
		//if( $iTaxCode == null ){
		//self::logError( 'Could NOT Find TaxCode in the DataBase Using: ' . $this->_locationId );
		//}

		//$this->taxcode = $iTaxCode;

		// Shipmethods that require NO address
		//if( strtolower( $this->shipmethod ) != 'cpu' /* && strtolower( $this->shipmethod ) != 'str' */ ){
		/*
		if( $this->custcol_produce_in_store === false ){

			// Set Address Internal Id And Shipping Method
			$oAddress = new Netsuite_Record_Address( $aItem );

			if( $oAddress->isOk() ){
				// Set Shipping Methhod
				//$this->shipmethod = (int) $oModel->getShippingMethod( $oAddress->state, $this->shipmethod );
				$sAddress = $this->getAddressString( $oAddress->getAddress() );
				$iInternalId = $oModel->getAddress( $this->_activa_id, $sAddress );

				if( $iInternalId !== false ){
					$this->shipaddress = $iInternalId;
				} else{
					self::logError( 'Could NOT Get Address Netsuite Internal Id Using: ' . $this->_activa_id . ' - ' . $sAddress );
				}
			}
		} else {
			//$this->shipmethod = (int) $oModel->getShippingMethod( null, $this->shipmethod );

		}
		*/
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

	public function getDiscountItem( $sDiscountType = 'webdiscount') {

		$oModel = new Netsuite_Db_Model();

		$aDiscountItem = array(
				'item' =>  $sDiscountType,
				'rate' => $this->discounttotal,
				'quantity' => 1,
				'istaxable' => false,
				'shipaddress' => $this->shipaddress,
				'price' => -1
		);

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