<?php 
class LivePos_Maps_Customer extends LivePos_Maps_Map {

	public $custentity_customer_source;
	public $custentity_customer_source_id = 'FPOS_TEST';
	public $entitiyid;
	public $firstname = 'Anonymous';
	public $lastname = 'needNameHere';
	public $email = 'n.ahmad702@gmail.com';
	public $isperson = true;
	public $custentity_fotomail = 'hiimtheguywiththebeard97835@myfotobar.com';
	public $custentitycustomer_department;
	public $recordtype = 'customer';
	public $department;
	public $entitystatus = 13;
	public $globalsubscriptionstatus = 1;
	public $leadsource;
	public $phone;
	public $shipcomplete = false;

	
	/**
	 *
	 * @access public
	 * @return void
	 */
	public function __construct( array $aOrder, $locationData ) {

		parent::__construct();
		$this-> _setInternalSources( $locationData );

	}

	private function _setInternalSources( $locationData ){

		$this->entityid = 866094;
		//$this->entityid = (int) $locationData['location_entity'];
		$this->custentitycustomer_department = (int) $locationData['location_netsuite_department'];
		$this->custentity_customer_source = (int) $locationData['location_netsuite_customer_source'];
		$this->leadsource = (int) $locationData['location_netsuite_lead'];
	}
}