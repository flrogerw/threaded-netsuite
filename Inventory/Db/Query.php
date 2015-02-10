<?php
/**
 * DB Query class - Populates Database Queries
 *
 * @author gWilli
 * @version 1.0
 * @final Can NOT Extend
 * @copyright 2013
 */
final class Inventory_Db_Query
{
	
	protected static $INSERT_INVENTORY = "INSERT INTO inventory ( store_name, product_id, ns_count, pos_count ) VALUES ( :store_name, :product_id, :ns_count, :pos_count)";
	
	protected static $GET_LIVEPOS_LOCATIONS = "SELECT SQL_NO_CACHE location_id, location_netsuite_id, location_name FROM livepos_locations WHERE location_pos = 'livepos'";
	
	/**
	 *
	 * @param string $TablePrefix
	 * @param string $sQuery
	 * @return string
	 */
	public static function getQuery( $sQuery, $TablePrefix = null, $iInStatementCount = null ) {

		$sReturnQuery = self::$$sQuery;

		if( $iInStatementCount != null ){
			for( $i=0; $i<$iInStatementCount; $i++){
				$aInStatement[] = ':arg' . $i;
			}

			$sReturnQuery = sprintf( $sReturnQuery, implode( ',', $aInStatement ));
		}

		if( $TablePrefix != null ){
			$sReturnQuery = str_replace( '[TABLE_PREFIX]', strtolower( $TablePrefix ), $sReturnQuery );
		}

		return( $sReturnQuery );
	}

}