<?php
class Netsuite_Filter {


	private function __construct() {

	}

	public static function factory() {
		return new Netsuite_Filter();
	}
	
	public function refund(  array $refundArray ) {
		return( new Netsuite_Filter_Refund( $refundArray ) );
	}

	public function address(  array $addressArray ) {
		return( new Netsuite_Filter_Address( $addressArray ) );
	}

	public function customer(  array $aCustomer ) {
		return( new Netsuite_Filter_Customer( $aCustomer ) );
	}

	public function contact(  array $aContact ) {
		return( new Netsuite_Filter_Contact( $aContact ) );
	}

	public function salesOrder(  array $aSalesOrder ) {
		return( new Netsuite_Filter_SalesOrder( $aSalesOrder ) );
	}

	public function item(  array $aItemArray ) {
		return( new Netsuite_Filter_Item( $aItemArray ) );
	}

	public function giftCertificate(  array $aGcArray ) {
		return( new Netsuite_Filter_GiftCertificate( $aGcArray ) );
	}
}