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
	
	protected static $GET_PROCESS_LOG_VIEW = "SELECT process_id, order_activa_id as activa_id,status, DATE_FORMAT(process_date, '%b %e %r') as process_date, customer_status, customer_warnings, customer_errors, order_status, order_warnings, order_errors FROM process_log ORDER BY process_id DESC LIMIT :limit";	
	protected static $GET_ORDER_INFO = "SELECT order_json, customer_json FROM process_log WHERE process_id = :process_id";
	protected static $GET_ORDER_QUEUE_VIEW = "SELECT order_activa_id, order_status, DATE_FORMAT(order_insert_date, '%b %e %r') as order_insert_date, DATE_FORMAT(order_working_date, '%b %e %r') as order_working_date, DATE_FORMAT(order_complete_date, '%b %e %r') as order_complete_date FROM fotobar_order_queue ORDER BY queue_id DESC LIMIT :limit";	
	protected static $GET_USER_LOG_VIEW = "SELECT DATE_FORMAT(insert_date, '%b %e %r') as insert_date, orders_run, netsuite_id FROM pool_queue_log ORDER BY id DESC LIMIT :limit";
	protected static $GET_QUEUE_STATS = "SELECT  DATE(order_working_date) AS start_date, AVG(TIME_TO_SEC(TIMEDIFF(order_complete_date ,order_working_date))) AS avg_process_time, AVG(TIME_TO_SEC(TIMEDIFF(order_working_date ,order_insert_date))) AS avg_queue_time, SUM(CASE WHEN order_status = 'duplicate' THEN 1 ELSE 0 END) AS duplicate_orders, SUM(CASE WHEN order_status = 'working' &&  times_run = 2 THEN 1 ELSE 0 END) AS orders_stalled, SUM(CASE WHEN order_status != 'working' &&  times_run = 2 THEN 1 ELSE 0 END) AS orders_reset FROM fotobar_order_queue GROUP BY start_date ORDER BY start_date DESC LIMIT :limit";
	protected static $GET_PROCESS_STATS = "SELECT  DATE(process_date) AS start_date, COUNT(*) AS daily_orders, SUM(CASE WHEN STATUS = 'error' THEN 1 ELSE 0 END) AS order_errors, SUM(CASE WHEN order_warnings IS NOT NULL THEN 1 ELSE 0 END) AS order_warnings, SUM(CASE WHEN customer_warnings IS NOT NULL THEN 1 ELSE 0 END) AS customer_warnings FROM process_log GROUP BY start_date ORDER BY start_date DESC LIMIT :limit";
	protected static $GET_USER_STATS = "SELECT DATE(insert_date) AS start_date, netsuite_id AS login_account, SUM(orders_run) AS total_orders_run, AVG(orders_run) AS avg_orders_per_run FROM pool_queue_log GROUP BY start_date, netsuite_id ORDER BY start_date DESC LIMIT :limit";
	protected static $GET_SEARCH_RESULTS = "SELECT process_id, order_activa_id as activa_id,status, DATE_FORMAT(process_date, '%b %e %r') as process_date, customer_status, customer_warnings, customer_errors, order_status, order_warnings, order_errors FROM process_log WHERE order_activa_id LIKE ?";
	
	protected static $GET_POS_CONVERSION_RESULTS = "SELECT * FROM livepos_debug_results";
	protected static $GET_POS_TEST_RESULTS = "SELECT livepos_test_orders.*, process_log.order_id FROM livepos_test_orders JOIN process_log ON livepos_test_orders.order_id = process_log.order_activa_id";
	
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