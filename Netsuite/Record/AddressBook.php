<?php
/**
 *
 * @example
 * $args = array(
 *              'label' =>,
 *              'attention' =>,
 *              'addressee' => ,
 *              'addr1' => ,            //Required
 *              'addr2' => ,
 *              'addr3' => ,
 *              'city' => ,             //Required
 *              'state' => ,            //Required
 *              'zip' => ,                      //Required
 *              'country' => ,          //Required
 *              'phone' => ,
 *              'isresidential' => ,
 *              'defaultbilling' => ,
 *              'defaultshipping' => )
 */
class Netsuite_Record_AddressBook extends Netsuite_Record_Base implements Netsuite_Interface_INetsuite {

	/**
	 *
	 * @var array
	 * @access private
	 */
	private $_addressBookArray = array();

	/**
	 *
	 * @var array
	 * @access private
	*/
	private $_addressBookEntries = array();

	private $_isResidential;

	private $_model;

	/**
	 *
	 * Converts Single Addressbook Entry into Array of Arrays if Not Already One
	 *
	 * @access protected
	 * @return void
	 */
	public function __construct( array $aAddresBookData = array(), $bIsResidential = true ) {

		if( !empty( $aAddresBookData ) ){
			$iCount = count( array_filter( $aAddresBookData, 'is_array' ) );
			$this->_addressBookArray = ( $iCount == count( $aAddresBookData ) )? $aAddresBookData: array( $aAddresBookData );
			$this->_isResidential = $bIsResidential;
			$this->_validate();
		} else {
			$this->_model = new Netsuite_Db_Model();
		}
	}

	public function getAddressBook() {

		return( $this->_addressBookEntries );
	}


	/**
	 *
	 * @return void
	 */
	protected function _validate() {

		foreach( $this->_addressBookArray as $iKey => $aAddress  ){

			if( !isset( $aAddress['isresidential'] ) ) {
				$aAddress['isresidential'] = $this->_isResidential;
			}

			$oAddress = Netsuite_Record::factory()->address( $aAddress, $iKey );

			if( !$oAddress->isOk() ){
				$this->logError( 'Address Book Entry '. ucfirst($iKey) . ' Has Errors: ' . implode( ', ', $oAddress->getErrors() ) );
				continue;
			} else {
				$this->_addressBookEntries[ $iKey ] = $oAddress->getAddress();
			}

			if( $oAddress->hasWarnings() ) {
				$this->logWarn( 'Address Book Entry '.ucfirst($iKey) . ' Has Warnings: ' . implode( ', ', $oAddress->getWarnings() ) );
			}
		}
	}


	/**
	 * @return string
	 */
	public function getJSON() {
		return( json_encode( $this->_addressBookEntries ) );
	}



	/**
	 * Set Netsuite Address Book Entries for the Defined Customer
	 *
	 * @param int $iEntityId
	 * @return mixed int|object

	 public function setAddressBookEntry( $iEntityId, $aAddresses ){

	 $aAddresses = ( is_array( $aAddresses ) )? $aAddresses: array( $aAddresses );

	 foreach( $aAddresses as $aAddress ){
	 $aAddressBookEntry = ( $aAddress instanceof Netsuite_Record_Address )? $aAddress: new Netsuite_Record_Address( $aAddress );
	 $aAddressBook[] = $aAddressBookEntry->getAddress();
	 }

	 $job = new Netsuite_Job_SetRecord( 'set_address', array('id'=>$iEntityId, 'address' => $aAddressBook ) );
	 return( $job->response );
	 }
	 */
	/**
	 * Get Netsuite Address Book Entries for the Defined Customer
	 *
	 * @param int $iEntityId
	 * @return array

	 protected function _getNetsuiteAddressBook( $iEntityId ){

	 $job = new Netsuite_Job_SetRecord( 'get_addressbook', array('id' => $iEntityId ) );
	 return( json_decode( $job->response ) );
	 }
	 */

	/**
	 * Checks System DataBase for Existence of the Current Address
	 *
	 * @return mixed int|bool

	 public function getAddress( $sActivaId, array $aAddress ){

	 $sAddress = $this->getAddressString( $aAddress );

	 $iInternalId = $this->_model->getAddress( $sActivaId, $sAddress );
	 return ( $iInternalId );
	 }

	 /**
	 * Syncs Netsuite Customer Address Book with Activa Address Book
	 *
	 * @param int $iNetsuiteId
	 * @param string $sActivaId
	 * @return void


	 public function updateSystemAddressBook( $iNetsuiteId, $sActivaId ) {

	 $aAddressBook = $this->_getNetsuiteAddressBook( $iNetsuiteId );
	 $aActivaAddressBook = $this->_model->getActivaAddresses( $sActivaId );
	 $aActivaAddressBook = ( is_array( $aActivaAddressBook ) )? $aActivaAddressBook: array( $aActivaAddressBook );

	 foreach( $aAddressBook as $sAddressBookEntry ){

	 if( !in_array( md5(strtolower( $sAddressBookEntry->text )), $aActivaAddressBook ) ){
	 $this->setSystemAddress( $sActivaId, $sAddressBookEntry->id, $sAddressBookEntry->text );
	 }
	 }
	 }
	 */

	/**
	 * Insert New Address for Customer
	 *

	 public function setSystemAddress( $sActivaId, $iNetsuiteId, $mAddress ){
	 $sAddress = ( is_array( $mAddress ) )? $this->getAddressString( $mAddress ): $mAddress;
	 $this->_model->setAddress( $sActivaId, $iNetsuiteId, $sAddress );
	 }

	 */
}