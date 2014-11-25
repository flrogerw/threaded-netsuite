<?php
/**
 * DB Query class - Creates User Singleton DataBase Object
 *
 * @author gWilli
 * @version 1.0
 * @final Can NOT Extend
 * @copyright 2013
 */
final class Netsuite_Db_Query
{
	protected static $IS_ORDER_PROCESSED = "SELECT order_activa_id FROM process_log WHERE status IN ('complete','pending') AND order_activa_id IN (%s)";

	protected static $POOL_QUEUE_LOG = "INSERT INTO pool_queue_log ( orders_run, netsuite_id ) VALUES (:orders_run, :netsuite_id)";

	protected static $GET_CUSTOMER = "SELECT SQL_CACHE InternalID FROM customers_xref_dev WHERE Company = '[TABLE_PREFIX]' AND XrefValue = ?";

	protected static $GET_ACTIVA_CUSTOMER = "SELECT netsuite_id FROM users WHERE id = ?";

	protected static $GET_IMAGE_SKU = "SELECT SQL_CACHE InternalID FROM inhouseprintedimage WHERE Name = ?";

	protected static $GET_SOURCES = "SELECT SQL_CACHE * FROM [TABLE_PREFIX]_sources WHERE activa_source = ?";

	protected static $GET_SHIPPING_METHODS = "SELECT SQL_CACHE netsuite_id FROM [TABLE_PREFIX]_ship_methods WHERE location LIKE ? AND activa_code = ? OR location IS NULL AND activa_code = ? ORDER BY location DESC LIMIT 1";

	//protected static $CALL_XREF = "SELECT SQL_CACHE InternalID FROM [TABLE_PREFIX]_xref WHERE Company = ? AND ItemType = ? AND XrefValue = ?";
	// REMOVE FOR LIVE
	protected static $CALL_XREF = "SELECT SQL_CACHE InternalID FROM [TABLE_PREFIX]_xref_dev WHERE Company = ? AND XrefType = ? AND XrefValue = ?";

	protected static $GET_ITEM = "SELECT SQL_CACHE InternalID FROM [TABLE_PREFIX]_xref_dev WHERE Company = ? AND XrefType = ? AND XrefValue = ? AND Location = ?";

	//protected static $GET_EXCEPTION_ITEMS = "SELECT SQL_CACHE * FROM [TABLE_PREFIX]_sku_exceptions";

	//protected static $GET_ORDER_QUEUE = "SELECT SQL_NO_CACHE customer_activa_id, order_activa_id, queue_id, order_json FROM fotobar_order_queue WHERE order_status = 'pending' GROUP BY customer_activa_id ORDER BY queue_id LIMIT :limit";

	protected static $GET_ORDER_QUEUE = "SELECT SQL_NO_CACHE customer_activa_id, order_activa_id, queue_id, order_json FROM fotobar_order_queue WHERE order_status = 'pending' AND NULLIF(pos_number,'') IS NULL GROUP BY customer_activa_id ORDER BY queue_id LIMIT :limit";

	protected static $QUEUE_ORDER = "INSERT INTO fotobar_order_queue ( order_json ) VALUES (:order_json)";

	protected static $UPDATE_ORDER_QUEUE = "UPDATE fotobar_order_queue SET order_status = :order_status, order_complete_date = :order_complete_date WHERE queue_id = :queue_id";

	protected static $PROCESS_LOG = "INSERT INTO process_log ( status, order_activa_id, system_error, process_date, customer_status, customer_id, customer_warnings, customer_errors, customer_json, order_status, order_id, order_warnings, order_errors, order_json ) VALUES (:status, :order_activa_id, :system_error, :process_date, :customer_status, :customer_id, :customer_warnings, :customer_errors, :customer_json, :order_status, :order_id, :order_warnings, :order_errors, :order_json) ON DUPLICATE KEY UPDATE status = :status, process_date=:process_date, customer_status=:customer_status, customer_id=:customer_id, customer_warnings=:customer_warnings, customer_errors=:customer_errors, customer_json=:customer_json, order_status=:order_status, order_id=:order_id, order_warnings=:order_warnings, order_errors=:order_errors, order_json=:order_json, system_error=:system_error";

	//protected static $PROCESS_LOG = "INSERT INTO process_log ( status, order_activa_id, system_error, process_date, customer_status, customer_id, customer_warnings, customer_errors, customer_json, order_status, order_id, order_warnings, order_errors, order_json ) VALUES (:status, :order_activa_id, :system_error, :process_date, :customer_status, :customer_id, :customer_warnings, :customer_errors, :customer_json, :order_status, :order_id, :order_warnings, :order_errors, :order_json)";

	protected static $INSERT_CUSTOMER = "INSERT INTO customers_xref_dev (XrefValue, InternalID) VALUES (:xrefvalue,:internalid)";

	protected static $UPDATE_ACTIVA_CUSTOMER = "UPDATE users SET netsuite_id = :netsuite_id WHERE id = :id";

	protected static $GET_ADDRESS = "SELECT SQL_CACHE netsuite_id FROM address_book WHERE activa_id = ? AND address_hash = ?";

	protected static $SET_ADDRESS = "INSERT INTO address_book ( netsuite_id, activa_id, address_hash ) VALUES (:netsuite_id, :activa_id, :address_hash) ON DUPLICATE KEY UPDATE address_hash = address_hash";

	protected static $GET_ACTIVA_ADDRESSES = "SELECT SQL_CACHE address_hash FROM address_book WHERE activa_id = ?";

	protected static $SET_ORDER_WORKING = "UPDATE fotobar_order_queue SET order_status = 'working', order_working_date = :order_working_date WHERE queue_id IN (%s)";

	protected static $SET_ORDER_DUPLICATE = "UPDATE fotobar_order_queue SET order_status = 'duplicate', order_complete_date = :order_complete_date WHERE queue_id IN (%s)";

	protected static $SET_ACTIVA_ORDER_WORKING = "UPDATE orders SET netsuite_status = 'working' WHERE id IN (%s)";

	protected static $GET_STORE_ADDRESS = "SELECT SQL_CACHE * FROM fotobar_store_locations WHERE store_netsuite_id = ?";

	protected static $GET_TAX_CODE = "SELECT SQL_CACHE taxcode FROM [TABLE_PREFIX]_sources WHERE location = ? LIMIT 1";

	protected static $UPDATE_ACTIVA_STATUS = "UPDATE orders SET netsuite_status = :netsuite_status, netsuite_id = :netsuite_id WHERE id = :order_activa_id";

	protected static $LOG_ERROR = "INSERT INTO error_log (message, file, line, trace) VALUES (:message,:file,:line,:trace)";

	protected static $GET_EXCEPTION_ITEMS = "SELECT SQL_CACHE netsuite_id FROM item_exceptions WHERE exception_type = ?";

	protected static $RESET_STALLED_ORDERS = "UPDATE fotobar_order_queue SET times_run = (@cur_value := times_run) + 1, order_status = 'pending' WHERE ( order_status = 'working' OR order_status = 'error' ) AND times_run < 2 AND order_working_date > DATE_SUB(NOW() , INTERVAL 12 HOUR)";

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