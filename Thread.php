#!/usr/bin/php
<?php
require_once( __DIR__ . DIRECTORY_SEPARATOR . 'Configure.php' );

try{
	// See if Process is Already Running And Netsuite is Alive
	$pid = new Netsuite_Pid( '/tmp', basename( __FILE__ ) );


	switch( true){

		case( $pid->already_running ):
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

return(10); // MYSQL_UDF Trigger Expects 10 as a Success Return
exit();

function processOrders( $bResetOrders = false ){

	try{
		$processOrder = new Thread_Server();

		switch( true ){

			case( $processOrder->hasOrders() === true ):
				Netsuite_Db_Model::setPoolQueueLog( sizeof( $processOrder->orders ) );
				$processOrder->poolOrders();
				processOrders( true );
				break;
					
			case( $bResetOrders === true ):
				//sleep(5);
				//Netsuite_Db_Model::resetStalledOrders();
				//processOrders( false );
				break;
		}

	}catch( Exception $e ){
		Netsuite_Db_Model::logError( $e );
	}
}
