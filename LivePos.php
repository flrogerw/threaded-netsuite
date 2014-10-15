#!/usr/bin/php
<?php
require_once( __DIR__ . DIRECTORY_SEPARATOR . 'Configure.php' );

try{
	// See if Process is Already Running And Netsuite is Alive
	$pid = new Netsuite_Pid( '/tmp', basename( __FILE__ ) );


	switch( true){

		case( $pid->already_running ):
			throw new Exception( 'LivePOS Process Already Running' );
			break;

		default:
			//processPosOrders();
			break;
	}

}catch( Exception $e ){

	if( DEBUG ){
		echo( $e->getMessage() . "\n" );
	}

	Netsuite_Db_Model::logError( $e );
}