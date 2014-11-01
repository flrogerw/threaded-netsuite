<?php
/**
 * Netsuite_Filter_ItemList class - Item Filtering
 *
 * @package Netsuite
 * @subpackage Filter
 * @author gWilli
 * @version 1.0
 * @name ItemList.php
 * @copyright 2013
 * @abstract
 */
class Netsuite_Filter_Item extends Netsuite_Filter_Base implements Netsuite_Interface_IFilter
{

	protected $_requiredFields = array(
			'amount',
			'rate',
			'price',
			//'description',
			'item',
			'quantity'
	);

	protected $_gcRequiredFields = array(
			'giftcertfrom',
			'giftcertmessage',
			'giftcertnumber',
			'giftcertrecipientemail',
			'giftcertrecipientname'
	);

	protected $_aSanatizeFinal = array(
			'addressee' => array('filter' => FILTER_SANITIZE_STRING),
			'addr1' => array('filter' => FILTER_SANITIZE_STRING),
			'addr2' => array('filter' => FILTER_SANITIZE_STRING),
			'amount' => array('filter' => FILTER_VALIDATE_FLOAT),
			'attention' => array('filter' => FILTER_SANITIZE_STRING),
			'city' => array('filter' => FILTER_SANITIZE_STRING),
			'country' => array('filter' => FILTER_SANITIZE_STRING),
			'custcol_produce_in_store' => array('filter' => FILTER_VALIDATE_BOOLEAN),
			'custcol_store_pickup' => array('filter' => FILTER_VALIDATE_BOOLEAN),
			'custcol_image_url' =>array('filter' => FILTER_SANITIZE_STRING),
			'custcol_page_count' =>array('filter' => FILTER_SANITIZE_STRING),
			'custcol162' => array('filter' => FILTER_SANITIZE_STRING),
			//'description' => array('filter' => FILTER_SANITIZE_STRING),
			'discountitem' => array('filter' => FILTER_VALIDATE_INT),
			'discounttotal' => array('filter' => FILTER_VALIDATE_FLOAT),
			'giftcertfrom' => array('filter' => FILTER_SANITIZE_STRING),
			'giftcertmessage' => array('filter' => FILTER_SANITIZE_STRING),
			'giftcertnumber' => array('filter' => FILTER_SANITIZE_STRING),
			'giftcertrecipientemail' => array('filter' => FILTER_SANITIZE_STRING),
			'giftcertrecipientname' => array('filter' => FILTER_SANITIZE_STRING),
			'isclosed' => array('filter' => FILTER_VALIDATE_BOOLEAN),
			'isestimate' => array('filter' => FILTER_VALIDATE_BOOLEAN),
			'isresidential' => array('filter' => FILTER_VALIDATE_BOOLEAN,
					'flags'  => FILTER_NULL_ON_FAILURE),
			'istaxable' => array('filter' => FILTER_VALIDATE_BOOLEAN),
			'item' => array('filter' => FILTER_VALIDATE_INT),
			'location'  => array('filter' => FILTER_SANITIZE_STRING),
			'options' => array('filter' => FILTER_SANITIZE_STRING),
			'phone' => array('filter' => FILTER_VALIDATE_REGEXP,
					'flags'  => FILTER_NULL_ON_FAILURE,
					'options' => array('regexp' => self::PHONE_REGEXP ) ),
			'price' => array('filter' => FILTER_VALIDATE_INT),
			'quantity' => array('filter' => FILTER_VALIDATE_INT),
			'taxcode' => array('filter' => FILTER_VALIDATE_INT ),
			'rate' => array('filter' => FILTER_VALIDATE_FLOAT),
			//'shipaddress' => array('filter' => FILTER_SANITIZE_STRING),
			'shipmethod' => array('filter' => FILTER_SANITIZE_STRING),
			'state' => array('filter' => FILTER_SANITIZE_STRING),
			'zip' => array('filter' => FILTER_SANITIZE_STRING));


	public function __construct( array $aItem )
	{
		try{

			$this->_logic( $aItem );
			$this->_sanatize();
			$this->_required();

			return( true );

		} catch( Exception $e ) {
			return;
		}
	}

	protected function _logic( array $aItem ) {
		$this->_record = $aItem;
		if( $this->_record['giftcertnumber'] != '' ) {
			$this->_requiredFields = array_merge( $this->_requiredFields, $this->_gcRequiredFields );
		}

	}
}