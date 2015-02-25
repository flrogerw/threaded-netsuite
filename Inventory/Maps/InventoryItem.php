<?php

class Inventory_Maps_InventoryItem extends LivePos_Maps_Map {

	/*
	 'intLocationID' => intval($aItem['intLocationID']),
	'intProductID' => intval($aItem['intProductID']),
	'intMinimumUnits' => intval($aItem['intMinimumUnits']),
	'intUnitsAvailable' => intval( $iItemCount ),
	'dblProductPrice' => floatval($aItem['dblProductPrice']),
	'dblProductTax1' => floatval($aItem['dblProductTax1']),
	'dblProductTax2' => floatval($aItem['dblProductTax2']),
	'dblProductTax3' => floatval($aItem['dblProductTax3']),
	//'dblMinimumPrice' => floatval($aItem['dblMinimumPrice']),
	'dblMinimumPrice' => 0.01,
	'bAlertIfBelowMinimumUnits' => $aItem['bAlertIfBelowMinimumUnits'],
	'bAutoPurchaseOrderIfBelowMinimumUnits' => $aItem['bAutoPurchaseOrderIfBelowMinimumUnits'],
	'bIsFixedPrice' => $aItem['bIsFixedPrice'],
	'bIsTaxExempted' => $aItem['bIsTaxExempted'] );

	*/

	public $intLocationID;
	public $intProductID;
	public $intMinimumUnits;
	public $intUnitsAvailable;
	public $dblProductPrice;
	public $dblProductTax1;
	public $dblProductTax2 = 0.00;
	public $dblProductTax3 = 0.00;
	public $dblMinimumPrice = 0.01;
	public $bAlertIfBelowMinimumUnits;
	public $bAutoPurchaseOrderIfBelowMinimumUnits;
	public $bIsFixedPrice;
	public $bIsTaxExempted;


	/**
	 *
	 * @access public
	 * @return void
	 */
	public function __construct( array $aInventoryItem ) {
		
		
		foreach( get_object_vars( $this ) as $key => $value ){
			
			$this->$key = $aInventoryItem[ $key ];
		}
		
/*
		$aInventoryItem = ( array_merge( get_object_vars( $this ), $aInventoryItem ) );
		
		foreach( $aInventoryItem as $key => $value ) {
			$this->$key = $value;
		}
*/
		$this->logic();
		parent::__construct();
	}

	private function logic(){

		// Over Rides '0' Value
		$this->dblMinimumPrice = ( $this->dblMinimumPrice == 0 )? 0.01: $this->dblMinimumPrice;
	}

}