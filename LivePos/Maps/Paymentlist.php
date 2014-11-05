<?php

class LivePos_Maps_Paymentlist extends LivePos_Maps_Map{


	protected $_paymentList = array();
	protected $_doscountTotal = 0;

	/**
	 *
	 * @access public
	 * @return void
	*/
	public function __construct( array $aPayments ) {

		parent::__construct();
		$this->_aData = $aPayments;
		$this->_getPaymentList();
	}
	
	public function getPaymentByType( $sPaymentType ){

		(int) $iTypeKey;

		array_walk( $this->_paymentList, function($oPayment, $sKey) use ( $sPaymentType, &$iTypeKey ){
			if( $oPayment->getType() == $sPaymentType ){
				$iTypeKey = $sKey;
			}
		});

			return( $this->_paymentList[ $iTypeKey ] );
	}

	private function _getPaymentList(){

		array_walk( $this->_aData, function($aPayment, $sKey){
			$payment = LivePos_Maps_MapFactory::create( 'payment',  $aPayment );
			$this->_paymentList[] = $payment;
		});
	}

	public function hasPayments(){

		$bReturn = ( !empty( $this->_paymentList ) )? true: false;
		return( $bReturn );
	}

	public function getPayments(){

		return( $this->_paymentList );
	}

}