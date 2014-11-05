<?php

class Netsuite_Record_GiftCertificate extends Netsuite_Record_Base implements Netsuite_Interface_INetsuite {

	public $giftcertcode;

	public function __construct( array $aGc ) {

		try{

			$aGc = ( array_merge( get_object_vars( $this ), $aGc ) );

			$this->_setValues( $aGc );

			if( !$this->_validate( $this->getFields() ) ) {
				return;
			}

			$this->_forwardWarnings( get_class() );
			$this->_forwardErrors( get_class() );

		} catch( Exception $e ) {
			self::logError( 'Could NOT Create Gift Certificate: ' . $e->getMessage() );
			return;
		}
	}

	protected function _setValues( array $aGc ) {

		foreach( $aGc as $key => $value ) {
			$this->$key = $value;
		}
	}

	/**
	 *
	 * @param array $aGc
	 * @return boolean
	 */
	protected function _validate( $aGc ) {

		$this->_filter = Netsuite_Filter::factory()->giftcertificate( $aGc );

		if( !$this->_filter->isOk() ) {

			$this->_forwardErrors( get_class() );
			$this->_forwardWarnings( get_class() );

			return( false );
		}

		return( true );
	}


	public function getGiftCertificate() {
		return( $this->_filter->optimizeValues( $this->_filter->getRecord() ) );
	}

	public function getJSON() {
		return( json_encode( $this->getItem() ) );
	}
	
}