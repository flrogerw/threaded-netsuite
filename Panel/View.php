<?php
/**
 *
 * @author gWilli
 *
 */
class Panel_View {

	public function __construct(){
		include_once( APPLICATION_DIR . 'Panel/views/menu.phtml' );
	}
	
	public function show( $sMethod ){
		ob_start();
		include_once( APPLICATION_DIR . 'Panel/views/' . substr($sMethod, 0, -6) . '.phtml' );
		echo( ob_get_clean() );
	
	}
}