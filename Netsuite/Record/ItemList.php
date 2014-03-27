<?php
/**
 *
 * @example
 * $args = array( )
 */
class Netsuite_Record_ItemList extends Netsuite_Record_Base implements Netsuite_Interface_INetsuite {

	/**
	 *
	 * @var array
	 * @access private
	 */
	private $_itemListArray = array();

	/**
	 *
	 * @var array
	 * @access private
	*/
	private $_itemListEntries = array();

	/**
	 * Customer Activa Id
	 * @var string
	 * @access protected
	 *
	*/
	protected $_activa_id;

	/**
	 * Customer Netsuite Id
	 * @var int
	 * @access protected
	 *
	 */
	protected $_entity_id;

	/**
	 * Array of Exception SKUs that need special Processing Rules
	 * @staticvar array
	 * @access public
	 */
	public static $EXCEPTION_ITEMS = array();

	/**
	 *
	 * Converts Single itemList Entry into Array of Arrays if Not Already One
	 *
	 * @access protected
	 * @return void
	*/
	public function __construct( $aItemListData, $iLocationId, $sActivaId, $iEntityId, $ismultishipto = false ) {

		$this->_activa_id = $sActivaId;
		$this->_entity_id = $iEntityId;
		$iCount = count( array_filter( $aItemListData, 'is_array' ) );
		$this->_itemListArray = ( $iCount == count( $aItemListData ) )? $aItemListData: array( $aItemListData );
		$this->_updateAddressList( $iLocationId );
		$this->_validate( $iLocationId );

	}

	public function getItemList() {

		return( $this->_itemListEntries );
	}

	protected function _updateAddressList( $iLocationId ){

		try{

			$oAddressBook = new Netsuite_Record_AddressBook();

			// Build Address Object, Check if Address is In Database and add to Netsuite Payload if NOT
			if( $ismultishipto === true ){
				
				foreach( $this->_itemListArray as $iKey => &$aItem ){

					// Set Item Address to Store if Shipping Method is STR (In-Store)
					if( $aItem['custcol_produce_in_store'] === true ){

						$model = new Netsuite_Db_Model();
						$aStoreAddress = $model->getStoreAddress( $iLocationId );
						$aStoreAddress['defaultshipping'] = true;
						$aStoreAddress['isresidential'] = false;
						$aStoreAddress['label'] = ucfirst( strtolower($aStoreAddress['store_name'] ) ) . ' Store';

						$aItem = array_merge( $aItem, $aStoreAddress );
					}

					$oAddress = new Netsuite_Record_Address( $aItem );

					switch( true ){
						case( !$oAddress->isOk() ):
							$this->logError( 'Item List Entry '. ucfirst($iKey) . ' Has Errors: ' . implode( ', ', $oAddress->getErrors() ) );
							break;

						case( $oAddressBook->getAddress( $this->_activa_id, $oAddress->getAddress() ) === false ):
							$aOrderAddresses[] = $oAddress;
							break;
					}
				}
			}

			if( !empty( $aOrderAddresses ) ){

				$aNetsuiteAddresses = json_decode( $oAddressBook->setAddressBookEntry( $this->_entity_id, $aOrderAddresses ), true );

				switch( true ){
					
					// Check for a NULL Response
					case( gettype($aNetsuiteAddresses) != 'array' ):
						$this->logError( 'Netsuite Error: Netsuite Returned a NULL Response');
						break;
						
						// Check for an Error
					case( isset( $aNetsuiteAddresses['error'] ) ):
						// LOG ERROR
						$this->logError( 'Netsuite Error: ' . $aNetsuiteAddresses['error']['code'] . ' :: ' . $aNetsuiteAddresses['error']['message'] );
						break;
						
						// Check for Failure
					case( $aNetsuiteAddresses['status'] == 'failure' ):
						$this->logError( 'Netsuite Error: ' . $aNetsuiteAddresses['payload']['code'] . ' :: ' . $aNetsuiteAddresses['payload']['details'] );
						break;
						
						// Update Local Database
					default:
						foreach( $aNetsuiteAddresses as $aAddress ){
							$oAddressBook->setSystemAddress( $this->_activa_id, $aAddress['id'], $aAddress['text'] );
						}
						break;
				}
			}


			// Not Required, Only for UPDATING the entire Address Book
			//$this->updateSystemAddressBook( $iEntityId, $sActivaId );

		}catch( Exception $e ){
			Netsuite_Db_Model::logError( $e->getMessage() );
		}
	}


	/**
	 *
	 * @param int $iLocationId -- Order Location InternalId
	 * @param string $sItemLocation -- corporate or store
	 * @return void
	 */
	private function _validate($iLocationId) {

		foreach( $this->_itemListArray as $iKey => $aItem  ){

			$oItem = Netsuite_Record::factory()->item( $aItem, $iLocationId, $this->_activa_id );

			if(!$oItem->isOk() ){
				$this->logError( 'Item List Entry '.($iKey + 1) . ' Has Errors: ' . implode( ', ', $oItem->getErrors() ) );
				continue;
			} else {
				$this->_itemListEntries[] = $oItem->getItem();
				// Check For Discount
				if( $oItem->hasDiscount() ){
					$this->_itemListEntries[] = $oItem->getDiscountItem( $oItem->discountitem );
				}
			}

			if( $oItem->hasWarnings() ) {
				$this->logWarn( 'Item List Entry ' . ($iKey + 1) . ' Has Warnings: ' . implode( ', ', $oItem->getWarnings() ) );
			}
		}

	}

	/**
	 * @return string
	 */
	public function getJSON() {
		return( json_encode( $this->_itemListEntries ) );
	}
}