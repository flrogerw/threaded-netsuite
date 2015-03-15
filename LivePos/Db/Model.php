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
final class LivePos_Db_Model extends PDO
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

	/**
	 * Check for the Existence of Specific Location.
	 * 
	 * @param integer $iLocationId
	 * @throws Exception
	 * @return boolean
	 */
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
			throw new Exception( 'Could NOT Validate Location From the DB' );
		}
	}
	
	public function getDiscountedItems( $iDiscountCode ){
		
		$dbResults = array();
		
		try{
		
			$sth = $this->prepare( LivePos_Db_Query::getQuery( 'GET_DISCOUNTED_ITEMS' ) );
		
			if ( !$sth ) {
				throw new Exception( explode(',', $sth->errorInfo() ) );
			}
		
			$sth->execute( array( $iDiscountCode ) );
			$dbResults = $sth->fetchAll(PDO::FETCH_ASSOC);
			
			$aFlattenedResults =  iterator_to_array( new RecursiveIteratorIterator( new RecursiveArrayIterator( $dbResults ) ), false);
			
			return( $aFlattenedResults );
		
		}catch( Exception $e ){
			self::logError( $e );
			throw new Exception( 'Could NOT Get Discounted Items From DB' );
		}
	}

	/**
	 * Update Netsuite Queued Order to Merged for Orders with Both
	 * Shipped Items and Instore Items
	 *
	 * @param array $aOrdersToMerge
	 * @access public
	 * @return void
	 */
	public function updateToMergeError( array $aMergeErrors ){

		try{

			$sth = $this->prepare( LivePos_Db_Query::getQuery( 'SET_ORDERS_MERGED', null, count($aMergeErrors) ) );

			if ( !$sth ) {
				throw new Exception( explode(',', $sth->errorInfo() ) );
			}

			$aBindArgs = array();

			array_walk( array_unique( $aMergeErrors ), function( $sQueueId, $iKey ) use( &$aBindArgs){
				$aBindArgs[':arg' . $iKey] = $sQueueId;
			});

				$sth->execute( $aBindArgs );

		}catch( Exception $e ){
			self::logError( $e );
			throw new Exception( 'Could NOT Update Queued Order to Merge Error' );
		}
	}



	/**
	 * Update Netsuite Queued Order to Merged for Orders with Both
	 * Shipped Items and Instore Items
	 *
	 * @param array $aOrdersToMerge
	 * @access public
	 * @return void
	 */
	public function updateToMerged( array $aOrdersToMerge ){
		
		try{
			
			if( empty( $aOrdersToMerge ) ){
				return;
			}
			
			$aOrdersToMerge = array_values(array_unique( $aOrdersToMerge ));

			$sth = $this->prepare( LivePos_Db_Query::getQuery( 'SET_ORDERS_MERGED', null, count( $aOrdersToMerge ) ) );

			if ( !$sth ) {
				throw new Exception( explode(',', $sth->errorInfo() ) );
			}

			$aBindArgs = array();

			array_walk( $aOrdersToMerge, function( $sQueueId, $iKey ) use( &$aBindArgs){
				$aBindArgs[':arg' . $iKey] = $sQueueId;
			});

				$sth->execute( $aBindArgs );

		}catch( Exception $e ){
			self::logError( $e );
			throw new Exception( 'Could NOT Update Queued Order to Merged' );
		}
	}

	/**
	 * Get Product Information Based on Skus Array
	 *
	 * @param array $aSkus
	 * @access public
	 * @return array
	 */
	public function getProducts( array $aSkus ){
				
		try{
			
			if( empty( $aSkus ) ){
				return;
			}
			
			$aSkus = array_values(array_unique( $aSkus ));

			$sth = $this->prepare( LivePos_Db_Query::getQuery( 'GET_PRODUCTS', null, count(  $aSkus ) ) );

			if ( !$sth ) {
				throw new Exception( explode(',', $sth->errorInfo() ) );
			}

			$aBindArgs = array();
			$returnArray = array();

			array_walk( $aSkus, function( $sSku, $iKey ) use( &$aBindArgs){
				$aBindArgs[':arg' . $iKey] = $sSku;
			});

				$sth->execute( $aBindArgs  );
				$aResults = $sth->fetchAll( PDO::FETCH_ASSOC );
				return( $aResults );

		}catch( Exception $e ){
			self::logError( $e );
			throw new Exception( 'Could NOT Get Product Data From the DB: ' . implode( ',', $aSkus ) );
		}
	}

	/**
	 *
	 *
	 */
	public function getEntity( $iLocationId ){

		$dbResults = array();

		try{

			$sth = $this->prepare( LivePos_Db_Query::getQuery( 'GET_ENTITY' ) );

			if ( !$sth ) {
				throw new Exception( explode(',', $sth->errorInfo() ) );
			}

			$sth->execute( array( $iLocationId ) );
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
			
			$aDiscountIds = array_values(array_unique( $aDiscountIds ));

			$sth = $this->prepare( LivePos_Db_Query::getQuery( 'GET_DISCOUNTS', null, count(  $aDiscountIds ) ) );

			if ( !$sth ) {
				throw new Exception( explode(',', $sth->errorInfo() ) );
			}

			$aBindArgs = array();
			$returnArray = array();

			array_walk( $aDiscountIds, function( $aDiscountId, $iKey ) use( &$aBindArgs){
				$aBindArgs[':arg' . $iKey] = $aDiscountId;
			});

				$sth->execute( $aBindArgs  );
				$aResults = $sth->fetchAll( PDO::FETCH_ASSOC );	

				if( empty($aResults ) ) {
					throw new Exception( 'A Coupon Code is Not in DB: ' . implode(',', $aBindArgs ) );
				}
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
	public function getWebOrders(){

		try{

			$sth = $this->prepare( LivePos_Db_Query::getQuery( 'GET_WEB_ORDERS' ) );

			if ( !$sth ) {
				throw new Exception( explode(',', $sth->errorInfo() ) );
			}

			$sth->execute();
			$aResults = $sth->fetchAll( PDO::FETCH_ASSOC );
			return( $aResults );

		} catch( Exception $e ){
			self::logError( $e );
			throw new Exception( 'Could NOT Read Web Orders From the DB' );
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
	
	public function nsIdToSku( array $aNsIds ){
	
		try{
	
			$sth = $this->prepare( LivePos_Db_Query::getQuery( 'NSID_TO_SKU', null, count( $aNsIds ) ) );
	
			if ( !$sth ) {
				throw new Exception( explode(',', $sth->errorInfo() ) );
			}
	
			$aBindArgs = array();
	
			array_walk( $aNsIds, function( $iId, $iKey ) use( &$aBindArgs){
				$aBindArgs[':arg' . $iKey] = $iId;
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
	 * Enters Test Results Into Database
	 *
	 * @param array $aReceiptData
	 * @access public
	 * @return void
	 */
	public function insertTestResults( array $aTestResults )
	{
		try{
	
			$sth = $this->prepare( LivePos_Db_Query::getQuery( 'SET_DEBUG_ORDERS' ) );
	
			if ( !$sth ) {
				throw new Exception( explode(',', $sth->errorInfo() ) );
			}
	
				$sth->execute( $aTestResults );		
	
		}catch( Exception $e ){
			self::logError( $e );
			throw new Exception( 'Could NOT Enter Test Result Data into Database' );
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