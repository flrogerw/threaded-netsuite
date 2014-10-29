<?php

class LivePos_Maps_ItemList {

	protected $_aData;
	protected $_itemList = array();
	public $hasWebItems = false;

	protected $_webSkus = array('Ship', 'Custom Art');

	/**
	 *
	 * @access public
	 * @return void
	*/
	public function __construct( array $aItems, $locationData ) {

		$this->_aData = $aItems;
		$this->_getItemList( $locationData );
		$this->_skusToNsIds();
	}

	private function _getItemList( $locationData ){

		foreach( $this->_aData as $aItem ){

			$item = LivePos_Maps_MapFactory::create( 'item', array( $aItem ), $locationData );

			if( in_array($item->item, $this->_webSkus) ){
				$this->hasWebItems = true;
				continue;
			}
				
			$this->_itemList[] = $item->getPublicVars();
		}
	}

	public function hasItems(){

		$bReturn = ( !empty( $this->_itemList ) )? true: false;
		return( $bReturn );
	}

	public function getItems(){

		return( $this->_itemList );
	}

	private function _skusToNsIds(){

		if( $this->hasItems() ){

			$aSkusArray = array();

			// Create Array of Item Skus
			array_walk( $this->_itemList, function($aData, $sKey) use (&$aSkusArray){
				$aSkusArray[] = $aData[ 'item' ];
			});

				$model = new LivePos_Db_Model();
				$aNsData = $model->skusToNsId( array_unique( $aSkusArray ) );

				// Replace Skus
				array_walk( $this->_itemList, function(&$aData, $sKey) use (&$aNsData){
					$aData['item'] = ( $aNsData[ $aData['item'] ]['id'] == null )?$aData['item']:$aNsData[ $aData['item'] ]['id'];
				});

					$model = null;
		}
	}
}