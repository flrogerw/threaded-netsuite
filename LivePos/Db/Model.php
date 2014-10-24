<?php
/**
 * DB Model class
 *
 * @author gWilli
 * @version 1.0
 * @final Can NOT Extend
 * @copyright 2013
 * @see PDO
 * @uses Netsuite_Db_Db
 */
final class LivePos_Db_Model extends PDO
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
		}
	}

	/**
	 *
	 *
	 */
	public function getEntity( $locationId ){

		$dbResults = array();

		try{

			$sth = $this->prepare( LivePos_Db_Query::getQuery( 'GET_ENTITY' ) );

			if ( !$sth ) {
				throw new Exception( explode(',', $sth->errorInfo() ) );
			}

			$sth->execute( array( $locationId ) );
			$dbResults = $sth->fetch(PDO::FETCH_ASSOC);

			if( empty($dbResults) ){
				throw new Exception( 'Location Information Array was EMPTY From DB' );
			}
			return( $dbResults );

		}catch( Exception $e ){
			self::logError( $e );
			throw new Exception( 'Could NOT Get Location Information From DB' );
		}

	}

	/**
	 *
	 *
	 */
	public function skuToNsId( $sSku ){

		try{

			$sth = $this->prepare( LivePos_Db_Query::getQuery( 'SKU_TO_NSID' ) );

			if ( !$sth ) {
				throw new Exception( explode(',', $sth->errorInfo() ) );
			}

			$sth->execute( array( $sSku ) );
			$dbResults = $sth->fetch(PDO::FETCH_ASSOC);
			return( $dbResults );

		}catch( Exception $e ){
			self::logError( $e );
			throw new Exception( 'Could NOT Get NetSuite Id for Sku From DB' );
		}

	}

	/**
	 * Enters New Receipt Into Database
	 *
	 * @param array $aReceiptData
	 * @access public
	 * @return void
	 */
	public function insertReceipt( array $aReceiptData )
	{
		try{

			$sth = $this->prepare( LivePos_Db_Query::getQuery( 'INSERT_RECEIPT' ) );

			if ( !$sth ) {
				throw new Exception( explode(',', $sth->errorInfo() ) );
			}

			$sth->execute( $aReceiptData );

		}catch( Exception $e ){
			self::logError( $e );
			throw new Exception( 'Could NOT Enter/Update LivePOS Receipt Into DB' );
		}
	}

	/**
	 * Inserts Orders Into DB Queue
	 *
	 * @param string $sOrderJson
	 * @param string $sOrderActivaId
	 * @param int $iCustomerActivaId
	 * @access public
	 * @return void
	 */
	public function queueOrders( array $aOrdersArray ){


		try{

			$sth = $this->prepare( LivePos_Db_Query::getQuery( 'QUEUE_ORDER' ) );

			if ( !$sth ) {
				throw new Exception( explode(',', $sth->errorInfo() ) );
			}

			//$this->->beginTransaction();

			foreach( $aOrdersArray as $aOrder ){
				//array( ':customer_activa_id' => $aOrder[':customer_activa_id'],':order_activa_id' => $aOrder[':order_activa_id'],':order_json' => $aOrder[':order_json'] );
				$sth->execute( $aOrder );
			}

			//$this->->commit();

		}catch( Exception $e ){
			self::logError( $e );
			throw new Exception( 'Could NOT Queue LivePOS Order Into DB: ' . $aOrder[':order_activa_id'] );
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
			$sth = $connection->prepare( LivePos_Db_Query::getQuery('LOG_ERROR') );

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