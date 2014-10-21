<?php

class LivePos_Maps_Items extends LivePos_Maps_Map {

	protected $_aData;


	protected $_mapArray = array(
			"intProductSoldUnits"  => 'quantity',
			"dblProductSoldNetPrice" => 'rate',
			"strProductName" => 'description',
			"strProductSKU" => 'item');

	/**
	 *
	 * @access public
	 * @return void
	*/
	public function __construct( array $aItems ) {
		
		parent::__construct();
		$this->_aData = $aItems;
		$this->_mappedData = $this->_map();
		$this->_skusToNsIds();
	}


	private function _skusToNsIds(){

		$model = new LivePos_Db_Model();

		foreach( $this->_mappedData as &$aItem ){
				
			try{

				$aNsData = $model->skuToNsId( $aItem['item']);
				$aItem['item'] = $aNsData['netsuite_id'];

			}catch (Exception $e){
				$this->_errors = $e->getMessage();
			}

				
		}
	}

}