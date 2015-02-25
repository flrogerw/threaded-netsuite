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
 * @subpackage Inventory
 * @author gWilli
 * @version 1.0
 * @copyright 2014
 * @uses PDO
 * @uses Netsuite Db Db
 * @name Inventory Db Model
 */
final class Inventory_Db_Model extends PDO
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
	
	public function getLivePosCategories(){
		
		try{
		
			$sth = $this->prepare( Inventory_Db_Query::getQuery( 'GET_LIVEPOS_CATEGORIES' ) );
		
			if ( !$sth ) {
				throw new Exception( explode(',', $sth->errorInfo() ) );
			}
		
			$sth->execute();
			$dbResults = $sth->fetchAll( PDO::FETCH_ASSOC );
			$aFlattenedResults =  iterator_to_array( new RecursiveIteratorIterator( new RecursiveArrayIterator( $dbResults ) ), false);
			return( $aFlattenedResults );
		
		}catch( Exception $e ){
			self::logError( $e );
			throw new Exception( 'Could NOT Get LivePOS Categories From the DB' );
		}
	}
	
	public function getLivePosLocations() {
	
		try{
	
			$sth = $this->prepare( Inventory_Db_Query::getQuery( 'GET_LIVEPOS_LOCATIONS' ) );
	
			if ( !$sth ) {
				throw new Exception( explode(',', $sth->errorInfo() ) );
			}
	
			$sth->execute();
			$this->_dbResults = $sth->fetchAll( PDO::FETCH_ASSOC );
			return( $this->_dbResults );
	
		}catch( Exception $e ){
			self::logError( $e );
			throw new Exception( 'Could NOT Get LivePOS Locations From the DB' );
		}
	}
	
	
	/**
	 * Enters Store Inventory Into Database
	 *
	 * @param array $aReceiptData
	 * @access public
	 * @return void
	 */
	public function insertInventory( array $aInventory )
	{
		try{
	
			$sth = $this->prepare( Inventory_Db_Query::getQuery( 'INSERT_INVENTORY' ) );
	
			if ( !$sth ) {
				throw new Exception( explode(',', $sth->errorInfo() ) );
			}
	
				$sth->execute( $aInventory );		
	
		}catch( Exception $e ){
			self::logError( $e );
			throw new Exception( 'Could NOT Enter Inventory Data into Database' );
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