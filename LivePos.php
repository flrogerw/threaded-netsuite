#!/usr/bin/php
<?php 
require_once( __DIR__ . DIRECTORY_SEPARATOR . 'Configure.php' );

$locationId = 27449;
$runType = 'order';
//$runType = 'receipt';

try{
	// See if Process is Already Running And Netsuite is Alive
	$pid = new Netsuite_Pid( '/tmp', basename( __FILE__ ) );


	switch( true){

		case( $pid->already_running ):
			throw new Exception( 'LivePOS Process Already Running' );
			break;

		case($runType == 'order'):
			processPosOrders();
			break;
		
		case($runType == 'receipt'):

			
			getReceipts($locationId);
			break;
	}

}catch( Exception $e ){

	if( DEBUG ){
		echo( $e->getMessage() . "\n" );
	}

	Netsuite_Db_Model::logError( $e );
}

function getReceipts($locationId){

	$call = new LivePos_Job_GetRecord();
	$call->sendRequest('GetReceipts', $call->getSessionId(), array('intLocationID' => $locationId, 'dReportDate' => '2014-10-16'));

	if( $call->isOk() ){

		$parser = new LivePos_Job_ResponseParser();
		$aResponse = $call->getResponse();
		$receiptIds = $parser->GetReceiptIds( $aResponse['data'] );

		if( !empty($receiptIds)){

			$aReceiptsChunkedArray = array_chunk($receiptIds, LIVEPOS_MAX_RECORDS );
			processPosReceipts( $aReceiptsChunkedArray, $call, $locationId );
		}
	}
}


function processPosOrders( ){
	
	$processOrders = new LivePos_Thread_OrderServer();

	if( $processOrders->hasOrders() ){

		$processOrders->poolOrders();
		//processPosOrders();
	}
}


function processPosReceipts( $aReceiptsChunkedArray, $call, $iLocationId ){

	$aCurrentArray = array_shift( $aReceiptsChunkedArray);
	$processReceipts = new LivePos_Thread_ReceiptServer( $aCurrentArray, $call->getSessionId(), $iLocationId );
	$processReceipts->poolReceipts();

	if( !empty( $aReceiptsChunkedArray ) ){
		sleep(61);
		processPosReceipts( $aReceiptsChunkedArray, $call, $iLocationId );
	}
}