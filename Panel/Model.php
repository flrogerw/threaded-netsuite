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

public function getUserStats(){
	try{
	
		$sth = $this->prepare( Panel_Query::getQuery( 'GET_USER_STATS' ) );
		$sth->bindValue(':limit', (int) PANEL_SUMMARY_RESULTS, PDO::PARAM_INT);
		
		if ( !$sth ) {
			throw new Exception( explode(',', $sth->errorInfo() ) );
		}
	
		$sth->execute();
		$this->_dbResults = $sth->fetchAll( PDO::FETCH_ASSOC );
		return( $this->_dbResults );
	
	}catch( Exception $e ){
		Netsuite_Db_Model::logError( $e );
		throw new Exception( 'Could NOT Get User Log Stats From the Queue DB for the Control Panel' );
	}
}
	
	public function getUserLogView(){
		 
		try{
		
			$sth = $this->prepare( Panel_Query::getQuery( 'GET_USER_LOG_VIEW' ) );
			$sth->bindValue(':limit', (int) PANEL_MAX_RESULTS, PDO::PARAM_INT);
		
			if ( !$sth ) {
				throw new Exception( explode(',', $sth->errorInfo() ) );
			}
		
			$sth->execute();
			$this->_dbResults = $sth->fetchAll( PDO::FETCH_ASSOC );
			return( $this->_dbResults );
		
		}catch( Exception $e ){
			Netsuite_Db_Model::logError( $e );
			throw new Exception( 'Could NOT Get User Log From the Queue DB for the Control Panel' );
		}
	}
	
	
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
	 * Returns Stats From the Queue
	 *
	 *
	 *
	 */
	public function getQueueStats() {
	
		try{
	
			$sth = $this->prepare( Panel_Query::getQuery( 'GET_QUEUE_STATS' ) );
			$sth->bindValue(':limit', (int) PANEL_SUMMARY_RESULTS, PDO::PARAM_INT);
	
			if ( !$sth ) {
				throw new Exception( explode(',', $sth->errorInfo() ) );
			}
	
			$sth->execute();
			$this->_dbResults = $sth->fetchAll( PDO::FETCH_ASSOC );
			return( $this->_dbResults );
	
		}catch( Exception $e ){
			Netsuite_Db_Model::logError( $e );
			throw new Exception( 'Could NOT Get Queue Stats From the Queue DB for the Control Panel' );
		}
	}
	
	/**
	 * Returns Stats From the Queue
	 *
	 *
	 *
	 */
	public function getProcessStats() {
	
		try{
	
			$sth = $this->prepare( Panel_Query::getQuery( 'GET_PROCESS_STATS' ) );
			$sth->bindValue(':limit', (int) PANEL_SUMMARY_RESULTS, PDO::PARAM_INT);
	
			if ( !$sth ) {
				throw new Exception( explode(',', $sth->errorInfo() ) );
			}
	
			$sth->execute();
			$this->_dbResults = $sth->fetchAll( PDO::FETCH_ASSOC );
			return( $this->_dbResults );
	
		}catch( Exception $e ){
			Netsuite_Db_Model::logError( $e );
			throw new Exception( 'Could NOT Get Process Stats From the Queue DB for the Control Panel' );
		}
	}
	
	
	
	/**
	 * Returns Orders From the Queue
	 *
	 *
	 *
	 */
	public function getOrderQueueView() {
	
		try{
	
			$sth = $this->prepare( Panel_Query::getQuery( 'GET_ORDER_QUEUE_VIEW' ) );
			$sth->bindValue(':limit', (int) PANEL_MAX_RESULTS, PDO::PARAM_INT);
	
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
	
	
	
	/**
	 * Returns Orders From the Queue
	 *
	 *
	 *
	 */
	public function getProcessLogView() {

		try{

			$sth = $this->prepare( Panel_Query::getQuery( 'GET_PROCESS_LOG_VIEW' ) );
			$sth->bindValue(':limit', (int) PANEL_MAX_RESULTS, PDO::PARAM_INT);

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