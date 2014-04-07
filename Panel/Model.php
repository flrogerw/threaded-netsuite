<?php
/**
 * DB Model class - Extends PDO
 *
 * @author gWilli
 * @version 1.0
 * @final Can NOT Extend
 * @copyright 2013
 * @see PDO
 */
final class Panel_Model extends PDO
{

	/**
	 * DataBase End Point
	 *
	 * @var string
	 * @access private
	 */
	private $_host = '127.0.0.1';

	/**
	 * DataBase Name
	 *
	 * @var string
	 * @access private
	 */
	private $_database = 'netsuite_queue';

	/**
	 * DataBase User Name
	 *
	 * @var string
	 * @access private
	 */
	private $_user = "netsuite";

	/**
	 * DataBase Password
	 *
	 * @var string
	 * @access private
	 */
	private $_pass  = "7x36mg!4m06Ar14u";



	/**
	 * Creates Parent DB Connection
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
			Netsuite_Db_Model::logError( $e );
		}
	}

	/**
	 *######  REMOVE    ONLY FOR TESTING     REMOVE   #######
	 * @param unknown $sXrefValue
	 */
	public function getAll( $sXrefType ) {
		try {
			$sth = $this->prepare('Select distinct(XrefValue) from fotobar_xref_dev where XrefType = ?');
			$sth->execute( array( $sXrefType ) );
			$this->_dbResults = $sth->fetchAll( PDO::FETCH_ASSOC );
			return( $this->_dbResults );
		}catch( Exception $e ){
			Netsuite_Db_Model::logError( $e );
			throw new Exception( 'Could NOT Get XrefVAlues Information From DB' );
		}
	}
	
	/**
	 *######  REMOVE    ONLY FOR TESTING     REMOVE   #######
	 * @param unknown $sXrefValue
	 */
	public function getActivaSources( ) {
		try {
			$sth = $this->prepare('Select activa_source from fotobar_sources');
			$sth->execute();
			$this->_dbResults = $sth->fetchAll( PDO::FETCH_ASSOC );
			return( $this->_dbResults );
		}catch( Exception $e ){
			Netsuite_Db_Model::logError( $e );
			throw new Exception( 'Could NOT Get Sources Information From DB' );
		}
	}
	
	/**
	 *######  REMOVE    ONLY FOR TESTING     REMOVE   #######
	 * @param unknown $sXrefValue
	 */
	public function getProducts( ) {
		try {
			$sth = $this->prepare('Select * from item_description_dev');
			$sth->execute();
			$this->_dbResults = $sth->fetchAll( PDO::FETCH_ASSOC );
			return( $this->_dbResults );
		}catch( Exception $e ){
			Netsuite_Db_Model::logError( $e );
			throw new Exception( 'Could NOT Get Products Information From DB' );
		}
	}
	
	########################################################################################
	
	
	
	
	public function getOrderInfo( $iProcessId ){
		try{
		
			$sth = $this->prepare( Panel_Query::getQuery( 'GET_ORDER_INFO' ) );
			$sth->bindValue(':process_id', (int)$iProcessId, PDO::PARAM_INT);
			if ( !$sth ) {
				throw new Exception( explode(',', $sth->errorInfo() ) );
			}
		
			$sth->execute();
			$this->_dbResults = $sth->fetchAll( PDO::FETCH_ASSOC );
			return( $this->_dbResults );
		
		}catch( Exception $e ){
			Netsuite_Db_Model::logError( $e );
			throw new Exception( 'Could NOT Get Order Info for the Control Panel' );
		}
		
	}
	
	
	/**
	 * Returns Orders From the Queue
	 *
	 *
	 *
	 */
	public function getProcessLogView( $iLimit = 20 ) {

		try{

			$sth = $this->prepare( Panel_Query::getQuery( 'GET_PROCESS_LOG_VIEW' ) );
			$sth->bindValue(':limit', (int)$iLimit, PDO::PARAM_INT);

			if ( !$sth ) {
				throw new Exception( explode(',', $sth->errorInfo() ) );
			}

			$sth->execute();
			$this->_dbResults = $sth->fetchAll( PDO::FETCH_ASSOC );
			return( $this->_dbResults );

		}catch( Exception $e ){
			Netsuite_Db_Model::logError( $e );
			throw new Exception( 'Could NOT Get Orders From the Queue DB for the Control Panel' );
		}
	}
}