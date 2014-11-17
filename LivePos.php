#!/usr/bin/php
<?php 
/**
 * Pull Products from LivePOS: 					LivePos.php -t products
 * Pull Receipts by Location and Date: 			LivePos.php  -l [LocationId] -d [TransactionDate] -t receipts 
 * Send Receipts to Netsuite Queue: 			LivePos.php -t orders

 * 
 * 
 */
require_once( __DIR__ . DIRECTORY_SEPARATOR . 'Configure.php' );

$aCommmandLineOptions = getopt("l:t:d:");
$iLocationId = $aCommmandLineOptions['l'];
$sTask = $aCommmandLineOptions['t'];
$dReceiptsDate = $aCommmandLineOptions['d'];

try{
	// See if Process is Already Running And Netsuite is Alive
	$pid = new Netsuite_Pid( '/tmp', basename( __FILE__ ) );

	switch( true){

		case( $pid->already_running ):
			throw new Exception( 'LivePOS Process Already Running' );
			break;
				
		case($sTask == 'products'):
			getProducts();
			break;

		case($sTask == 'orders'):
			processPosOrders();
			break;

		case($sTask == 'receipts'):

			switch( true ){

				case(($timestamp = strtotime($dReceiptsDate)) === false):
					$sError = "\nThe DATE ( $dReceiptsDate ) is NOT Understood.\nPlease use the format: -d YYYY-MM-DD \n";
					break;

				case( !LivePos_Db_Model::isValidLocation( $iLocationId ) ):
					$sError = "\nThe LOCATION ( $iLocationId ) is NOT Understood\nPlease Make Sure $iLocationId is in the livepos_locations DB Table\n";
					break;

				default:
					getReceipts( $iLocationId, date('Y-m-d', $timestamp) );
					break;
			}
			break;

		default:

			$sError = "\nThe TASK ( $sTask ) is NOT Understood\nPlease use '-t orders' or '-t receipts'\n";
			break;
	}


	if( DEBUG ){
		echo( $sError . "\n" );
	}


}catch( Exception $e ){

	if( DEBUG ){
		echo( $e->getMessage() . "\n" );
	}

	Netsuite_Db_Model::logError( $e );
}

function getProducts(){

	$call = new LivePos_Job_GetRecord();
	$call->sendRequest('GetProducts', $call->getSessionId(), array( 'intProductStatus' => 1 ) );

	if( $call->isOk() ){

		$parser = new LivePos_Job_ResponseParser();
		$aResponse = $call->getResponse();
		$productIds = $parser->GetProductIds( $aResponse['data'] );

		if( !empty( $productIds ) ){

			$aProductsChunkedArray = array_chunk( $productIds, LIVEPOS_MAX_RECORDS );
			processPosProducts( $aProductsChunkedArray );
		}
	}

}

function processPosProducts( $aProductsChunkedArray ){

	$aCurrentArray = array_shift( $aProductsChunkedArray);
	$call = new LivePos_Job_GetRecord();
	$processProducts = new LivePos_Thread_ProductsServer( $aCurrentArray, $call->getSessionId() );
	$processProducts->poolProducts();

	if( !empty( $aProductsChunkedArray ) ){
		sleep(61);
		processPosProducts( $aProductsChunkedArray );
	}
}

function getReceipts( $iLocationId, $dReceiptsDate ){

	$call = new LivePos_Job_GetRecord();
	$call->sendRequest('GetReceipts', $call->getSessionId(), array('intLocationID' => $iLocationId, 'dReportDate' => $dReceiptsDate));

	if( $call->isOk() ){

		$parser = new LivePos_Job_ResponseParser();
		$aResponse = $call->getResponse();
		$receiptIds = $parser->GetReceiptIds( $aResponse['data'] );

		if( !empty($receiptIds)){

			$aReceiptsChunkedArray = array_chunk($receiptIds, LIVEPOS_MAX_RECORDS );
			processPosReceipts( $aReceiptsChunkedArray, $iLocationId, $dReceiptsDate );
		}
	}
}


function processPosReceipts( $aReceiptsChunkedArray, $iLocationId, $dReceiptsDate ){

	$aCurrentArray = array_shift( $aReceiptsChunkedArray);
	$call = new LivePos_Job_GetRecord();
	$processReceipts = new LivePos_Thread_ReceiptsServer( $aCurrentArray, $call->getSessionId(), $iLocationId, $dReceiptsDate );
	$processReceipts->poolReceipts();

	if( !empty( $aReceiptsChunkedArray ) ){
		sleep(61);
		processPosReceipts( $aReceiptsChunkedArray, $iLocationId, $dReceiptsDate );
	}
}

function processPosOrders( ){

	$processOrders = new LivePos_Thread_OrdersServer();

	if( $processOrders->hasOrders() ){

		$processOrders->poolOrders();
		processPosOrders();
	}
}