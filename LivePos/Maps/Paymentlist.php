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

	public function getPaymentsByTypeId( $iPaymentTypeId ){
		
		$aTempPayments = array();

		array_walk( $this->_paymentList, function($oPayment, $sKey) use ( &$aTempPayments ){			
				$aTempPayments[ $oPayment->getTypeId() ][] = $oPayment;
		});
		
			$aReturn = ( empty( $aTempPayments[ $iPaymentTypeId ] ) )? array(): $aTempPayments[ $iPaymentTypeId ];
			return( $aReturn );
	}


	public function getTotalByType( $iPaymentTypeId ){

		$aPayments = $this->getPaymentsByTypeId( $iPaymentTypeId );
		$fTotal = 0;
		
		array_walk( $aPayments, function($oPayment, $sKey) use(&$fTotal){
			$fTotal +=  $oPayment->getAmount();
		});
		
		if( $iPaymentTypeId == 1 ){
			$fTotal += $this->getTotalByType( 3 );
		}

			return( $fTotal );
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