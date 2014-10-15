<?php

final class LivePos_Job_GetRecord {


	public $response = null;
	protected $_hasErrors = false;

	public function __construct() {

	}

	public function isOk(){

		$bIsOk = ( $this->_hasErrors )? false: true;
		return( $bIsOk );
	}

	public function setAuthHeader( $iContentLength = 0 ) {

		$auth_header = array(
				'APIApplicationKey'=> LIVEPOS_API_KEY,
				'APIApplicationID'=> LIVEPOS_API_ID,
				'Content-length: '. $iContentLength,
				'Content-Type: application/json',
				'Accept: */*');

				return( $auth_header );
	}

	public function sendAuth(){

		$loginCredentials = array(
				'strAdminUserName'=> LIVEPOS_USER,
				'strAdminPassword'=> LIVEPOS_PASS,
				'strAdminSecurityCode'=> LIVEPOS_API_CODE,
		);

		$sPayload = json_encode( $loginCredentials );


		$options = array(
				CURLOPT_URL => LIVEPOS_AUTH_URL,
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
