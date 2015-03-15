<?php
/**
 * DB Query class - Populates Database Queries
 *
 * @author gWilli
 * @version 1.0
 * @final Can NOT Extend
 * @copyright 2013
 */
final class Utils_Query
{
	
	protected static $GET_EMAIL_NOTIFICATION = "SELECT SQL_NO_CACHE notification_address FROM email_notification WHERE notification_level IN (%s)";

	
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