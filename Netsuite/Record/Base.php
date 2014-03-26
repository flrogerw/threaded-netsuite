<?php

class Netsuite_Record_Base{

	/**
	 *
	 * @var boolean
	 * @access private
	 */
	protected $_hasErrors = false;
	protected  $_errors = array('Critical', 'Warning');
	protected $_filter;
	protected $_addressbook; // ???  why is this here?
	protected $_logic = array();

	public function __construct(){

	}
	public function run(){}

	public function send() {

		
			$oClient = new SocketServer_Client();

			if( $oClient->isOk() ) {
				if( $oClient->send( $this->getJSON() )) {
					$mReturn = $oClient->response;
				} else {
					self::logError( $oClient->error );
				}
			}

			$mReturn = ( strlen( $mReturn ) > 20  )? json_decode( $mReturn ): $mReturn;
			// Call ONLY after all transactions are complete
			$oClient->close();
			return( $mReturn );
		
	}
	
	public function sendLocal() {
	
	
		$oClient = new SocketServer_Client(true);
		
		if( $oClient->isOk() ) {
			if( $oClient->sendLocal( $this->recordtype, $this->getJSON() )) {
				$mReturn = $oClient->response;
			} else {
				// Add LOgic to use the params below, mimics Netsuite
				$this->status = 'failure';
				$record->payload->code = '';
				$record->payload->details = '';
				self::logError( $oClient->error );
			}
		}
	
		$mReturn = ( strlen( $mReturn ) > 20  )? json_decode( $mReturn ): $mReturn;
		return( $mReturn );
	
	}

	public function getFields()
	{
		$fields = array();
		$ref = ( new ReflectionObject( $this ) )->getProperties( ReflectionProperty::IS_PUBLIC );
		foreach ( $ref as $value )
			$fields[$value->name] = $this->{$value->name};

		return $fields;
	}

	/**
	 * Set sources, department, location based on activa_source (as per George)
	 * @return void
	 */
	protected function _setSources() {

		$oDb = new Netsuite_Db_Model();
		$aSources = $oDb->getSources( $this->_source );
		
		switch( $this->recordtype ) {

			case( 'customer' ):
				$this->custentitycustomer_department = (int) $aSources['department'];
				$this->custentity_customer_source = (int) $aSources['cust_source'];
				$this->leadsource = (int) $aSources['lead'];
				break;

			case( 'salesorder'):
				$this->custbody_order_source = (int) $aSources['order_source'];
				$this->location = (int) $aSources['location'];
				$this->department = (int) $aSources['department'];
				$this->leadsource = (int) $aSources['lead'];
				$this->ccprocessor = (int) $aSources['cc_processor'];
				$this->_itemlocation = $aSources['item_location'];
				break;
		}
	}

	/**
	 * Turns Address Book Array into a Formatted String
	 *
	 * @param array $aAddress
	 * @return string
	 */
	public function getAddressString( array $aAddress ) {

		$aAddressString[] = $aAddress['attention'];
		$aAddressString[] = $aAddress['addressee'];
		$aAddressString[] = $aAddress['addr1'];
		$aAddressString[] = $aAddress['addr2'];
		$aAddressString[] = $aAddress['addr3'];
		$aAddressString[] = $aAddress['city'] . ' ' . $aAddress['state'] . ' ' . $aAddress['zip'];
		return ( implode( "\n", array_filter( $aAddressString ) ) );
	}

	/**
	 *
	 * @return boolean
	 */
	public function isOk() {
		$bIsOk = ( sizeof( $this->_errors['Critical']) > 0 )? false: true;
		return( $bIsOk );
	}

	public function logError( $sError ) {
		$this->_hasErrors = true;
		$this->_errors['Critical'][] = $sError;
	}

	public function logWarn( $sWarn ) {
		$this->_errors['Warning'][] = $sWarn;
	}


	/**
	 *
	 * @return boolean
	 */
	public function getErrors() {
		$this->_errors['Count'] = sizeof( $this->_errors['Critical'] );
		return( $this->_errors['Critical'] );
	}

	protected function _forwardErrors( $sClass , $iRecord = 0) {

		if( empty( $this->_filter->getErrors() ) ){
			return;
		}
			
		foreach( $this->_filter->getErrors() as $sError ){
			$sRecordString = '';
			if( $iRecord > 0 ) {
				$sRecordString = ' in Record ' . $iRecord;
			}			
			self::logError( "$sClass: $sError" . $sRecordString );
		}
	}

	protected function _forwardWarnings( $sClass , $iRecord = 0) {

		if( empty( $this->_filter->getWarnings() ) ){
			return;
		}

		foreach( $this->_filter->getWarnings() as $sWarn ){
			$sRecordString = '';
			if( $iRecord > 0 ) {
				$sRecordString = ' in Record ' . $iRecord;
			}
			self::logWarn( "$sClass: $sWarn" . $sRecordString );
		}
	}

	public function hasWarnings() {
		$bIsOk = ( sizeof( $this->_errors['Warning']) < 1 )? false: true;
		return( $bIsOk );
	}

	/**
	 *
	 * @return boolean
	 */
	public function getWarnings() {
		return( $this->_errors['Warning'] );
	}

	/**
	 * Over-ride magic method __get
	 * @access public
	 * @param $name - Name of parameter to return
	 * @throws Generic Exception
	 * @return mixed
	 */
	public function __get( $sName )
	{
		if( in_array( $sName, array_keys( get_object_vars( $this ) ) ) ) {
			return( $this->$sName );
		}
		self::logWarn( 'No Such Variable( $' . $sName . ' ) in ' . get_class($this) );
	}

	/**
	 * Over-ride magic method __set.
	 *
	 * @access public
	 * @param $name - Name of parameter to set
	 * @param $value - Value of parameter $name to set
	 * @throws Generic Exception
	 * @return void
	 */
	public function __set( $sName, $mValue )
	{
		if( in_array( $sName, array_keys( get_object_vars( $this ) ) ) ) {
			$this->$sName = $mValue;
			return( true );
		}
		self::logWarn( 'No Such Variable( $' . $sName . ' ) in ' . get_class($this) );
	}

	public function setAddressBook( array $aAddressBookEntries, $bIsResidential = true  ) {
		
		$oAddressbook = new Netsuite_Record_AddressBook(  $aAddressBookEntries, $bIsResidential );

		if( !$oAddressbook->isOk() ) {
			$aErrors = $oAddressbook->getErrors();
			$this->logError( 'Could NOT Create AddressBook( '. sizeof( $aErrors ) .' Errors): ' .  implode( ', ', $aErrors ) );
			return;
		}

		return( $oAddressbook->getAddressBook() );
	}

}