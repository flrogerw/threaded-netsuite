#!/usr/bin/php
<?php 
require_once( __DIR__ . DIRECTORY_SEPARATOR . 'Configure.php' );

$locationId = 27449;


try{
	// See if Process is Already Running And Netsuite is Alive
	$pid = new Netsuite_Pid( '/tmp', basename( __FILE__ ) );


	switch( true){

		case( $pid->already_running ):
			throw new Exception( 'LivePOS Process Already Running' );
			break;

		default:

			$model = new LivePos_Db_Model();
			$locationData = $model->getEntity( $locationId );
			getReceipts($locationData);
			break;
	}

}catch( Exception $e ){

	if( DEBUG ){
		echo( $e->getMessage() . "\n" );
	}

	Netsuite_Db_Model::logError( $e );
}

function getReceipts( $locationData ){

	$call = new LivePos_Job_GetRecord();
	$call->sendRequest('GetReceipts', $call->getSessionId(), array('intLocationID' => $locationData['location_id'], 'dReportDate' => '2014-10-16'));

	if( $call->isOk() ){

		$parser = new LivePos_Job_ResponseParser();
		$aResponse = $call->getResponse();
		$receiptIds = $parser->GetReceiptIds( $aResponse['data'] );

		if( !empty($receiptIds)){

			$aOrdersChunkedArray = array_chunk($receiptIds, LIVEPOS_MAX_RECORDS );
			processPosOrders( $aOrdersChunkedArray, $call, $locationData );
		}
	}
}

function processPosOrders( $aOrdersChunkedArray, $call, $locationData ){

	$aCurrentArray = array_shift( $aOrdersChunkedArray);
	$processOrder = new LivePos_Thread_Server( $aCurrentArray, $call->getSessionId(), $locationData );
	$processOrder->poolOrders();

	if( !empty( $aOrdersChunkedArray ) ){
		sleep(61);
		processPosOrders( $aOrdersChunkedArray, $call, $locationData );
	}
}