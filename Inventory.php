#!/usr/bin/php
<?php
/**
 * Add Suspended Sale Class and Example Code
 *
 * @author gWilli
 * @version 1.0
 */

require_once( __DIR__ . DIRECTORY_SEPARATOR . 'Configure.php' ); // Has LivePOS Login Credentials


$aIgnoreCategories = array( 61589, 61830, 61866, 61867, 61868, 61864, 62692 );

$call = new LivePos_Job_GetRecord();
$model = new Inventory_Db_Model();
//$aLocations = $model->getLivePosLocations();


$aLocations = array( array( 'location_netsuite_id' => 2, 'location_id' => 28225, 'location_name' => 'Delray') );

foreach( $aLocations as $aLocation ){

	$aLivePosUpdate = array();
	$aPosItemInventory = array();
	
	// ###### GET POS INVENTORY
	$aLocationId = array( 'intLocationID' => $aLocation['location_id'] );
	$call->sendRequest('GetLocationInventory', $call->getSessionId(), $aLocationId);
	$aPosInventory = json_decode( $call->getDataString(), true );

	foreach( $aPosInventory as $iKey => $aItem ){

		if( !in_array( $aItem['intProductCategoryID'], $aIgnoreCategories ) ){

			$aPosItemInventory[ $aItem['strProductSKU'] ] = array( 'units_available' => $aItem['intUnitsAvailable'], 'parent_key' => $iKey );
		}
	}

	// ###### GET NETSUITE INVENTORY

		$inventory = new Inventory_Job_GetInventory( $aLocation['location_netsuite_id'] );

		if( $inventory->isOk() ){

			$aNsItemInventory = json_decode( $inventory->getResponse(), true );
		}


		foreach( $aNsItemInventory as $sSku => $iItemCount ){
			
			$model->insertInventory( array( ':store_name' => $aLocation['location_name'], ':product_id' => $sSku, ':ns_count' => intval($iItemCount), ':pos_count' => $aPosItemInventory[ $sSku ]['units_available'] ) );

			switch( true ){

				case( !isset( $aPosItemInventory[ $sSku ] ) ):

					break;

				case( $aPosItemInventory[ $sSku ]['units_available'] != intval($iItemCount) ):

					$aItem = $aPosInventory[ $aPosItemInventory[ $sSku ]['parent_key'] ];

					$InventoryItem = array(
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

					$aLivePosUpdate[] = $InventoryItem;
					break;

				default:

					break;
			}
		}
		var_dump( $aLivePosUpdate );
		sleep(61);
	}
	
	
	//var_dump($aLivePosUpdate[0]);

	//$call->sendRequest('UpdateLocationInventory', $call->getSessionId(), $aLivePosUpdate[0] );

	//var_dump($call->getResponse() );

	//var_dump( $aLivePosUpdate );

	die();
	/*


	//$call->sendRequest('UpdateLocationInventory', $call->getSessionId(), $InventoryItem );
	*/

	$aSuspendedSale = array( 'intSuspendedSaleID' => 63, 'intLocationID' => $iLocationId  );
	$call->sendRequest('GetSuspendedSale', $call->getSessionId(), $aSuspendedSale );
	var_dump( $call->getResponse() );
	die();
	//$call->sendRequest('UpdateLocationInventory', $call->getSessionId(), $InventoryItem );
