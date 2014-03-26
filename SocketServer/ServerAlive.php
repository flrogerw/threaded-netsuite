<?php 

/**
 Simple Script to PING the Netsuite Socket Server for Exsistance
 */

date_default_timezone_set('America/New_York');

define('APPLICATION_DIR', '/var/www/html/');
spl_autoload_register(function ($sClass) {
	$sClass = str_replace( "_", "/", $sClass );
	include APPLICATION_DIR . $sClass . '.php';
});

$mIsAlive = new SocketServer_Client( true );

if(  $mIsAlive instanceof SocketServer_Client ){
	$mIsAlive->serverAlive();
	echo($mIsAlive->serverAlive() );
	return;
}
echo( 0 );
?>