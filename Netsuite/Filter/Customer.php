<?php
/**
 * Netsuite_Filter_Customer class - Customer Filtering
 *
 * @package Netsuite
 * @subpackage Filter
 * @author gWilli
 * @version 1.0
 * @name Customer.php
 * @copyright 2013
 * @abstract
 *
 */
class Netsuite_Filter_Customer extends Netsuite_Filter_Base implements Netsuite_Interface_IFilter
{

	protected $_requiredFields = array(
			'companyname',
			'custentitycustomer_department',
			'custentity_customer_source',
			//'custentity_customer_source_id',
			'email',
			'firstname',
			'lastname',
			//'phone',
			'recordtype'
	);

	protected $_aSanatizeFinal = array(

			'_source' => array('filter' => FILTER_SANITIZE_STRING),
			'companyname' => array('filter' => FILTER_SANITIZE_STRING),
			'custentitycustomer_department' => array('filter' => FILTER_VALIDATE_INT),
			'custentity_customer_source' => array('filter' => FILTER_VALIDATE_INT),
			'custentity_customer_source_id' => array('filter' => FILTER_SANITIZE_STRING),
			'custentity_fotomail' => array('filter' => FILTER_VALIDATE_EMAIL,
					'flags'  => FILTER_NULL_ON_FAILURE),
			'email' => array('filter' => FILTER_CALLBACK,
					'options' => 'self::validateEmail'),
			'entityid' => array('filter' => FILTER_SANITIZE_STRING),
			'entitystatus' => array('filter' => FILTER_VALIDATE_INT),
			'firstname' => array('filter' => FILTER_SANITIZE_STRING),
			'globalsubscriptionstatus' => array('filter' => FILTER_VALIDATE_INT),
			'isperson' => array('filter' => FILTER_VALIDATE_BOOLEAN ),
			'lastname' => array('filter' => FILTER_SANITIZE_STRING),
			'phone' => array('filter' => FILTER_VALIDATE_REGEXP,
					'flags'  => FILTER_NULL_ON_FAILURE,
					'options' => array('regexp' => self::PHONE_REGEXP ) ),
			'recordtype' => array('filter' => FILTER_VALIDATE_REGEXP,
					'flags'  => FILTER_NULL_ON_FAILURE,
					'options' => array('regexp' => '/^customer$/' ) ),
			'shipcomplete' => array('filter' => FILTER_VALIDATE_BOOLEAN,
					'default' => false ));

	public function __construct( array $aCustomer ) {

		try{
			$this->_logic( $aCustomer );
			$this->_sanatize();
			$this->_required();

			return( true );
		} catch( Exception $e ) {
			return;
		}
	}


	protected function _logic( $aCustomer ) {

		$this->_record = $aCustomer;
		$this->isPerson();
	}

	/**
	 * Checks $_record for value of isperson, sets un-needed fields to null and removes
	 * unwanted $_requiredFields.
	 * MOve to base if used by contacts
	 */
	protected function isPerson() {

		if( $this->_record['isperson'] === true ) {
			unset( $this->_requiredFields[ array_search('companyname', $this->_requiredFields) ] );

		}
	}
}
