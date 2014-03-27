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
final class Netsuite_Db_Activa extends PDO
{

	/**
	 * Creates Parent DB Connection
	 *
	 * @access public
	 * @return void
	 */
	public function __construct() {
		try{
			$dsn = 'mysql:host=' . ACTIVA_DB_HOST . ';dbname=' . ACTIVA_DB_DATABASE;
			parent::__construct( $dsn, ACTIVA_DB_USER, ACTIVA_DB_PASS );
			$this->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

		}catch( Exception $e ) {
			var_dump("HERE");
			//Netsuite_Db_Model::logError( $e );
		}
	}


	/**
	 * Returns Customer InternalId based on Activa Id
	 *
	 * @param string $sCusterId - Activa Customer Id
	 */
	public function getCustomer( $sCustomerId ) {
	
		try{
	
			$sth = $this->prepare( Netsuite_Db_Query::getQuery( 'GET_ACTIVA_CUSTOMER', NETSUITE_COMPANY ) );
	
			if ( !$sth ) {
				throw new Exception( explode(',', $sth->errorInfo() ) );
			}
	
			$sth->execute( array(  preg_replace("/[^0-9]/","", $sCustomerId ) ) );
			$this->_dbResults = $sth->fetchColumn();
			return( $this->_dbResults );
	
		}catch( Exception $e ){
			Netsuite_Db_Model::logError( $e );
			throw new Exception( 'Could NOT Get Orders From the Queue DB' );
		}
	}
	
	
	
	/**
	 * Enters New Customer Into Database
	 *
	 * @param object $exception
	 * @access public
	 * @return void
	 */
	public function updateCustomer( $sActivaId, $iInternalId )
	{
		try{
	
			$sth = $this->prepare( Netsuite_Db_Query::getQuery( 'UPDATE_ACTIVA_CUSTOMER' ) );

			if ( !$sth ) {
				throw new Exception( explode(',', $sth->errorInfo() ) );
			}
	
			
			$sth->execute( array( ':id' => (int) preg_replace("/[^0-9]/","", $sActivaId ),
					':netsuite_id' => $iInternalId) );
	
		}catch( Exception $e ){
			Netsuite_Db_Model::logError( $e );
			throw new Exception( 'Could NOT Enter New Customer Into DB' );
		}
	}
	
	
	
	/**
	 * Update Orders From the Queue
	 *
	 *
	 *
	 */
	public function logProcess( array $aUpdateData ) {
	
		try{
	
			$sth = $this->prepare( Netsuite_Db_Query::getQuery( 'UPDATE_ACTIVA_STATUS' ) );
	
			if ( !$sth ) {
				throw new Exception( explode(',', $sth->errorInfo() ) );
			}
	
			$sth->execute( array( ':netsuite_status' => $aUpdateData[':status'],
					':netsuite_id' => $aUpdateData[':order_id'],
					':order_activa_id' => (int) preg_replace("/[^0-9]/","", $aUpdateData[':order_activa_id'] )));
			
			return( true );
	
		}catch( Exception $e ){
			Netsuite_Db_Model::logError( $e );
			throw new Exception( 'Could NOT Update Orders in the Activa DB' );
		}
	}
	
	/**
	 * Set Current Batches Orders to a Status of Working
	 *
	 * @param array $aOrders - Array of Batched Orders
	 * @access public
	 * @return int|null $_dbResults
	 * @throws Exception
	 */
	public function setOrderWorking( $aOrders ){
	
		try{
	
			$sth = $this->prepare( Netsuite_Db_Query::getQuery( 'SET_ACTIVA_ORDER_WORKING', null, count( $aOrders ) ) );
	
			if ( !$sth ) {
				throw new Exception( explode(',', $sth->errorInfo() ) );
			}
	
			$aBindArgs = array();
	
			array_walk( $aOrders, function( $aOrder, $iKey ) use( &$aBindArgs){
				$aBindArgs[ ':arg' . $iKey ] = (int) preg_replace( "/[^0-9]/", "", $aOrder['order_activa_id'] );
			});
					
				$sth->execute( $aBindArgs  );
				return( true );
	
		} catch( Exception $e ){
			Netsuite_Db_Model::logError( $e );
			throw new Exception( 'Could NOT Set Orders to Working Status in the Activa DB' );
		}
	}
}