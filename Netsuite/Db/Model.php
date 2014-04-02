<?php
/**
 * DB Model class
 *
 * @author gWilli
 * @version 1.0
 * @final Can NOT Extend
 * @copyright 2013
 * @see PDO
 * @uses
 */
final class Netsuite_Db_Model
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
	 * Set Netsuite Login Information and NUmber of Orders Queued
	 *
	 * @param int $iOrdersRun
	 * @access public
	 * @return bool
	 * @throws Exception
	 */
	public static function setPoolQueueLog( $iOrdersRun ){
	
		try{
			$connection = Netsuite_Db_Db::getInstance();
			$sth = $connection->prepare( Netsuite_Db_Query::getQuery( 'POOL_QUEUE_LOG', NETSUITE_COMPANY ) );
	
			if ( !$sth ) {
				throw new Exception( explode(',', $sth->errorInfo() ) );
			}
			

			$sth->execute(  array( ':orders_run' => (int) $iOrdersRun, ':netsuite_id' => NETSUITE_AUTH_EMAIL ) );
			return( true );
	
	
		} catch( Exception $e ){
			self::logError( $e );
			throw new Exception( 'Could NOT Set Pool Queue Log in the DB' );
		}
	}
	
	
	/**
	 * Returns Internal ID for Tax Code
	 *
	 * @param int $sCusterId - Activa Customer Id
	 */
	public function getTaxCode( $iLocationId ) {
	
		try{
	
			$sth = $this->_dbHandle->prepare( Netsuite_Db_Query::getQuery( 'GET_TAX_CODE', NETSUITE_COMPANY ) );
	
			if ( !$sth ) {
				throw new Exception( explode(',', $sth->errorInfo() ) );
			}
	
			$sth->execute( array(  $iLocationId ) );
			$this->_dbResults = $sth->fetchColumn();
			return( $this->_dbResults );
	
		}catch( Exception $e ){
			self::logError( $e );
			throw new Exception( 'Could NOT Get TaxCode From the DB' );
		}
	}
	
	
	
	public function getStoreAddress( $iLocationId ){
	
		try{
	
			$sth = $this->_dbHandle->prepare( Netsuite_Db_Query::getQuery( 'GET_STORE_ADDRESS' ) );
	
			if ( !$sth ) {
				throw new Exception( explode(',', $sth->errorInfo() ) );
			}
	
			$sth->execute( array( $iLocationId ) );
			$this->_dbResults = $sth->fetch(PDO::FETCH_ASSOC);
			return( $this->_dbResults );
	
		}catch( Exception $e ){
			self::logError( $e );
			throw new Exception( 'Could NOT Get Store Address From DB' );
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

			$sth = $this->_dbHandle->prepare( Netsuite_Db_Query::getQuery( 'SET_ORDER_WORKING', null, count( $aOrders ) ) );

			if ( !$sth ) {
				throw new Exception( explode(',', $sth->errorInfo() ) );
			}

			$aBindArgs = array( ':order_working_date' => date( "Y-m-d H:i:s" ) );
				
			array_walk( $aOrders, function( $aOrder, $iKey ) use( &$aBindArgs){
				$aBindArgs[':arg' . $iKey] = (int)$aOrder['queue_id'];
			});
					
				$sth->execute( $aBindArgs  );
				return( true );

		} catch( Exception $e ){
			self::logError( $e );
			throw new Exception( 'Could NOT Set Orders to Working Status in the DB' );
		}
	}


	public function getActivaAddresses( $sActivaId ){

		try{

			$sth = $this->_dbHandle->prepare( Netsuite_Db_Query::getQuery( 'GET_ACTIVA_ADDRESSES' ) );

			if ( !$sth ) {
				throw new Exception( explode(',', $sth->errorInfo() ) );
			}

			$sth->execute( array( $sActivaId ) );
			$this->_dbResults = $sth->fetchColumn();
			return( $this->_dbResults );

		}catch( Exception $e ){
			self::logError( $e );
			throw new Exception( 'Could NOT Get Custmer Addresses From DB' );
		}

	}

	/**
	 * Set New Customer Entry Into System Address Book
	 *
	 * @param string $sActivaId - Users Activa Id
	 * @param int $iNetsuiteId - Netsuite Internal Id of New Address
	 * @param string $sAddress - Address String to be Added
	 * @access public
	 * @return int|null $_dbResults
	 * @throws Exception
	 */
	public function setAddress( $sActivaId, $iNetsuiteId, $sAddress ){

		try{

			$sth = $this->_dbHandle->prepare( Netsuite_Db_Query::getQuery( 'SET_ADDRESS' ) );

			if ( !$sth ) {
				throw new Exception( explode(',', $sth->errorInfo() ) );
			}

			$sth->execute( array( ':netsuite_id' => $iNetsuiteId, ':activa_id' => $sActivaId, ':address_hash' => md5( strtolower( $sAddress ) ) ) );
			return( true );

		} catch( PDOException $e ){
			self::logError( $e );
		}
		catch( Exception $e ){
			self::logError( $e );
			throw new Exception( 'Could NOT Insert Customer Address Into DB' );
		}

	}


	/**
	 * Gets Address Book Entry From System DataBase
	 *
	 * @param string $sActivaId
	 * @access public
	 * @return int|null $_dbResults
	 * @throws Exception
	 */
	public function getAddress( $sActivaId, $sAddress )
	{

		try{

			$sth = $this->_dbHandle->prepare( Netsuite_Db_Query::getQuery( 'GET_ADDRESS' ) );

			if ( !$sth ) {
				throw new Exception( explode(',', $sth->errorInfo() ) );
			}

			$sth->execute( array( $sActivaId, md5( strtolower( $sAddress ) ) ) );
			$this->_dbResults = $sth->fetchColumn();
			return( $this->_dbResults );

		}catch( Exception $e ){
			self::logError( $e );
			throw new Exception( 'Could NOT Get Address From DB' );
		}
	}


	/**
	 * Inserts Orders Into DB Queue
	 *
	 * @param string $sOrderJSON
	 * @access public
	 * @return void
	 */
	public function queueOrder( $sOrderJSON )
	{

		try{

			$sth = $this->_dbHandle->prepare( Netsuite_Db_Query::getQuery( 'QUEUE_ORDER' ) );

			if ( !$sth ) {
				throw new Exception( explode(',', $sth->errorInfo() ) );
			}

			$sth->execute( array( ':order_json' => $sOrderJSON ) );

		}catch( Exception $e ){
			self::logError( $e );
			throw new Exception( 'Could NOT Queue Order Into DB' );
		}
	}

	/**
	 * Returns Customer InternalId based on Activa Id
	 *
	 * @param string $sCusterId - Activa Customer Id
	 */
	public function getCustomer( $sCustomerId ) {

		try{

			$sth = $this->_dbHandle->prepare( Netsuite_Db_Query::getQuery( 'GET_CUSTOMER', NETSUITE_COMPANY ) );

			if ( !$sth ) {
				throw new Exception( explode(',', $sth->errorInfo() ) );
			}

			$sth->execute( array( $sCustomerId ) );
			$this->_dbResults = $sth->fetchColumn();
			return( $this->_dbResults );

		}catch( Exception $e ){
			self::logError( $e );
			throw new Exception( 'Could NOT Get Orders From the Queue DB' );
		}
	}



	/**
	 * Returns Orders From the Queue
	 *
	 *
	 *
	 */
	public function readOrderQueue( $iLimit ) {

		try{

			$sth = $this->_dbHandle->prepare( Netsuite_Db_Query::getQuery( 'GET_ORDER_QUEUE' ) );
			$sth->bindValue(':limit', (int)$iLimit, PDO::PARAM_INT);

			if ( !$sth ) {
				throw new Exception( explode(',', $sth->errorInfo() ) );
			}

			$sth->execute();
			$this->_dbResults = $sth->fetchAll( PDO::FETCH_ASSOC );
			return( $this->_dbResults );

		}catch( Exception $e ){
			self::logError( $e );
			throw new Exception( 'Could NOT Get Orders From the Queue DB' );
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

			$sth = $this->_dbHandle->prepare( Netsuite_Db_Query::getQuery( 'PROCESS_LOG' ) );

			if ( !$sth ) {
				throw new Exception( explode(',', $sth->errorInfo() ) );
			}

			$sth->execute( $aUpdateData );

			return( true );

		}catch( Exception $e ){
			self::logError( $e );
			throw new Exception( 'Could NOT Update Orders in the Queue DB' );
		}
	}

	/**
	 * Update Orders From the Queue
	 *
	 *
	 *
	 */
	public function updateOrderQueue( $iQueueId, $sStatus ) {

		try{

			$sth = $this->_dbHandle->prepare( Netsuite_Db_Query::getQuery( 'UPDATE_ORDER_QUEUE' ) );

			if ( !$sth ) {
				throw new Exception( explode(',', $sth->errorInfo() ) );
			}

			$sth->execute( array(
					':queue_id' => (int)$iQueueId,
					':order_status' => $sStatus,
					':order_complete_date' => date("Y-m-d H:i:s") ) );
			return( true );

		}catch( Exception $e ){
			self::logError( $e );
			throw new Exception( 'Could NOT Update Orders in the Queue DB' );
		}
	}
	/**
	 * Returns Internal ID for Image Sku Passed by Activa
	 *
	 *
	 *
	 */
	public function getImageSku( $sActivaSource ) {

		try{

			$sth = $this->_dbHandle->prepare(Netsuite_Db_Query::getQuery( 'GET_IMAGE_SKU' ) );

			if ( !$sth ) {
				throw new Exception( explode(',', $sth->errorInfo() ) );
			}

			$sth->execute( array( $sActivaSource ) );
			$this->_dbResults = $sth->fetchColumn();

			return( $this->_dbResults );

		}catch( Exception $e ){
			self::logError( $e );
			throw new Exception( 'Could NOT Get ImageSku Information From DB' );
		}
	}

	/**
	 * Returns All Sources Based Off of Location
	 *
	 * @param string $sActivaSource
	 * @throws Exception
	 * @access public
	 * @return array
	 */
	public function getSources( $sActivaSource ) {

		try{

			$sth = $this->_dbHandle->prepare( Netsuite_Db_Query::getQuery( 'GET_SOURCES', NETSUITE_COMPANY ));

			if ( !$sth ) {
				throw new Exception( explode(',', $sth->errorInfo() ) );
			}

			$sth->execute( array( $sActivaSource ) );
			$this->_dbResults = $sth->fetch( PDO::FETCH_ASSOC );

			return( $this->_dbResults );

		}catch( Exception $e ){
			self::logError( $e );
			throw new Exception( 'Could NOT Get Sources Information From DB' );
		}
	}

	/**
	 * Returns Shipping Method
	 *
	 * @param string $sLocation
	 * @param string $sActivaCode
	 * @access public
	 * @throws Exception
	 * @return integer
	 */
	public function getShippingMethod( $sLocation, $sActivaCode ) {

		try{

			$sth = $this->_dbHandle->prepare( Netsuite_Db_Query::getQuery( 'GET_SHIPPING_METHODS', NETSUITE_COMPANY ) );

			if ( !$sth ) {
				throw new Exception( explode(',', $sth->errorInfo() ) );
			}

			$sth->execute( array( '%'.$sLocation.'%', $sActivaCode, $sActivaCode ) );
			$this->_dbResults = $sth->fetchColumn();

			return( $this->_dbResults );

		}catch( Exception $e ){
			self::logError( $e );
			throw new Exception( 'Could NOT Get Shipping Methods Information From DB' );
		}
	}


	public function getExceptionItems() {
		try{
	
			$sth = $this->_dbHandle->prepare( Netsuite_Db_Query::getQuery( 'GET_EXCEPTION_ITEMS', NETSUITE_COMPANY ) );
	
			if ( !$sth ) {
				throw new Exception( explode(',', $sth->errorInfo() ) );
			}
	
			$sth->execute( array( NETSUITE_COMPANY ) );
			$this->_dbResults = $sth->fetchAll( PDO::FETCH_ASSOC );
	
			return( array_combine( array_column( $this->_dbResults, 'sku') , array_column( $this->_dbResults, 'sku_location') ) );
			//return( $this->_dbResults );
	
		}catch( Exception $e ){
			self::logError( $e );
			throw new Exception( 'Could NOT Get Item Xref Information From DB' );
		}
	
	}
	
	
	
	public function getItem( $sType, $sSearch, $sLocation = 'corporate' ) {
		try{

			$sth = $this->_dbHandle->prepare( Netsuite_Db_Query::getQuery( 'GET_ITEM', NETSUITE_COMPANY ) );

			if ( !$sth ) {
				throw new Exception( explode(',', $sth->errorInfo() ) );
			}

			$sth->execute( array( NETSUITE_COMPANY, $sType, $sSearch, $sLocation ) );
			$this->_dbResults = $sth->fetchColumn();

			return( $this->_dbResults );

		}catch( Exception $e ){
			self::logError( $e );
			throw new Exception( 'Could NOT Get Item Xref Information From DB' );
		}

	}


	/**
	 * Enters New Customer Into Database
	 *
	 * @param object $exception
	 * @access public
	 * @return void
	 */
	public function insertCustomer( $sXrefValue, $iInternalId )
	{
		
		try{

			$sth = $this->_dbHandle->prepare( Netsuite_Db_Query::getQuery( 'INSERT_CUSTOMER' ) );

			if ( !$sth ) {
				throw new Exception( explode(',', $sth->errorInfo() ) );
			}

			$sth->execute( array( ':xrefvalue' => $sXrefValue,
					':internalid' => $iInternalId) );

		}catch( Exception $e ){
			self::logError( $e );
			throw new Exception( 'Could NOT Enter New Customer Into DB' );
		}
	}


	/**
	 * Calls Cross Reference Table
	 *
	 * @param string $sType
	 * @param string $sSearch
	 * @param string $sCompany
	 * @access public
	 * @throws Exception
	 * @return mixed int|string
	 */
	public function callXrefTable( $sType, $sSearch ) {

		// Use Customer Table when Applicable
		$sTablePrefix = ( $sType == 'Customer' )? 'customer': NETSUITE_COMPANY;

		try{

			$sth = $this->_dbHandle->prepare( Netsuite_Db_Query::getQuery( 'CALL_XREF', $sTablePrefix ) );

			if ( !$sth ) {
				throw new Exception( explode(',', $sth->errorInfo() ) );
			}

			$sth->execute( array( NETSUITE_COMPANY, $sType, $sSearch ) );
			$this->_dbResults = $sth->fetchColumn();

			return( $this->_dbResults );

		}catch( Exception $e ){
			self::logError( $e );
			throw new Exception( 'Could NOT Get Xref Information From DB' );
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
		var_dump($exception);
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
	
	private function _arrayOfArrays( $sSku, $sLocation ){
		
	}
}