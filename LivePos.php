#!/usr/bin/php
<?php 
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

function getReceipts( $iLocationId, $dReceiptsDate ){

	$call = new LivePos_Job_GetRecord();
	$call->sendRequest('GetReceipts', $call->getSessionId(), array('intLocationID' => $iLocationId, 'dReportDate' => $dReceiptsDate));

	if( $call->isOk() ){

		$parser = new LivePos_Job_ResponseParser();
		$aResponse = $call->getResponse();
		$receiptIds = $parser->GetReceiptIds( $aResponse['data'] );

		if( !empty($receiptIds)){

			$aReceiptsChunkedArray = array_chunk($receiptIds, LIVEPOS_MAX_RECORDS );
			processPosReceipts( $aReceiptsChunkedArray, $call, $iLocationId, $dReceiptsDate );
		}
	}
}


function processPosReceipts( $aReceiptsChunkedArray, $call, $iLocationId, $dReceiptsDate ){

	$aCurrentArray = array_shift( $aReceiptsChunkedArray);
	$processReceipts = new LivePos_Thread_ReceiptServer( $aCurrentArray, $call->getSessionId(), $iLocationId, $dReceiptsDate );
	$processReceipts->poolReceipts();

	if( !empty( $aReceiptsChunkedArray ) ){
		sleep(61);
		processPosReceipts( $aReceiptsChunkedArray, $call, $iLocationId, $dReceiptsDate );
	}
}

function processPosOrders( ){

	$processOrders = new LivePos_Thread_OrderServer();

	if( $processOrders->hasOrders() ){

		$processOrders->poolOrders();
		processPosOrders();
	}
}