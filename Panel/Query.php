<?php
/**
 * DB Query class - Creates User Singleton DataBase Object
 *
 * @author gWilli
 * @version 1.0
 * @final Can NOT Extend
 * @copyright 2013
 */
final class Panel_Query
{
	
	protected static $GET_PROCESS_LOG_VIEW = "SELECT process_id, status, process_date, customer_status, customer_warnings, customer_errors, order_status, order_warnings, order_errors FROM process_log ORDER BY process_id DESC LIMIT :limit";	
	protected static $GET_ORDER_INFO = "SELECT order_json, customer_json FROM process_log WHERE process_id = :process_id";
/**
 * 
 * @param string $TablePrefix
 * @param string $sQuery
 * @return string
 */
public static function getQuery( $sQuery, $TablePrefix = null ) {
	
	if( $TablePrefix != null ){
		$sReturnQuery = str_replace( '[TABLE_PREFIX]', strtolower( $TablePrefix ), self::$$sQuery );
	}else{
		$sReturnQuery = self::$$sQuery;
	}
	return( $sReturnQuery );
}

}