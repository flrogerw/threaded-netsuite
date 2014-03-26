<?php
###########################################
/**
 * Constants Used Throughout the Application
 * - Netsuite Credentials
 * - Netsuite End Points
 * - Database Credentials
 *
 * @package Netsuite
 * @subpackage Utilities
 * @author gWilli
 * @version 1.0
 * @name Constants
 * @copyright 2013
 */
$constants = array(

		// System Settings
		'DEBUG' => true,
		'APPLICATION_DIR' => '/var/www/html/Threaded/',
		'NETSUITE_COMPANY' =>'fotobar',
		'SECRET_KEY' => 'P0l@r0!dFoT0',
		'MAX_THREADS' => 40, // Limit is 50
		'MAX_ORDER_RECORDS' => 35,
		
		// System Database Credentials
		'SYSTEM_DB_HOST' => '127.0.0.1',
		'SYSTEM_DB_USER' => 'root',
		'SYSTEM_DB_PASS' => '7x36mg!4m06Ar14u',
		'SYSTEM_DB_DATABASE' => 'netsuite_queue',
		
		// Activa Database Credentials
		'ACTIVA_DB_HOST' => '204.232.131.121',
		'ACTIVA_DB_USER' => 'netsuite',
		'ACTIVA_DB_PASS' => 'FGcjapsLatUCM8wh',
		'ACTIVA_DB_DATABASE' => 'fotobar',
		
		/*
		// AWS Activa Database Credentials TESTING ONLY
		'ACTIVA_DB_HOST' => 'fotobar.c8nypmct6r9k.us-east-1.rds.amazonaws.com',
		'ACTIVA_DB_USER' => 'fotobar',
		'ACTIVA_DB_PASS' => 'd7sWxtrd3xTyxGa6',
		'ACTIVA_DB_DATABASE' => 'fotobar',
		*/
		// NetSuite Restlet Credentials DEV
		//'NETSUITE_AUTH_ACCOUNT' => '3664828',
		//'NETSUITE_AUTH_EMAIL' => 'rogerw@polaroidfotobar.com',
		//'NETSUITE_AUTH_SIGNATURE' => 'Awards1609',
		
		// NetSuite Restlet Credentials LIVE
		'NETSUITE_AUTH_ACCOUNT' => '3664828',
		'NETSUITE_AUTH_EMAIL' => 'it2@polaroidfotobar.com',
		'NETSUITE_AUTH_SIGNATURE' => 'FotoNS99!!',
				
		// NetSuite End Points
		'NETSUITE_POST_ORDER' => 'https://rest.na1.netsuite.com/app/site/hosting/restlet.nl?script=11&deploy=1', //<---[ LIVE ]---<<<*/
		'NETSUITE_ISALIVE' => 'https://rest.na1.netsuite.com/app/site/hosting/restlet.nl?script=20&deploy=1' // <-- LIVE
		//'NETSUITE_POST_ORDER' => 'https://rest.sandbox.netsuite.com/app/site/hosting/restlet.nl?script=11&deploy=1',
		//'NETSUITE_GET_ADDRESSBOOK' => 'https://rest.sandbox.netsuite.com/app/site/hosting/restlet.nl?script=21&deploy=1',
		//'NETSUITE_ISALIVE' => 'https://rest.sandbox.netsuite.com/app/site/hosting/restlet.nl?script=19&deploy=1',
		
);

foreach($constants as $key=>$value)
{
	defined($key) || define($key, $value);

}

set_include_path(get_include_path() . PATH_SEPARATOR . APPLICATION_DIR);
date_default_timezone_set('America/New_York');
error_reporting( E_ALL & ~E_STRICT & ~E_NOTICE );
ini_set('display_errors', DEBUG );
set_time_limit (0);

spl_autoload_register(function ($sClass) {
	$sClass = str_replace( "_", "/", $sClass );
	include APPLICATION_DIR . $sClass . '.php';
});
