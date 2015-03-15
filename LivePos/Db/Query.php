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
	//protected static $GET_CURRENT_ORDERS = "SELECT SQL_NO_CACHE order_activa_id, customer_id FROM process_log WHERE status = 'complete' AND order_activa_id IN (%s)";

	protected static $GET_WEB_ORDERS = "SELECT SQL_NO_CACHE customer_activa_id, order_activa_id, pos_number, queue_id, order_json FROM fotobar_order_queue WHERE order_status = 'pending' AND pos_number > ''";
	
	protected static $INSERT_RECEIPT = "INSERT INTO livepos_receipts ( receipt_id, receipt_type, transaction_date, location_id, response_code, receipt_string, error_message ) VALUES (:receipt_id, :receipt_type, :transaction_date, :location_id, :response_code, :receipt_string, :error_message) ON DUPLICATE KEY UPDATE response_code = IF((@update_record := (response_code != 200)), :response_code, response_code), receipt_string = IF(@update_record, :receipt_string, receipt_string), receipt_type = IF(@update_record, :receipt_type, receipt_type), times_run = IF(@update_record, (times_run + 1), times_run)";
	
	protected static $INSERT_PRODUCT = "INSERT INTO livepos_products (product_id, product_sku, product_price, product_description) VALUES ( :product_id, :product_sku, :product_price, :product_description) ON DUPLICATE KEY UPDATE product_sku = :product_sku, product_price = :product_price, product_description = :product_description";
	
	protected static $SKU_TO_NSID = "SELECT SQL_CACHE sku, netsuite_id, fulfilled_by FROM skus WHERE sku IN (%s)";
	
	protected static $GET_ENTITY = "SELECT SQL_CACHE *, CONCAT_WS('\\n',location_attention,location_addressee, location_addr1,location_addr2,location_addr3,CONCAT_WS(' ',location_city, location_state, location_zip, location_country)) AS location_addresstxt FROM livepos_locations WHERE location_id = ?";
	
	protected static $QUEUE_ORDER = "INSERT INTO fotobar_order_queue ( customer_activa_id, order_activa_id, order_json ) VALUES ( :customer_activa_id, :order_activa_id, :order_json)";

	protected static $GET_ORDER_QUEUE = "SELECT SQL_NO_CACHE receipt_id, location_id, receipt_type, receipt_string FROM livepos_receipts WHERE response_code = 200 AND sent_to_netsuite = 'pending' ORDER BY location_id, receipt_id ASC LIMIT :limit";	
	
	protected static $VALIDATE_LOCATION = "SELECT SQL_CACHE location_id FROM livepos_locations WHERE location_id = :location_id";

	protected static $UPDATE_IGNORED_ORDER = "UPDATE livepos_receipts SET error_message = :error_message, sent_to_netsuite = :sent_to_netsuite WHERE receipt_id = :receipt_id";
	
	protected static $SET_ORDERS_COMPLETE = "UPDATE livepos_receipts SET sent_to_netsuite = 'complete' WHERE receipt_id IN (%s)";

	protected static $GET_PRODUCTS = "SELECT SQL_CACHE product_id as intProductID, product_sku as strProductSKU, product_price as dblProductDefaultPrice, product_description as strProductName FROM livepos_products WHERE product_sku IN (%s)";	

	protected static $GET_DISCOUNTS = "SELECT SQL_CACHE * FROM  livepos_discounts WHERE discount_code IN (%s)";
	
	protected static $GET_ALL_DISCOUNTS = "SELECT SQL_CACHE * FROM  livepos_discounts";
	
	protected static $SET_ORDERS_MERGED = "UPDATE fotobar_order_queue SET order_status = 'merged' WHERE queue_id IN (%s)";
	
	protected static $SET_DEBUG_ORDERS = "INSERT INTO livepos_debug_results ( receipt_id, invoice_id, pos_total, ns_total, discount_scope, discount_type, discount_amount, discount_total, webitems_total, ignored_reason ) VALUES( :receipt_id,:invoice_id,:pos_total,:ns_total,:discount_scope,:discount_type,:discount_amount,:discount_total,:webitems_total,:ignored_reason )  ON DUPLICATE KEY UPDATE invoice_id = :invoice_id, pos_total = :pos_total, ns_total = :ns_total, discount_scope = :discount_scope, discount_type = :discount_type, discount_amount = :discount_amount, discount_total = :discount_total, webitems_total = :webitems_total, ignored_reason = :ignored_reason";
	
	protected static $GET_DISCOUNTED_ITEMS = "SELECT SQL_CACHE sku FROM livepos_discount_items where discount_code = ?";
	
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