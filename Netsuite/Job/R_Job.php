<?php

class Netsuite_Job_Job {

	public $response = null;
	protected $_hasErrors = false;
	protected $_recordType;
	protected $_data;

	public function __construct(){

	}

	public function isOk(){

		$bIsOk = ( $this->_hasErrors )? false: true;
		return( $bIsOk );
	}

	protected function _setAuthHeader() {

		$aAuth = array(
				'nlauth_account'=> NETSUITE_AUTH_ACCOUNT,
				'nlauth_email'=> NETSUITE_AUTH_EMAIL,
				'nlauth_signature'=> NETSUITE_AUTH_SIGNATURE );

		$auth_header = array(
				'Content-length: 0',
				'Content-type: application/json',
				'User-Agent-x: SuiteScript-Call',
				'Authorization: NLAuth ' . http_build_query( $aAuth, '', ',' ));

		return( $auth_header );
	}

	protected function _send(){

		$rest_args = array(
				'method' => $this->_recordType,
				'rq' => base64_encode( $this->_data )
		);

		$options = array(
				CURLOPT_URL => $this->_endpoint . '&' . http_build_query( $rest_args,'','&' ),
				CURLOPT_TIMEOUT => 10,
				CURLOPT_RETURNTRANSFER => true,
				CURLOPT_HTTPHEADER => $this->_setAuthHeader() );
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