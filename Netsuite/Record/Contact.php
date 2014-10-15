<?php

class Netsuite_Record_Contact extends Netsuite_Record_Base implements Netsuite_Interface_INetsuite {

	public $addressbook = array();
	public $addressBookEntry;
	public $altemail;
	public $comments;
	public $companyname;
	public $customform = -40;
	public $email;
	public $entityid;
	public $fax;
	public $firstname;
	public $giveaccess = false;
	public $isperson = true;
	public $isprivate;
	public $lastname;
	public $officephone;
	public $phone;
	public $recordtype = 'contact';
	public $salutation;
	public $title;

	protected $_source;
	private $_tmp_addressbook = array();


	public function __construct( array $aContact ) {

		try{

			$aContact = ( array_merge( get_object_vars( $this ), $aContact ) );

			$this->_setValues( $aContact );

			if( !$this->_validate( $this->getFields() ) ) {
				return;
			}

			$this->_forwardWarnings( get_class() );
			$this->_forwardErrors( get_class() );

		} catch( Exception $e ) {
			self::logError( 'Could NOT Create Contact: ' . $e->getMessage() );
			return;
		}
	}

	/**
	 * @deprecated
	 */
	protected function _setAddressEntries() {

		$sFullName = $this->firstname . ' ' . $this->lastname;

		foreach( $this->_tmp_addressbook as &$aEntry ) {

			$sAddressee = $aEntry['addressee'];
			$sAttention = $aEntry['attention'];

			$aEntry['addressee'] = ( isset( $sAddressee ) )? $sAddressee: $sFullName;
			$aEntry['attention'] = ( isset( $sAttention ) )? $sAttention: $sFullName;
		}
	}

	protected function _setValues( array $aContact ) {

		//unset( $aContact['custentity_fotomail'], $aContact['custentity_customer_source_id'] );

		foreach( $aContact as $key => $value ) {
			$this->$key = $value;
		}
		/*
		 $this->_tmp_addressbook = $aContact['addressbook'];

		//$this->_setSources();

		$this->_setAddressEntries();
		$this->addressbook = $this->setAddressBook( $this->_tmp_addressbook, $this->isperson );

		// See if address are the same
		if( $this->addressbook != null ){

		$iAddressIntersect =  array_intersect( $this->addressbook['billing'],  $this->addressbook['shipping'] );

		if( sizeof( $iAddressIntersect ) == sizeof( $this->addressbook['billing'] ) ) {
		unset( $this->addressbook['shipping'] );
		$this->addressbook['billing']['defaultshipping'] = true;
		$this->addressbook['billing']['defaultbilling'] = true;
		}

		$this->phone = ( !empty( $this->addressbook['billing']['phone'] ) )? $this->addressbook['billing']['phone']: null;
		}

		*/
	}

	protected function _validate( $aContact ) {

		$this->_filter = Netsuite_Filter::factory()->contact( $aContact );

		if( !$this->_filter->isOk() ) {

			$this->_forwardErrors( get_class() );
			$this->_forwardWarnings( get_class() );

			return( false );
		}

		return( true );
	}

	public function getContact() {

		$aContact =  $this->_filter->optimizeValues( $this->_filter->getRecord() );
		//$aContact['addressbook'] = array_values( $this->addressbook );

		return( $aContact );
	}

	public function getJSON() {
		return( json_encode( $this->getContact() ) );
	}


}