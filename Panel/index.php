<?php
require_once( '../Configure.php' );


	$aUrl = parse_url( $_SERVER['REQUEST_URI']);
	$sAction = strtolower( basename( $aUrl['path'] ) ) . 'Action';
	if(isset($aUrl['query'])){
	parse_str($aUrl['query'], $options);
	}else{
		$options =  $_REQUEST;
	}
	$oController = new Panel_Controller( $options );
	
	if( method_exists( $oController, $sAction ) ){
		$oController->$sAction();
	} else {
		echo( 'The Action ' . basename( $aUrl['path'] ) . ' Does NOT Exist' );
	}



	?>
