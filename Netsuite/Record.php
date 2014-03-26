<?php
class Netsuite_Record{


	private function __construct() {

	}

	public static function factory() {
		return new Netsuite_Record();
	}

	public function addressBook(  array $addressArray ) {
		return( new Netsuite_Record_AddressBook( $addressArray ) );
	}

	public function address(  array $address, $Type ) {
		return( new Netsuite_Record_Address( $address, $Type ) );
	}

	public function customer(  array $aCustomer ) {
		return( new Netsuite_Record_Customer( $aCustomer ) );
	}

	public function contact(  array $aContact ) {
		return( new Netsuite_Record_Contact( $aContact ) );
	}

	public function salesOrder(  array $aSalesOrder, Netsuite_Record_Customer $oCustomer ) {
		return( new Netsuite_Record_SalesOrder( $aSalesOrder, $oCustomer ) );
	}

	public function itemList(  array $aItemArray, $iLocationId, $sActivaId, $iEntityId ) {
		return( new Netsuite_Record_ItemList( $aItemArray, $iLocationId, $sActivaId, $iEntityId ) );
	}

	//public function item(  array $aItem, $iLocationId, $sItemLocation ) {
	public function item( array $aItem, $iLocationId, $sActivaId ) {
		return( new Netsuite_Record_Item( $aItem, $iLocationId, $sActivaId ) );
	}
	
	public function discountitem( array $aItem, $iLocationId, $sActivaId ) {
		return( new Netsuite_Record_Item( $aItem, $iLocationId, $sActivaId, 'DiscountType' ) );
	}
}