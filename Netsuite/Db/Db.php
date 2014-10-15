<?php
/**
 * Db
 *
 * @package Netsuite
 * @subpackage Database
 * @author gWilli
 * @version 1.0
 * @copyright 2012
 * @name Db
 */
/**
 * Netsuite Database Handle
 *
 * Creates Netsuite Singleton DataBase Object
 *
 * @uses Configure
 * @uses PDO
 * @package Netsuite
 * @subpackage Database
 * @final Can NOT Extend
 */
final class Netsuite_Db_Db extends PDO
{

	/**
	 * Singleton instance
	 * @access protected
	 * @staticvar PresswiseDB
	 */
	protected static $_instance = null;


	/**
	 * Singleton pattern implementation makes "clone" unavailable
	 * @access protected
	 * @return void
	 */
	protected function __clone()
	{
	}

	/**
	 * Singleton pattern implementation makes "new" unavailable
	 * @access protected
	 * @return void
	 */
	public function __construct()
	{
		try{
			$dsn = 'mysql:host=' . SYSTEM_DB_HOST . ';dbname=' . SYSTEM_DB_DATABASE;
			parent::__construct( $dsn, SYSTEM_DB_USER, SYSTEM_DB_PASS );
			$this->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

		}catch( Exception $e ) {
			echo( $e->getMessage() );
		}
	}

	/**
	 * Returns an instance of Netsuite_Db_Db
	 * @static
	 * @access public
	 * @return Netsuite_Db_Db Provides a fluent interface
	 */
	public static function getInstance()
	{
		if ( null === self::$_instance ) {
			self::$_instance = new self();
		}

		return self::$_instance;
	}
}