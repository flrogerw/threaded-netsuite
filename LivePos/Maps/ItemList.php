<?php

class LivePos_Maps_ItemList {

	protected $_aData;
	protected $_itemList = array();

	/**
	 *
	 * @access public
	 * @return void
	*/
	public function __construct( array $aItems ) {

		$this->_aData = $aItems;
		$this->_getItemList();
		$this->_skusToNsIds();
	}

	private function _getItemList(){

		foreach( $this->_aData as $aItem ){
			$item = LivePos_Maps_MapFactory::create( 'item', array( $aItem ) );
			$this->_itemList[] = $item->getPublicVars();
		}
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
	}
}