<?php
/**
 * Netsuite_Filter_Contact class - Contact Filtering
 *
 * @package Netsuite
 * @subpackage Filter
 * @author gWilli
 * @version 1.0
 * @name Contact.php
 * @copyright 2013
 * @abstract
 */
class Netsuite_Filter_Contact extends Netsuite_Filter_Base implements Netsuite_Interface_IFilter
{

	protected $_requiredFields = array(
			'firstname',
			'lastname',
			'email',
			
			
			
			
			
			
			
			
			
			
			
			
			
			
			
			
			
			
			
			
			
			
			
			
			
			
			
			
			
			
			
			
			
			
			
			
			
			
			
			
			
			
			
			
			
	'phone');

        public function __construct( array $aContact ) {

                try{
                        $this->_record = $this->_sanatize( $aContact );
                        $this->_logic();
                        return( true );
                } catch( Exception $e ) {
                        return;
                }
        }

        public function getContact() {
                return( $this->_record );
        }

        protected function _logic() {
                $this->_required();
                $this->_xref( 'Fotobar' );
        }


        /**
         */
        protected function _sanatize( $aContact ) {

                $aSanatize = array(
                                'firstname' => array('filter' => FILTER_SANITIZE_STRING),
                                'lastname' => array('filter' => FILTER_SANITIZE_STRING),
                                'email' => array('filter' => FILTER_CALLBACK,
                                                'options' => 'self::validateEmail'),
                                'companyname' => array('filter' => FILTER_SANITIZE_STRING),
                                'phone' => array('filter' => FILTER_VALIDATE_REGEXP,
                                                'flags'  => FILTER_NULL_ON_FAILURE,
                                                'options' => array('regexp' => self::PHONE_REGEXP ) ),
                                'recordtype' => array('filter' => FILTER_VALIDATE_REGEXP,
                                                'flags'  => FILTER_NULL_ON_FAILURE,
                                                'options' => array('regexp' => '/^contact$/' ) ),

                                'isperson' => array('filter' => FILTER_VALIDATE_BOOLEAN ) );

                return( filter_var_array( $aContact, $aSanatize ) );
        }
}