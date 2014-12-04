<?php
/**
 * LivePOS Map Factory
 *
 * @package Netsuite
 * @subpackage LivePOS
 * @author gWilli
 * @version 1.0
 * @copyright 2014
 * @name LivePOS MapFactory
 */
/**
 * LivePOS Mapping Factory Class
 *
 * Factory class for instantiating LivePos_Map Objects
 *
 * @uses Configure
 * @package Netsuite
 * @subpackage LivePOS
 * @final Can NOT Extend
 */
final class LivePos_Maps_MapFactory {

	public static function create( $sType, $aData, array $locationData = null, $sOrderId = null ) {
		$sClassName = 'LivePos_Maps_' . ucfirst(strtolower( $sType ) );
		return new $sClassName( $aData, $locationData, $sOrderId );
	}
}