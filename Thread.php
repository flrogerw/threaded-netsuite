#!/usr/bin/php
<?php
require_once( __DIR__ . DIRECTORY_SEPARATOR . 'Configure.php' );


try{
	// See if Process is Already Running And Netsuite is Alive
	$pid = new Netsuite_Pid( '/tmp', basename( __FILE__ ) );

	switch( true){

		case( $pid->already_running ):
			throw new Exception( 'Netsuite Process Already Running' );
			break;

		case( !Netsuite_Job_SetRecord::isAlive() ):
			throw new Exception( 'Netsuite isAlive NOT Responding' );
			break;

		default:
			processOrders();
			break;
	}

}catch( Exception $e ){
	
	if( DEBUG ){
		echo( $e->getMessage() . "\n" );
	}
	
	Netsuite_Db_Model::logError( $e );
}

// Return 10 because that is what the MYSQL_UDF Trigger Expects as a Success Return
return(10);
exit();

function processOrders(){

	try{
		$processOrder = new Thread_Server();

		if( $processOrder->hasOrders() ){

			$processOrder->poolOrders();
			processOrders();
		} else {
			return;
		}
			
	}catch( Exception $e ){
		Netsuite_Db_Model::logError( $e );
	}

}