<?php

class Netsuite_Record_Refund extends Netsuite_Record_Base implements Netsuite_Interface_INetsuite {

	public $account;
	public $department;
	public $entity;
	public $item = array();
	public $location;
	public $memo;
	public $paymentmethod;
	public $trandate;


	public function __construct( array $aRefund ) {

		try{

			$aRefund = ( array_merge( get_object_vars( $this ), $aRefund ) );

			if( !$this->_validate( $this->getFields() ) ) {
				return;
			}

			$this->_forwardWarnings( get_class() );
			$this->_forwardErrors( get_class() );

		} catch( Exception $e ) {
			
			self::logError( 'Could NOT Create Refund: ' . $e->getMessage() );
			return;
		}
	}


	protected function _validate( $aRefund ) {

		$this->_filter = Netsuite_Filter::factory()->refund( $this->getFields() );

		if(!$this->_filter->isOk()){

			$this->_forwardErrors( get_class() );
			$this->_forwardWarnings( get_class() );
			return( false );
		}

		return( true );
	}

	public function getRefund() {

		$aRefund =  $this->_filter->optimizeValues( $this->_filter->getRecord() );
		return( $aRefund );
	}

	public function getJSON() {

		return( json_encode( $this->getSalesOrder() ) );
	}
}
