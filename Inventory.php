#!/usr/bin/php
<?php
/**
 * Inventory Class
 *
 * @author gWilli
 * @version 1.0
 */

try {

	require_once( __DIR__ . DIRECTORY_SEPARATOR . 'Configure.php' ); // Has LivePOS Login Credentials

	$model = new Inventory_Db_Model();
	$aPosCategories  = $model->getLivePosCategories();
	//$aLocations = $model->getLivePosLocations();
	//$aPosCategories = array( 61589, 61830, 61866, 61867, 61868, 61864, 62692 );
	$aLocations = array( array( 'location_netsuite_id' => 2, 'location_id' => 28225, 'location_name' => 'Delray') );

	foreach( $aLocations as $aLocation ){

		$aLivePosUpdate = array();
		$aPosItemInventory = array();

		// ###### GET POS INVENTORY
		$aLocationId = array( 'intLocationID' => $aLocation['location_id'] );
		$call = new LivePos_Job_GetRecord();
		$call->sendRequest('GetLocationInventory', $call->getSessionId(), $aLocationId);

		if( $call->isOk() ){

			$aPosInventory = json_decode( $call->getDataString(), true );

			foreach( $aPosInventory as $iKey => $aItem ){

				if( in_array( $aItem['intProductCategoryID'], $aPosCategories ) ){

					$aPosItemInventory[ $aItem['strProductSKU'] ] = array( 'units_available' => $aItem['intUnitsAvailable'], 'parent_key' => $iKey );
				}
			}
		}else{
			throw new Exception( "Could Not Get PosInventory from LivePOS for {$aLocation['location_id']}: " . $call->getErrors() );
		}

		// ###### GET NETSUITE INVENTORY

		$inventory = new Inventory_Job_GetInventory( $aLocation['location_netsuite_id'] );

		if( $inventory->isOk() ){

			$aNsItemInventory = json_decode( $inventory->getResponse(), true );

			foreach( $aNsItemInventory as $sSku => $iItemCount ){

				$model->insertInventory( array( ':store_name' => $aLocation['location_name'], ':product_id' => $sSku, ':ns_count' => intval($iItemCount), ':pos_count' => $aPosItemInventory[ $sSku ]['units_available'] ) );

				switch( true ){

					case( !isset( $aPosItemInventory[ $sSku ] ) ):

						break;

					case( $aPosItemInventory[ $sSku ]['units_available'] != intval($iItemCount) ):

						$InventoryItem = new Inventory_Maps_InventoryItem( $aPosInventory[ $aPosItemInventory[ $sSku ]['parent_key'] ], intval($iItemCount) );
						$aLivePosUpdate[] = $InventoryItem->getPublicVars( false );
						break;

					default:

						break;
				}
			}
		}else{
			throw new Exception( "Could Not Get Netsuite Inventory from Netsuite for {$aLocation['location_netsuite_id']}: " . $inventory->getResponse() );
		}

		if( !empty( $aLivePosUpdate )){

			//var_dump($aLivePosUpdate);
			//ob_flush();

			$aInventoryChunkedArray = array_chunk( $aLivePosUpdate, LIVEPOS_MAX_INVENTORY_THREADS );
			processInventory( $aInventoryChunkedArray );
		}


		//echo("{$aLocation['location_id']} \n");
	}

}catch( Exception $e ){
	Inventory_Db_Model::logError( $e );
	Utils_Email::sendInventoryEmail( $aLocationId, $e->getMessage() );
	var_dump($e);
}



########################################################################################################################


function processInventory( $aInventoryChunkedArray, $iLocationId ){

	try{
		$aCurrentArray = array_shift( $aInventoryChunkedArray);
		$call = new LivePos_Job_GetRecord();
		$processInventory = new Inventory_Thread_InventoryServer( $aCurrentArray, $call->getSessionId() );
		$processInventory->poolInventory();

		if( !empty( $aInventoryChunkedArray ) ){
			sleep(61);
			processInventory( $aInventoryChunkedArray, $iLocationId );
		}
	}catch( Exception $e ){
		
		Utils_Email::sendInventoryEmail( $iLocationId, $e->getMessage() );
	}
}