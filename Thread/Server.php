<?php

class Thread_Server {

	protected $_model;
	protected $_orders;
	protected $_pool;

	public function __construct(){

		$this->_pool = new Thread_Pool( MAX_THREADS );
		$this->_model = new Netsuite_Db_Model();
		$this->_activa = new Netsuite_Db_Activa();
		$this->_orders = $this->_model->readOrderQueue( MAX_ORDER_RECORDS );
	}

	protected function _setOrders(){

		//$this->_orders = $this->_model->readOrderQueue( MAX_ORDER_RECORDS );
		$this->_model->setOrderWorking( $this->_orders );
		$this->_activa->setOrderWorking( $this->_orders );
	}

	public function hasOrders(){

		//$this->_setOrders();
		$bReturn = ( sizeof( $this->_orders ) < 1 )? false: true;
		if( $bReturn ){ $this->_setOrders(); }
		return( $bReturn );
	}

	public function poolOrders() {

		foreach( $this->_orders as $aOrder ){

			$sOrderData = json_decode( $this->_decrypt( $aOrder['order_json'] ), true );
				
			$this->_replaceBool( $sOrderData );
			$aWork[] = $tThread = $this->_pool->submit( new Netsuite_Netsuite( $sOrderData, $aOrder['queue_id'], $aOrder['order_activa_id'] ) );
				
		}

		$this->_pool->shutdown();

		if( DEBUG ){
			foreach($this->_pool->workers as $worker) {
				printf("%s made %d attempts ...\n", $worker->getName(), $worker->getAttempts());
				print_r($worker->getData());
					
			}
		}
	}


	protected function _replaceBool( &$aArray ){

var_dump($aArray);
		$aIsBoolean = array(
				'isperson',
				'custcol_produce_in_store',
				'custcol_store_pickup',
				'ismultiship',
				'_netsuite',
				'istaxable'
		);

		foreach( $aArray as $key=> &$data ){
			if( is_array( $data ) ){
				$this->_replaceBool($data);
			}else{
				if( in_array( $key, $aIsBoolean ) ){
					$aArray[$key] = ( $data == '1' )? true: false;
				}
			}

		}
	}
	protected function _decrypt( $sData ){

		$td = mcrypt_module_open( 'rijndael-128', '', 'ecb', '' );
		$iv = mcrypt_create_iv(mcrypt_enc_get_iv_size( $td ), MCRYPT_RAND);
		$ks = mcrypt_enc_get_key_size( $td );
		$key = substr( md5( SECRET_KEY ), 0, $ks );

		mcrypt_generic_init( $td, $key, $iv );
		$decrypted = mdecrypt_generic( $td, base64_decode( $sData ) );
		$decrypted = rtrim($decrypted,"\0");
		mcrypt_generic_deinit( $td );
		mcrypt_module_close( $td );

		return( $decrypted );

	}
}