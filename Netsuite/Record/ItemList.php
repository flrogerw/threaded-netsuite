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
	 * @var boolean
	 * @access private
	*/
	private $_ismultishipto;

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
		$this->_ismultishipto = $ismultishipto;
		$iCount = count( array_filter( $aItemListData, 'is_array' ) );
		$this->_itemListArray = ( $iCount == count( $aItemListData ) )? $aItemListData: array( $aItemListData );
		$this->_validate( $iLocationId );

	}

	public function getItemList() {

		return( $this->_itemListEntries );
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
					$this->_itemListEntries[] = $oItem->getDiscountItem( $oItem->discountitem, $this->_ismultishipto );
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