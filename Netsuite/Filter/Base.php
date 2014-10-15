<?php
/**
 * Netsuite_Filter_Base class - Shared Filtering Functions
 *
 * @package Netsuite
 * @subpackage Filter
 * @author gWilli
 * @version 1.0
 * @name Base.php
 * @copyright 2013
 * @abstract
 */
class Netsuite_Filter_Base{


	protected  $_hasErrors = false;
	protected  $_errors = array('Critical', 'Warning');
	protected $_warnings;
	protected $_record;

	protected $_xRefFields = array(
			'paymentmethod' => 'PaymentMethod'
	);

	// Some NS values use 'null' to flag actions.  Enter the NS param name to avoid unsetting empty values.
	public static $_noOptimize = array(
			'shipaddresslist',
			'paymentmethod',
			'phone',
			'custcol162'
	);

	public function run(){
	}

	const PHONE_REGEXP = '/^\s*([\(]?)\[?\s*\d{3}\s*\]?[\)]?\s*[\-]?[\.]?\s*\d{3}\s*[\-]?[\.]?\s*\d{4}$/';
	const EMAIL_REGEXP = '/[A-z0-9._%+-]+@(?:[A-z0-9-]+\.)+[A-z]{2,4}/';
	const DEFAULT_EMAIL = 'failed.email@polaroidfotobar.com';

	public function validateEmail( $sEmail ) {

		//list( $mailbox, $domain ) = explode( '@', $sEmail );  // Commented OUT as per George 10/08/2013

		switch( false ){

			case( preg_match( self::EMAIL_REGEXP, $sEmail ) ):
				//case( getmxrr( $domain, $aServers) ):  // Commented OUT as per George 10/08/2013
				$this->logWarn( "Email ( $sEmail ) Failed Validation, Default Used" );
				return( self::DEFAULT_EMAIL );
				break;
		}
		return( $sEmail );
	}

	public static function optimizeValues( array $aData ) {

		foreach( $aData as $sKey => $mValue ){

			switch( true ) {



				case( is_array( $mValue ) ):

					$mValue = self::optimizeValues( $mValue );
					$aData[$sKey] = $mValue;
					break;

				case( in_array( $sKey, self::$_noOptimize ) ):
					$aData[$sKey] = $mValue;
					break;

				case( is_bool( $mValue ) ):

					switch( true ){

						case( $mValue === true ):

							$aData[$sKey] = 'T';
							break;

						case( $mValue === false ):

							$aData[$sKey] = 'F';
							break;
					}
					break;

				case( is_null( $mValue ) || strlen( $mValue ) < 1 ):

					unset( $aData[$sKey] );
					break;
			}
		}
		return( $aData );
	}

	public function getRecord() {
		return( self::optimizeValues( $this->_record ) );
	}

	/**
	 * Set sources, department, location based on activa_source (as per George)
	 * @return void
	 */
	protected function _setSources() {

		$oDb = new Netsuite_Db_Model();
		$aSources = $oDb->getSources( $this->_record['_source'] );

		switch( $this->_record['recordtype'] ) {

			case( 'customer' ):
				$this->_record['custentitycustomer_department'] = (int) $aSources['department'];
				$this->_record['custentity_customer_source'] = (int) $aSources['cust_source'];
				$this->_record['leadsource'] = (int) $aSources['lead'];
				break;

			case( 'salesorder'):
				$this->_record['custbody_order_source'] = (int) $aSources['order_source'];
				$this->_record['location'] = (int) $aSources['location'];
				$this->_record['department'] = (int) $aSources['department'];
				$this->_record['leadsource'] = (int) $aSources['lead'];
				$this->_record['ccprocessor'] = (int) $aSources['cc_processor'];
				break;
		}
	}

	/**
	 *
	 */
	protected function _sanatize() {

		$this->_record = filter_var_array( $this->_record, $this->_aSanatizeFinal );

	}

	protected function _required() {

		$aMissingFields = array_diff( $this->_requiredFields, array_keys( self::optimizeValues( $this->_record ) ) );

		if( sizeof( $aMissingFields ) > 0 ){
			$this->logError( 'Missing Required Fields: ' . implode(',', $aMissingFields) );
			//throw new Exception();
		}
	}


	protected function _xref() {

		$oDb = new Netsuite_Db_Model();

		foreach( $this->_xRefFields as $sSearch => $mType ) {

			if( !isset( $this->_record[ $sSearch ] ) ) {
				continue;
			}

			$sInternalId = $oDb->callXrefTable( $mType, $this->_record[ $sSearch ], NETSUITE_COMPANY );

			if( $sInternalId == null ){
				$this->logError( "Missing Id Ref: type->$mType, XrefValue->{$this->_record[ $sSearch ]}, company->" . NETSUITE_COMPANY);
				continue;
			}

			$this->_record[ $sSearch ] = $sInternalId;
		}
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
	public function getWarnings() {
		return( $this->_errors['Warning'] );
	}

	public function hasWarnings() {
		$bIsOk = ( sizeof( $this->_errors['Warning']) < 1 )? false: true;
		return( $bIsOk );
	}

	/**
	 *
	 * @return boolean
	 */
	public function getErrors() {
		return( $this->_errors['Critical'] );
	}

	/**
	 *
	 * @return boolean
	 */
	public function isOk() {
		$bIsOk = ( $this->_hasErrors )? false: true;
		return( $bIsOk );
	}
}