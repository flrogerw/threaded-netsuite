<?php

class LivePos_Thread_ProductsServer {

	private $_productSkus = array();
	private $_products = array();
	protected $_pool;
	private $_sessionId;

	public function __construct( array $aProductIDs, $sSessionId ){

		$this->_pool = new Thread_Pool( MAX_THREADS );
		$this->productSkus = $aProductIDs;
		$this->_sessionId = $sSessionId;
	}

	public function hasProducts(){

		$bReturn = ( !empty( $this->productSkus ) )? true: false;
		return( $bReturn );
	}


	public function poolProducts() {

		if( !$this->hasProducts() ){
			return;
		}

		foreach( $this->productSkus as $iProductSku ){

			$aWork[] = $tThread = $this->_pool->submit( new LivePos_LivePosProduct( $iProductSku, $this->_sessionId ) );
		}

		$this->_pool->shutdown();
		$this->_logProduct();

		if( DEBUG ){
			foreach($this->_pool->workers as $worker) {
				print_r($worker->getData());
			}
		}
	}

	private function _logProduct() {

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