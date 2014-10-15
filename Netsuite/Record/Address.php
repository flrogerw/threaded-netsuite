<?php
/**
 * Address
 *
 * @author gWilli
 * @version 1.0
 * @name Address
 * @copyright 2013
 */
/**
 * Netsuite Address Record Class
 *
 * Creates a Netsuite Address Record.  This object can either stand alone or be a subset of an AddressBook
 *
 * @uses Configure
 * @uses Base
 * @package Netsuite
 * @subpackage Record
 */
class Netsuite_Record_Address extends Netsuite_Record_Base implements Netsuite_Interface_INetsuite {

	public $addr1;
	public $addr2;
	public $addr3;
	public $addressee;
	public $attention;
	public $city;
	public $country;
	public $defaultbilling;
	public $defaultshipping;
	public $isresidential = true;
	public $label;
	public $phone;
	public $province;
	public $state;
	public $zip;

	private $_type;
	//private $_attention1 = null;
	//private $_attention2 = null;
	//private $_companyname = null;

	public function __construct( array $aAddress, $sType = null ) {

		try{
			$aAddress = ( array_merge( $this->getFields(), $aAddress ) );
			$this->_type = $sType;

			$this->_setValues( $aAddress );

			if( !$this->_validate( $this->getFields() ) ) {

				return;
			}

			$this->_forwardWarnings( get_class() );

		} catch( Exception $e ) {
			self::logError( 'Could NOT Create Address: ' . $e->getMessage() );
			return;
		}
	}

	protected function _validate( $aAddress ) {

		$this->_filter = Netsuite_Filter::factory()->address( $aAddress );

		if(!$this->_filter->isOk()){

			$this->_forwardErrors( get_class() );
			$this->_forwardWarnings( get_class() );

			return( false );
		}

		return( true );
	}
	/**
	 *
	 * @access protected
	 * @param array $aAddress
	 */
	protected function _setValues( array $aAddress ) {

		foreach( $aAddress as $key => $value ) {

			$this->$key = $value;
		}
		/*
		 // Set Attention and Addressee Fields from Line Item Address
		if( $this->_attention1 !== null ){
		$this->attention = $this->_attention1 . ' ' . $this->_attention2;
		}

		if( $this->_companyname != null ){
		$this->addressee =  $this->_companyname;
		$this->isresidential = false;
		} else {
		$this->addressee = $this->attention;
		}

		switch( true ){

		case($this->_type == 'billing'):
		$this->defaultbilling = true;
		break;
		case($this->_type == 'shipping'):
		$this->defaultshipping = true;
		break;
		}
		*/

		if( $this->phone == ''){
			$this->phone = '123-123-1234';
		}
	}

	/**
	 *
	 * @access public
	 * @return array
	 */
	public function getAddress() {
		return( $this->_filter->optimizeValues( $this->_filter->getRecord() ) );
	}

	public function getJSON() {
		return( json_encode( $this->getAddress() ) );
	}

}