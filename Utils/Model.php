<?php
/**
 * DB Model class
 *
 * @author gWilli
 * @version 1.0
 * @final Can NOT Extend
 * @copyright 2014
 * @see PDO
 */
/**
 * LivePOS Database Model
 *
 * @package Netsuite
 * @subpackage LivePOS
 * @author gWilli
 * @version 1.0
 * @copyright 2014
 * @uses PDO
 * @uses Netsuite Db Db
 * @name LivePos Db Model
 */
final class Utils_Model extends PDO
{

	/**
	 * Standard Object Constructor
	 *
	 * @access public
	 * @return void
	 */
	public function __construct() {
		try{
			$dsn = 'mysql:host=' . SYSTEM_DB_HOST . ';dbname=' . SYSTEM_DB_DATABASE;
			parent::__construct( $dsn, SYSTEM_DB_USER, SYSTEM_DB_PASS );
			$this->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

		}catch( Exception $e ) {
			echo( $e->getMessage() );
		}
	}

	public function getEmailNotifications( array $aNotificationLevel ){

		try{

			$sth = $this->prepare( Utils_Query::getQuery( 'GET_EMAIL_NOTIFICATION', null, count( $aNotificationLevel ) ) );

			if ( !$sth ) {
				throw new Exception( explode(',', $sth->errorInfo() ) );
			}

			$aBindArgs = array();

			array_walk( $aNotificationLevel, function( $sLevel, $iKey ) use( &$aBindArgs){
				$aBindArgs[':arg' . $iKey] = $sLevel;
			});
					
				$sth->execute( $aBindArgs  );
				$aResults = $sth->fetchAll( PDO::FETCH_ASSOC );
				$aFlattenedResults =  iterator_to_array( new RecursiveIteratorIterator( new RecursiveArrayIterator( $aResults ) ), false);

				return( $aFlattenedResults );

		} catch( Exception $e ){
			self::logError( $e );
			throw new Exception( 'Could NOT Get NetSuite Id for Skus From DB' );
		}
	}

	/**
	 * Logs System Exceptions to DataBase
	 *
	 * @param object $exception
	 * @access public
	 * @return void
	 */
	public static function logError( $exception )
	{

		try{

			$connection = Netsuite_Db_Db::getInstance();
			$sth = $connection->prepare( Netsuite_Db_Query::getQuery('LOG_ERROR') );

			if ( !$sth ) {
				throw new Exception( explode(',', $sth->errorInfo() ) );
			}

			$sth->execute(array(
					':message'=>$exception->getMessage(),
					':file'=>$exception->getFile(),
					':line'=>$exception->getLine(),
					':trace'=>$exception->getTraceAsString()));

		}catch( Exception $e){
			var_dump($e);
		}
	}

}