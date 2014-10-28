<?php
/**
 * DB Query class - Populates Database Queries
 *
 * @author gWilli
 * @version 1.0
 * @final Can NOT Extend
 * @copyright 2013
 */
final class LivePos_Db_Query
{
	protected static $GET_CURRENT_ORDERS = "SELECT SQL_NO_CACHE order_activa_id, customer_id FROM process_log WHERE status = 'complete' AND order_activa_id IN (%s)";	

	protected static $LOG_ERROR = "INSERT INTO livepos_error_log (message, file, line, trace) VALUES (:message,:file,:line,:trace)";

	protected static $INSERT_RECEIPT = "INSERT INTO livepos_receipts ( receipt_id, receipt_type, transaction_date, location_id, response_code, receipt_string, error_message ) VALUES (:receipt_id, :receipt_type, :transaction_date, :location_id, :response_code, :receipt_string, :error_message) ON DUPLICATE KEY UPDATE response_code = :response_code, receipt_string = :receipt_string, error_message = :error_message, times_run = (times_run + 1) ";

	protected static $SKU_TO_NSID = "SELECT SQL_CACHE netsuite_id, fulfilled_by FROM skus WHERE sku = ?";

	protected static $GET_ENTITY = "SELECT SQL_CACHE *, CONCAT_WS('\\n',location_attention,location_addressee, location_addr1,location_addr2,location_addr3,CONCAT_WS(' ',location_city, location_state, location_zip, location_country)) AS location_addresstxt FROM livepos_locations WHERE location_id = ?";
	
	protected static $QUEUE_ORDER = "INSERT INTO fotobar_order_queue ( customer_activa_id, order_activa_id, order_json ) VALUES ( :customer_activa_id, :order_activa_id, :order_json)";

	protected static $GET_ORDER_QUEUE = "SELECT SQL_NO_CACHE receipt_id, location_id, receipt_type, receipt_string FROM livepos_receipts WHERE response_code = 200 AND sent_to_netsuite = 'pending' ORDER BY location_id, receipt_id LIMIT :limit";	
	
	protected static $VALIDATE_LOCATION = "SELECT SQL_CACHE location_id FROM livepos_locations WHERE location_id = :location_id";

	protected static $UPDATE_IGNORED_ORDER = "UPDATE livepos_receipts SET error_message = :error_message, sent_to_netsuite = :sent_to_netsuite WHERE receipt_id = :receipt_id";
	
	protected static $SET_ORDERS_COMPLETE = "UPDATE livepos_receipts SET sent_to_netsuite = 'complete' WHERE receipt_id IN (%s)";
		
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