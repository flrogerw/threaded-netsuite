<?php

final class Netsuite_Job_GetRecord extends Netsuite_Job_Job {

	protected $_endpoint;

	public function __construct(){
		
	}

	/**
	 * Returns Customer Address Book Based on the Netsuite Internal Id.
	 * 
	 * @param int $iEntityId - Customer's Netsuite Internal Id
	 * @return string
	 * @access public
	 */
	public function getAddressBook( $iEntityId ) {
		
		$this->_endpoint = NETSUITE_GET_ADDRESSBOOK;
		$this->_recordType = 'get_addressbook';
		$this->_data = json_encode( array('id' => $iEntityId ) );
		$this->_send();
	}
	
}
