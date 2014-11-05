<?php
/**
 * Netsuite_Filter_GiftCertificate class - Gift Certificate Filtering
 *
 * @namespace Netsuite
 * @package Filter
 * @subpackage GiftCertificate
 * @author gWilli
 * @version 1.0
 * @name GiftCertificate.php
 * @copyright 2014
 */
class Netsuite_Filter_GiftCertificate extends Netsuite_Filter_Base implements Netsuite_Interface_IFilter
{
	protected $_requiredFields = array(

			'giftcertcode',
	);

	protected $_aSanatizeFinal = array(
			'giftcertcode' => array('filter' => FILTER_SANITIZE_STRING),
			'giftcertapplied' => array('filter' => FILTER_VALIDATE_FLOAT,
					'flags'  => FILTER_NULL_ON_FAILURE ) );


	public function __construct( array $aGc ) {

		try {
			$this->_logic( $aGc );
			$this->_sanatize();
			$this->_required();
			return( true );

		} catch( Exception $e ) {
			return;
		}
	}

	public function getGiftCertificate() {
		return( self::optimizeValues( $this->_record ) );
	}

	protected function _logic( array $aGc ) {

		$this->_record =  $aGc;
	}
}