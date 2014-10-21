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
final class LivePos_Db_Model
{

	/**
	 * Creates Parent DB Connection
	 *
	 * @access public
	 * @return void
	 */
	public function __construct() {
		$this->_dbHandle = Netsuite_Db_Db::getInstance();
	}
	
	/**
	 * 
	 * 
	 */
	public function skuToNsId( $sSku ){
		
		try{
		
			$sth = $this->_dbHandle->prepare( LivePos_Db_Query::getQuery( 'SKU_TO_NSID' ) );
		
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

			$sth = $this->_dbHandle->prepare( LivePos_Db_Query::getQuery( 'INSERT_RECEIPT' ) );

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