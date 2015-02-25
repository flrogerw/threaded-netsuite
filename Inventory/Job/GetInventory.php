<?php

final class Inventory_Job_GetInventory {


	public $response = null;
	protected $_hasErrors = false;
	protected $_locationId;

	public function __construct( $iLocationId ) {

		$this->_locationId = $iLocationId;
		//$this->_data = json_encode(  array( 'locationId' => $this->_locationId ) );
		$this->_send();
	}
	
	public function getResponse(){
		
		return( $this->response );
	}

	public function isOk(){

		$bIsOk = ( $this->_hasErrors )? false: true;
		return( $bIsOk );
	}

	public function setAuthHeader( $iContentLength = 0 ) {

		$aAuth = array(
				'nlauth_account'=> NETSUITE_AUTH_ACCOUNT,
				'nlauth_email'=> NETSUITE_AUTH_EMAIL,
				'nlauth_signature'=> NETSUITE_AUTH_SIGNATURE );

		$auth_header = array(
				'Content-length: '. $iContentLength,
				'Content-type: application/json',
				'User-Agent-x: SuiteScript-Call',
				'Authorization: NLAuth ' . http_build_query( $aAuth, '', ',' ));

		return( $auth_header );
	}

	protected function _send(){

		$rest_args = array( 'locationId' => $this->_locationId );

		$sPayload = ( json_encode( $rest_args ) );

		$options = array(
				CURLOPT_URL => NETSUITE_GET_INVENTORY,
				CURLOPT_TIMEOUT => 30,
				CURLOPT_POST => 1,
				CURLOPT_CUSTOMREQUEST => "POST",
				CURLOPT_POSTFIELDS => $sPayload,
				CURLOPT_HTTPHEADER => $this->setAuthHeader( strlen($sPayload) ),
				CURLOPT_RETURNTRANSFER => true );

		$cURL = curl_init();
		curl_setopt_array( $cURL, $options );

		for( $i=0; $i<3; $i++ ) {

			$curl_result = curl_exec($cURL);

			if ( curl_errno($cURL) == 0 ) {
				curl_close($cURL);
				$this->response = $curl_result;
				return;
			}
		}

		$this->response =  'cURL Error: ' . curl_error( $cURL );
		$this->_hasErrors = true;
		curl_close($cURL);
	}
}
