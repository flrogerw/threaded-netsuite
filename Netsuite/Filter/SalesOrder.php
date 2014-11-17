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
class Netsuite_Filter_SalesOrder extends Netsuite_Filter_Base implements Netsuite_Interface_IFilter
{
	protected $_requiredFields = array(
			//'billaddress',
			//'custbody_activa_order_number',
			'custbody_order_source',
			//'custbody_source_code',
			//'custentity_customer_source_id',
			'customform',
			//'custbody_pickticketnotes',
			'custbody_order_source_id',
			'discounttotal',
			'entity',
			'handlingcost',
			'ismultishipto',
			//'otherrefnum',
			'paymentmethod',
			'recordtype',
			//'shipaddress',
			'shipdate',
			//'shipmethod',
			//'shippingcost',
			//'taxrate',
			//'taxtotal',
			//'total',
			'trandate',
			//'salesrep',
			//'message', ///??????
			//'discountitem'
	);


	protected $_ccFieldsRequired = array(
			'ccexpiredate',
			'ccname',
			'ccnumber',
			'cczipcode',
			'pnrefnum'
	);


	protected $_aSanatizeFinal = array(
			'addressbook'  => array('filter' => FILTER_SANITIZE_STRING),
			'authcode' => array('filter' => FILTER_SANITIZE_STRING),
			'billaddress' => array('filter' => FILTER_SANITIZE_STRING),
			'ccapproved' => array('filter' => FILTER_VALIDATE_BOOLEAN),
			'ccexpiredate' => array('filter' => FILTER_VALIDATE_REGEXP,
					'flags'  => FILTER_NULL_ON_FAILURE,
					'options' => array('regexp' => "/^(0[1-9]|1[012])\/(20)\d\d$/" ) ),
			'ccname' => array('filter' => FILTER_SANITIZE_STRING),
			'ccnumber' => array('filter' => FILTER_SANITIZE_STRING),
			'cczipcode'  => array('filter' => FILTER_SANITIZE_STRING),
			//'custbody_activa_order_number' => array('filter' => FILTER_SANITIZE_STRING),
			'custbody_comments' => array('filter' => FILTER_SANITIZE_STRING),
			//'custbody_event_date'  => array('filter' => FILTER_VALIDATE_REGEXP,
			//'flags'  => FILTER_NULL_ON_FAILURE,
			//'options' => array('regexp' => "/^(0[1-9]|1[012])\/(20)\d\d$/" ) ),
			'custbody_order_source' => array('filter' => FILTER_SANITIZE_STRING),
			'custbody_order_source_id' => array('filter' => FILTER_SANITIZE_STRING),
			'custbody_pickticketnotes' => array('filter' => FILTER_SANITIZE_STRING),
			'custbody_pos_trans_id'=> array('filter' => FILTER_SANITIZE_STRING),
			'custbody_pos_postranstime' => array('filter' => FILTER_SANITIZE_STRING),

			'custbody_pos_auth_code' => array('filter' => FILTER_SANITIZE_STRING),
			'custbody_pos_cc_exp_date' => array('filter' => FILTER_VALIDATE_REGEXP,
					'flags'  => FILTER_NULL_ON_FAILURE,
					'options' => array('regexp' => "/^(0[1-9]|1[012])\/(20)\d\d$/" ) ),
			'custbody_pos_cc_number' => array('filter' => FILTER_SANITIZE_STRING),
			'custbody_pos_invoice' => array('filter' => FILTER_SANITIZE_STRING),
			'custbody_pos_ref_num' => array('filter' => FILTER_SANITIZE_STRING),
			'custbody_pos_receipt' => array('filter' => FILTER_SANITIZE_STRING),
			'custbody_pos_cash_total' => array('filter' => FILTER_VALIDATE_FLOAT),
			'custbody_pos_cc_total' => array('filter' => FILTER_VALIDATE_FLOAT),
			'custbody_pos_gc_code'  => array('filter' => FILTER_SANITIZE_STRING),
			'custbody_pos_gc_total' => array('filter' => FILTER_VALIDATE_FLOAT),
			'custbody_pos_receipt_total' => array('filter' => FILTER_VALIDATE_FLOAT),
				
			'custbody_pos_employee'  => array('filter' => FILTER_SANITIZE_STRING),
			'custbody_pos_receipt_date' => array('filter' => FILTER_SANITIZE_STRING),
			'custbody_pos_location'  => array('filter' => FILTER_SANITIZE_STRING),
			'custbody_pos_shipping_charge'  => array('filter' => FILTER_VALIDATE_FLOAT,
			'flags'  => FILTER_NULL_ON_FAILURE),

			'custbody_pos_tax_total' => array('filter' => FILTER_VALIDATE_FLOAT,
			'flags'  => FILTER_NULL_ON_FAILURE),
			
			'custbody_pos_shipped_tax' => array('filter' => FILTER_VALIDATE_FLOAT,
			'flags'  => FILTER_NULL_ON_FAILURE),

			'custbody_source_code' => array('filter' => FILTER_SANITIZE_STRING),
			'custbody_textrequired' => array('filter' => FILTER_VALIDATE_BOOLEAN),
			'custbody_web_discount_code' => array('filter' => FILTER_SANITIZE_STRING),
			'custentity_customer_source_id' => array('filter' => FILTER_SANITIZE_STRING),
			'customform' => array('filter' => FILTER_VALIDATE_INT),
			'department' => array('filter' => FILTER_VALIDATE_INT),
			'discountitem'  => array('filter' => FILTER_VALIDATE_INT,
					'flags'  => FILTER_NULL_ON_FAILURE ),
			'discountrate'  => array('filter' => FILTER_VALIDATE_FLOAT),
			'discounttotal' => array('filter' => FILTER_VALIDATE_FLOAT),
			'entity' => array('filter' => FILTER_VALIDATE_INT),
			'getauth' => array('filter' => FILTER_VALIDATE_BOOLEAN ),
			'handlingcost' => array('filter' => FILTER_VALIDATE_FLOAT),
			'ismultishipto' => array('filter' => FILTER_VALIDATE_BOOLEAN ),
			'istaxable' => array('filter' => FILTER_VALIDATE_BOOLEAN ),
			'leadsource' => array('filter' => FILTER_VALIDATE_INT ),
			'location'  => array('filter' => FILTER_VALIDATE_INT ),
			'otherrefnum' => array('filter' => FILTER_SANITIZE_STRING ),
			'orderstatus' => array('filter' => FILTER_SANITIZE_STRING ),
			'paymentmethod' => array('filter' => FILTER_VALIDATE_INT ),
			'pnrefnum' => array('filter' => FILTER_SANITIZE_STRING ),
			'recordtype' => array('filter' => FILTER_VALIDATE_REGEXP,
					'options' => array('regexp' => '/^salesorder$/' ) ),
			'salesrep' => array('filter' => FILTER_VALIDATE_INT,
					'flags'  => FILTER_NULL_ON_FAILURE),
			'shipaddress' => array('filter' => FILTER_SANITIZE_STRING,
					'flags'  => FILTER_NULL_ON_FAILURE ),
			'shipcomplete' => array('filter' => FILTER_SANITIZE_STRING ),
			'shipdate' => array('filter' => FILTER_SANITIZE_STRING ),
			'shipmethod' => array('filter' => FILTER_VALIDATE_INT ),
			'shippingcost' => array('filter' => FILTER_VALIDATE_FLOAT),
			'taxrate' => array('filter' => FILTER_SANITIZE_STRING),
			'taxtotal' => array('filter' => FILTER_VALIDATE_FLOAT),
			'tobeemailed' => array('filter' => FILTER_VALIDATE_BOOLEAN),
			'tobeprinted' => array('filter' => FILTER_VALIDATE_BOOLEAN),
			'total' => array('filter' => FILTER_VALIDATE_FLOAT),
			'trandate' => array('filter' => FILTER_SANITIZE_STRING),
			'tranid' => array('filter' => FILTER_SANITIZE_STRING),
			'shipoverride' => array('filter' => FILTER_VALIDATE_BOOLEAN),

	);


	public function __construct( array $aSalesOrder ) {

		try {
			$this->_logic( $aSalesOrder );
			$this->_sanatize();
			$this->_required();
			return( true );

		} catch( Exception $e ) {
			return;
		}
	}

	/**
	 * Validate the Sales Order Contains All Required Fields for Setting Logic Values
	 *
	 * @deprecated
	 * @param array $aSalesOrder
	 * @return boolean
	 */
	public static function preFlight( array $aSalesOrder ) {

		if( $aSalesOrder['_paymentmethod_flag'] == 'creditcard' ) {
			self::$preFlightRequired = array_merge( self::$preFlightRequired, self::$preFlightCcFields );
		}

		$aRecord = filter_var_array( $aSalesOrder, self::$aPreFlightSanatize, false );
		$aMissingFields = array_diff( self::$preFlightRequired, array_keys( $aRecord ) );

		if( sizeof( array_diff( self::$preFlightRequired, array_keys( $aRecord ) ) ) > 0  ) {
			return( false );
		}
		return( true );
	}

	public function getSalesOrder() {
		return( self::optimizeValues( $this->_record ) );
	}

	protected function _logic( array $aSalesOrder ) {

		$this->_record =  $aSalesOrder;
		//$this->_paymentType = $this->_record['_paymentmethod_flag'];

		if( $this->_record['discounttotal'] < 0 ){
			// array_push( $this->_requiredFields, 'discountitem' );
		}

		if( $this->_record['ccnumber'] != '' ) {
			$this->_requiredFields = array_merge( $this->_requiredFields, $this->_ccFieldsRequired );
		}
	}
}
