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

	protected $_aSanatizeFinal = array(
			'amount' => array('filter' => FILTER_VALIDATE_FLOAT),
			'custcol_produce_in_store' => array('filter' => FILTER_VALIDATE_BOOLEAN),
			'custcol_store_pickup' => array('filter' => FILTER_VALIDATE_BOOLEAN),
			'custcol162' => array('filter' => FILTER_SANITIZE_STRING),
			'description' => array('filter' => FILTER_SANITIZE_STRING),
			'discountitem' => array('filter' => FILTER_VALIDATE_INT),
			'discounttotal' => array('filter' => FILTER_VALIDATE_FLOAT),
			'giftcertfrom' => array('filter' => FILTER_SANITIZE_STRING),
			'giftcertmessage' => array('filter' => FILTER_SANITIZE_STRING),
			'giftcertnumber' => array('filter' => FILTER_SANITIZE_STRING),
			'giftcertrecipientemail' => array('filter' => FILTER_SANITIZE_STRING),
			'giftcertrecipientname' => array('filter' => FILTER_SANITIZE_STRING),
			'isclosed' => array('filter' => FILTER_VALIDATE_BOOLEAN),
			'isestimate' => array('filter' => FILTER_VALIDATE_BOOLEAN),
			'istaxable' => array('filter' => FILTER_VALIDATE_BOOLEAN),
			'item' => array('filter' => FILTER_VALIDATE_INT),
			'location'  => array('filter' => FILTER_SANITIZE_STRING),
			'options' => array('filter' => FILTER_SANITIZE_STRING),
			'price' => array('filter' => FILTER_VALIDATE_INT),
			'quantity' => array('filter' => FILTER_VALIDATE_INT),
			'taxcode' => array('filter' => FILTER_VALIDATE_INT ),
			'rate' => array('filter' => FILTER_VALIDATE_FLOAT),
			'shipaddress' => array('filter' => FILTER_SANITIZE_STRING),
			'shipmethod' => array('filter' => FILTER_SANITIZE_STRING));


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
		
	}
}