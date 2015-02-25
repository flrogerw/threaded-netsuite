<?php

class Inventory_Thread_InventoryServer {

	protected $_inventory = array();
	protected $_pool;
	private $_sessionId;

	public function __construct( array $aInventory, $sSessionId ){

		$this->_pool = new Thread_Pool( LIVEPOS_MAX_INVENTORY_THREADS );
		$this->_inventory = $aInventory;
		$this->_sessionId = $sSessionId;
	}

	public function hasInventory(){

		$bReturn = ( !empty( $this->_inventory ) )? true: false;
		return( $bReturn );
	}


	public function poolInventory() {

		if( !$this->hasInventory() ){
			return;
		}

		foreach( $this->_inventory as $aProduct ){

			$aWork[] = $tThread = $this->_pool->submit( new Inventory_Inventory( $aProduct, $this->_sessionId ) );
		}

		$this->_pool->shutdown();
		//$this->_logProductInventory();

		if( DEBUG ){
			foreach($this->_pool->workers as $worker) {
				print_r($worker->getData());
			}
		}
	}

	private function _logProductInventory() {

		$hasResults = false;

		foreach($this->_pool->workers as $worker) {

			$aResults = $worker->getData();

			if( isset( $aResults['product'] ) ){

				$aProducts[] = array(
						':product_id' => $aResults['product']['productid'],
						':product_price' => ( $aResults['product']['productprice'] != null )? $aResults['product']['productprice']:0.00,
						':product_sku' => $aResults['product']['productsku'],
						':product_description' => $aResults['product']['description'] );

				$hasResults = true;
			}else{
				#############################
				###  ADD ERROR LOGIC HERE
				var_dump($aResults);
			}
		}
		
		if( $hasResults == true ){
		
			$model = new LivePos_Db_Model();
			$model->insertProducts( $aProducts );
			$model = null;
		}
	}
}