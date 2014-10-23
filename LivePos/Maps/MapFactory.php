<?php

class LivePos_Maps_MapFactory {



	public static function create( $sType, $aData, array $locationData = null ) {
		$sClassName = 'LivePos_Maps_' . ucfirst(strtolower( $sType ) );
		return new $sClassName( $aData, $locationData );
	}
}