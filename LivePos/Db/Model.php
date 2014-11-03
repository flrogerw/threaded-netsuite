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

	public static function isValidLocation( $iLocationId ){

		try{

			$connection = Netsuite_Db_Db::getInstance();

			$sth = $connection->prepare( LivePos_Db_Query::getQuery( 'VALIDATE_LOCATION' ) );
			$sth->bindValue(':location_id', (int)$iLocationId, PDO::PARAM_INT);

			if ( !$sth ) {
				throw new Exception( explode(',', $sth->errorInfo() ) );
			}

			$sth->execute();
			$bReturn = ( $sth->fetchColumn() === false)? false: true;
			$connection = null;
			return( $bReturn );

		}catch( Exception $e ){
			self::logError( $e );
			throw new Exception( 'Could NOT Get TaxCode From the DB' );
		}
	}

	public function getProducts( array $aSkus ){

		try{

			$sth = $this->prepare( LivePos_Db_Query::getQuery( 'GET_PRODUCTS', null, count(  $aSkus ) ) );

			if ( !$sth ) {
				throw new Exception( explode(',', $sth->errorInfo() ) );
			}

			$aBindArgs = array();
			$returnArray = array();

			array_walk( array_unique( $aSkus ), function( $sSku, $iKey ) use( &$aBindArgs){
				$aBindArgs[':arg' . $iKey] = $sSku;
			});

				$sth->execute( $aBindArgs  );
				$aResults = $sth->fetchAll( PDO::FETCH_ASSOC );
				return( $aResults );

		}catch( Exception $e ){
			self::logError( $e );
			throw new Exception( 'Could NOT Get Product Data From the DB' );
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
	public function getPosOrders( $iLimit ){

		$dbResults = array();
		$aOrdersToComplete = array();

		try{

			$sth = $this->prepare( LivePos_Db_Query::getQuery( 'GET_ORDER_QUEUE' ) );
			$sth->bindValue(':limit', (int)$iLimit, PDO::PARAM_INT);

			if ( !$sth ) {
				throw new Exception( explode(',', $sth->errorInfo() ) );
			}

			$sth->execute();
			$dbResults = $sth->fetchAll(PDO::FETCH_ASSOC);

			if( !empty( $dbResults ) ){

				array_walk_recursive( $dbResults, function( $value, $iKey ) use( &$aOrdersToComplete){
					if( $iKey == 'receipt_id' ){
						$aOrdersToComplete[] = $value;
					}
				});

					$this->_setOrdersComplete( $aOrdersToComplete );
			}

			return( $dbResults );

		}catch( Exception $e ){
			self::logError( $e );
			throw new Exception( 'Could NOT Get Pending POS Orders From DB' );
		}
	}

	/**
	 *
	 *
	 */
	public function getAllDiscounts(){
	
		$dbResults = array();
	
		try{
	
			$sth = $this->prepare( LivePos_Db_Query::getQuery( 'GET_ALL_DISCOUNTS' ) );
	
			if ( !$sth ) {
				throw new Exception( explode(',', $sth->errorInfo() ) );
			}
	
			$sth->execute();
			$dbResults = $sth->fetchAll(PDO::FETCH_ASSOC);
			return( $dbResults );
	
		}catch( Exception $e ){
			self::logError( $e );
			throw new Exception( 'Could NOT Get All Discounts Information From DB' );
		}
	}
	
	
	/**
	 *
	 * @param array $aNewOrders - Pending Orders to Be Searched
	 * @access public
	 * @return array|null $_dbResults
	 * @throws Exception
	 */
	public function getDiscounts( array $aDiscountIds ){


		try{

			$sth = $this->prepare( LivePos_Db_Query::getQuery( 'GET_DISCOUNTS', null, count(  $aDiscountIds ) ) );

			if ( !$sth ) {
				throw new Exception( explode(',', $sth->errorInfo() ) );
			}

			$aBindArgs = array();
			$returnArray = array();

			array_walk( array_unique( $aDiscountIds ), function( $aDiscountId, $iKey ) use( &$aBindArgs){
				$aBindArgs[':arg' . $iKey] = $aDiscountId;
			});

				$sth->execute( $aBindArgs  );
				$aResults = $sth->fetchAll( PDO::FETCH_ASSOC );
				return( $aResults );

		} catch( Exception $e ){
			self::logError( $e );
			throw new Exception( 'Could NOT Get Discounts From the POS DB' );
		}
	}



	/**
	 *
	 * @param array $aNewOrders - Pending Orders to Be Searched
	 * @access public
	 * @return array|null $_dbResults
	 * @throws Exception
	 */
	protected function _setOrdersComplete( $aOrdersToComplete ){

		try{

			$sth = $this->prepare( LivePos_Db_Query::getQuery( 'SET_ORDERS_COMPLETE', null, count( $aOrdersToComplete ) ) );

			if ( !$sth ) {
				throw new Exception( explode(',', $sth->errorInfo() ) );
			}

			$aBindArgs = array();
			$returnArray = array();

			array_walk( $aOrdersToComplete, function( $aOrdersToComplete, $iKey ) use( &$aBindArgs){
				$aBindArgs[':arg' . $iKey] = $aOrdersToComplete;
			});

				$sth->execute( $aBindArgs  );
				return( true );

		} catch( Exception $e ){
			self::logError( $e );
			throw new Exception( 'Could NOT Set Orders to Complete in the POS DB' );
		}
	}


	/**
	 *
	 * @param array $aNewOrders - Pending Orders to Be Searched
	 * @access public
	 * @return array|null $_dbResults
	 * @throws Exception
	 */
	public function getWebOrders( array $aSearchOrders){

		$aBindArgs = array();
		$returnArray = array();

		if( !empty( $aSearchOrders ) ){

			try{

				$sth = $this->prepare( LivePos_Db_Query::getQuery( 'GET_CURRENT_ORDERS', null, count( $aSearchOrders ) ) );

				if ( !$sth ) {
					throw new Exception( explode(',', $sth->errorInfo() ) );
				}

				array_walk( $aSearchOrders, function( $aSearchOrders, $iKey ) use( &$aBindArgs){
					$aBindArgs[':arg' . $iKey] = $aSearchOrders;
				});

					$sth->execute( $aBindArgs  );
					$aResults = $sth->fetchAll( PDO::FETCH_ASSOC );

					array_walk( $aResults, function($aData, $sKey) use (&$returnArray){
						$returnArray[ $aData['order_activa_id'] ] = $aData['customer_id'];
					});

						return( $returnArray );

			} catch( Exception $e ){
				self::logError( $e );
				throw new Exception( 'Could NOT Read Processed Orders From the DB' );
			}
		}
	}


	/**
	 *
	 *
	 */
	public function skusToNsId( array $aSkus ){

		try{

			$sth = $this->prepare( LivePos_Db_Query::getQuery( 'SKU_TO_NSID', null, count( $aSkus ) ) );

			if ( !$sth ) {
				throw new Exception( explode(',', $sth->errorInfo() ) );
			}

			$aBindArgs = array();
			$returnArray = array();

			array_walk( $aSkus, function( $aSkus, $iKey ) use( &$aBindArgs){
				$aBindArgs[':arg' . $iKey] = $aSkus;
			});

				$sth->execute( $aBindArgs  );
				$aResults = $sth->fetchAll( PDO::FETCH_ASSOC );

				array_walk( $aResults, function($aData, $sKey) use (&$returnArray){
					$returnArray[ $aData['sku'] ] = array( 'id' => $aData['netsuite_id'], 'fulfilled_by' => $aData['fulfilled_by'] );

				});

					return( $returnArray );

		} catch( Exception $e ){
			self::logError( $e );
			throw new Exception( 'Could NOT Get NetSuite Id for Skus From DB' );
		}
	}

	/**
	 * Enters New Receipt Into Database
	 *
	 * @param array $aReceiptData
	 * @access public
	 * @return void
	 */
	public function insertProducts( array $aProductsData )
	{
		try{

			$sth = $this->prepare( LivePos_Db_Query::getQuery( 'INSERT_PRODUCT' ) );

			if ( !$sth ) {
				throw new Exception( explode(',', $sth->errorInfo() ) );
			}

			$this->beginTransaction();

			foreach( $aProductsData as $aProductData ){

				$sth->execute( $aProductData );
			}

			$this->commit();

		}catch( Exception $e ){
			$this->rollBack();
			self::logError( $e );
			throw new Exception( 'Could NOT Enter/Update LivePOS Products DB' );
		}
	}


	/**
	 * Enters New Receipt Into Database
	 *
	 * @param array $aReceiptData
	 * @access public
	 * @return void
	 */
	public function insertReceipts( array $aReceiptsData )
	{
		try{

			$sth = $this->prepare( LivePos_Db_Query::getQuery( 'INSERT_RECEIPT' ) );

			if ( !$sth ) {
				throw new Exception( explode(',', $sth->errorInfo() ) );
			}

			$this->beginTransaction();

			foreach( $aReceiptsData as $aReceiptData ){

				$sth->execute( $aReceiptData );
			}

			$this->commit();

		}catch( Exception $e ){
			$this->rollBack();
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
	public function updateIgnoredOrders( array $aOrdersArray ){


		try{

			$sth = $this->prepare( LivePos_Db_Query::getQuery( 'UPDATE_IGNORED_ORDER' ) );

			if ( !$sth ) {
				throw new Exception( explode(',', $sth->errorInfo() ) );
			}

			$this->beginTransaction();

			foreach( $aOrdersArray as $aOrder ){
					
				$sth->execute( $aOrder );
			}

			$this->commit();

		}catch( Exception $e ){
			self::logError( $e );
			throw new Exception( 'Could NOT Queue LivePOS Order Into DB: ' . $aOrder[':order_activa_id'] );
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

			$this->beginTransaction();

			foreach( $aOrdersArray as $aOrder ){
					
				$sth->execute( $aOrder );
			}

			$this->commit();

		}catch( Exception $e ){
			$this->rollBack();
			self::logError( $e );
			throw new Exception( 'Could NOT Queue LivePOS Orders Into DB' );
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