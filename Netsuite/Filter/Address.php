<?php
/**
 * Netsuite_Filter_Address class - Address Filtering
 *
 * @package Netsuite
 * @subpackage Filter
 * @author gWilli
 * @version 1.0
 * @name Address.php
 * @copyright 2013
 * @abstract
 */
class Netsuite_Filter_Address extends Netsuite_Filter_Base implements Netsuite_Interface_IFilter
{

	protected $_aSanatizeFinal = array();
	protected  $_requiredFields = array();


	public function __construct( array $aAddress )
	{
		$this->_requiredFields = array(
				'addressee',
				'addr1',
				'city',
				'country',
				'phone',
				'state',
				'zip',
		);

		$this->_aSanatizeFinal = array(

				'addressee' => array('filter' => FILTER_SANITIZE_STRING),
				'addr1' => array('filter' => FILTER_SANITIZE_STRING),
				'addr2' => array('filter' => FILTER_SANITIZE_STRING),
				'addr3' => array('filter' => FILTER_SANITIZE_STRING),
				'attention' => array('filter' => FILTER_SANITIZE_STRING),
				'city' => array('filter' => FILTER_SANITIZE_STRING),
				'country' => array('filter' => FILTER_SANITIZE_STRING),
				'defaultbilling' => array('filter' => FILTER_VALIDATE_BOOLEAN,
						'flags'  => FILTER_NULL_ON_FAILURE),
				'defaultshipping' => array('filter' => FILTER_VALIDATE_BOOLEAN,
						'flags'  => FILTER_NULL_ON_FAILURE),
				'isresidential' => array('filter' => FILTER_VALIDATE_BOOLEAN,
						'flags'  => FILTER_NULL_ON_FAILURE),
				'label' => array('filter' => FILTER_SANITIZE_STRING),
				'phone' => array('filter' => FILTER_VALIDATE_REGEXP,
						'options' => array('regexp' => Netsuite_Filter_Base::PHONE_REGEXP ) ),
				'province' => array('filter' => FILTER_SANITIZE_STRING),
				'state' => array('filter' => FILTER_SANITIZE_STRING),
				'zip' => array('filter' => FILTER_SANITIZE_STRING),
		);


		try{
			$this->_logic( $aAddress );
			$this->_sanatize();
			$this->_required();

		} catch( Exception $e ) {
			return;
		}
	}

	protected function _logic( $aAddress ) {
		$this->_record =  $aAddress;
		$this->_record = array_map( 'ucwords',  $this->_record );
	}
}