<?php

class Netsuite_Record_Customer extends Netsuite_Record_Base implements Netsuite_Interface_INetsuite {

	public $addressbook = array();
	public $addressBookEntry;
	public $companyname;
	public $customform = 16;
	public $custentitycustomer_department;
	public $custentity_customer_source;
	public $custentity_customer_source_id;
	public $custentity_fotomail;
	public $department;
	public $email;
	public $entityid;
	public $entitystatus = 13; // Should be Record Reference
	public $firstname;
	public $globalsubscriptionstatus = 1;
	public $isperson = true;
	public $lastname;
	public $leadsource;
	public $phone;
	public $recordtype = 'customer';
	public $shipcomplete = false;


	private $_tmp_addressbook = array();
	protected $_source;

	public function __construct( array $aCustomer ) {
		try{

			$aCustomer = ( array_merge( get_object_vars( $this ), $aCustomer ) );

			$this->_setValues( $aCustomer );

			if( !$this->_validate( $this->getFields() ) ) {
				return;
			}

			$this->_forwardWarnings( get_class() );
			$this->_forwardErrors( get_class() );

		} catch( Exception $e ) {
			self::logError( 'Could NOT Create Customer: ' . $e->getMessage() );
			return;
		}
	}

	protected function _setValues( array $aCustomer ) {

		foreach( $aCustomer as $key => $value ) {
			$this->$key = $value;
		}

		$this->_tmp_addressbook = $aCustomer['addressbook'];

		//$this->_setSources();

		$this->_setAddressEntries();

		$this->addressbook = $this->setAddressBook( $this->_tmp_addressbook, $this->isperson );

		// See if address are the same
		if( $this->addressbook != null ){

			if( is_array( $this->addressbook['billing'] ) && is_array( $this->addressbook['shipping'] ) ){
				
				$iAddressIntersect =  array_intersect( $this->addressbook['billing'],  $this->addressbook['shipping'] );
				
				if( sizeof( $iAddressIntersect ) == sizeof( $this->addressbook['billing'] ) ) {
					unset( $this->addressbook['shipping'] );
					$this->addressbook['billing']['defaultshipping'] = true;
					$this->addressbook['billing']['defaultbilling'] = true;
				}			
		 }
		 $this->phone = ( empty( $this->phone ) )? $this->addressbook['billing']['phone']: $this->phone;
		}

	}

	protected function _setAddressEntries() {

		$sFullName = $this->firstname . ' ' . $this->lastname;

		foreach( $this->_tmp_addressbook as &$aEntry ) {

			$sAddressee = $aEntry['addressee'];
			$sAttention = $aEntry['attention'];

			if( $this->isperson === true ){
				$aEntry['addressee'] = ( isset( $sAddressee ) )? $sAddressee: $sFullName;
				$aEntry['attention'] = ( isset( $sAttention ) )? $sAttention: $sFullName;
			} else {
				$aEntry['addressee'] = ( isset( $sAddressee ) )? $sAddressee: $this->companyname;
				$aEntry['attention'] = ( isset( $sAttention ) )? $sAttention: $sFullName;
			}
		}
	}

	protected function _validate( $aCustomer ) {

		$this->_filter = Netsuite_Filter::factory()->customer( $aCustomer );

		if(!$this->_filter->isOk()){

			$this->_forwardErrors( get_class() );
			$this->_forwardWarnings( get_class() );

			return( false );
		}

		return( true );
	}

	public function getCustomer() {

		$aCustomer =  $this->_filter->optimizeValues( $this->_filter->getRecord() );
		if( is_array( $this->addressbook ) ){
			$aCustomer['addressbook'] =  $this->_filter->optimizeValues( array_values(  $this->addressbook) );
		}
		return( $aCustomer );
	}

	public function getJSON() {

		return( json_encode( $this->getCustomer() ) );
	}
}