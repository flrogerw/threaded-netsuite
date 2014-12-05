<?php
/**
 * Netsuite_Filter_SalesOrder class - SalesOrder Filtering
 *
 * @namespace Netsuite
 * @package Filter
 * @subpackage SalesOrder
 * @author gWilli
 * @version 1.0
 * @name SaleOrder.php
 * @copyright 2013
 */
class Netsuite_Filter_Refund extends Netsuite_Filter_Base implements Netsuite_Interface_IFilter
{
	protected $_requiredFields = array(
			'account',
			'department',
			'entity',
			'location',
			'memo',
			'paymentmethod',
			'trandate'
	);

	protected $_aSanatizeFinal = array(
			'account' => array('filter' => FILTER_VALIDATE_INT),
			'department' => array('filter' => FILTER_VALIDATE_INT),
			'entity' => array('filter' => FILTER_VALIDATE_INT),
			'location' => array('filter' => FILTER_VALIDATE_INT),			
			'memo' => array('filter' => FILTER_SANITIZE_STRING),
			'paymentmethod' => array('filter' => FILTER_VALIDATE_INT),
			'trandate' => array('filter' => FILTER_VALIDATE_REGEXP,
					'flags'  => FILTER_NULL_ON_FAILURE,
					'options' => array('regexp' => "/^(0[1-9]|1[012])\/([012][0-9]|3[01])\/(20)\d\d$/" ) )
	);


	public function __construct( array $aRefund ) {

		try {
			$this->_logic( $aRefund );
			$this->_sanatize();
			$this->_required();
			return( true );

		} catch( Exception $e ) {
			return;
		}
	}


	public function getRefund() {
		return( self::optimizeValues( $this->_record ) );
	}

	protected function _logic( array $aRefund ) {

		$this->_record =  $aRefund;
	}
}
