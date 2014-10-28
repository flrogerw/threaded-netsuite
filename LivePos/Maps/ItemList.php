<?php

class LivePos_Maps_ItemList {

	protected $_aData;
	protected $_itemList = array();
	
	protected $_ignorePosSkus = array('Ship', 'Custom Art');

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
			
			if( !in_array($item->item, $this->_ignorePosSkus) ){
				
				$this->_itemList[] = $item->getPublicVars();
			}
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

		$model = new LivePos_Db_Model();

		foreach( $this->_itemList as &$aItem ){

			try{

				$aNsData = $model->skuToNsId( $aItem['item']);
				$aItem['item'] = $aNsData['netsuite_id'];

			}catch (Exception $e){
				$this->_errors = $e->getMessage();
			}
		}
		$model = null;
	}
}