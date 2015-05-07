<?php

final class LivePos_Job_GetRecord {


	private $_response = array();
	private $_hasErrors = false;
	private $_authResponse;


	public function __construct( $bCreateAuth = true ) {

		if( $bCreateAuth ){
			$this->_sendAuth();
			if( !$this->isOk() ){
				throw new Exception('Could Not get Auth String from LivePOS: ' . implode(',',$this->_response['error'] ) );
			}
		}
	}

	public function isOk(){

		$bIsOk = ( $this->_hasErrors )? false: true;
		return( $bIsOk );
	}

	public function getErrors(){
		return( $this->_response['error'] );
	}

	public function getResponse(){

		return( $this->_response );
	}

	public function getSessionId(){

		$oResponse = current( json_decode( $this->_authResponse ) );
		return( $oResponse->strAPISessionKey );

	}

	private function _setHeader( $iContentLength = 0, $sSessionId ){

		$header = array('APISessionKey: ' . $sSessionId,
				'Content-Type: application/json',
				'Content-length: '. $iContentLength,
				'Accept: */*');

		return( $header );
	}

	public function sendRequest( $requestType, $sSessionId, array $params = null ){

		$sPayload = ( $params == null )? $params: json_encode( $params );

		$options = array(

				CURLOPT_URL => LIVEPOS_URL . $requestType,
				CURLOPT_TIMEOUT => 30,
				CURLOPT_POST => 1,
				CURLOPT_CUSTOMREQUEST => "POST",
				CURLOPT_SSL_VERIFYPEER => false,
				CURLOPT_POSTFIELDS => $sPayload,
				CURLOPT_HTTPHEADER => $this->_setHeader( strlen($sPayload), $sSessionId ),
				CURLOPT_RETURNTRANSFER => true );

		$cURL = curl_init();

		curl_setopt_array( $cURL, $options );

		for( $i=0; $i<3; $i++ ) {

			$curl_result = curl_exec($cURL);

			if ( curl_errno($cURL) == 0 ) {

				$this->_response['data'] = $curl_result;
				$this->_response['code'] = curl_getinfo($cURL, CURLINFO_HTTP_CODE);

				if( $this->_response['code'] != 200 ){
					$this->_hasErrors = true;
					$this->_response['error'][] = 'Response Code: ' . $this->_response['code'];
					$this->_response['error'][] = 'Message: ' . implode(',', json_decode( $curl_result, true )  );
				}

				curl_close($cURL);
				return;
			}
		}

		$this->_response['error'][] =  'cURL Error: ' . curl_error( $cURL );
		$this->_hasErrors = true;
		curl_close($cURL);
		return;
	}


	private function _setAuthHeader( $iContentLength = 0 ) {

		$auth_header = array(
				'APIApplicationKey: ' . LIVEPOS_API_KEY,
				'APIApplicationID: ' . LIVEPOS_API_ID,
				'Content-Type: application/json',
				'Content-length: '. $iContentLength,
				'Accept: */*');


				return( $auth_header );
	}

	private function _sendAuth(){

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
				CURLOPT_SSL_VERIFYPEER => false,
				CURLOPT_POSTFIELDS => $sPayload,
				CURLOPT_HTTPHEADER => $this->_setAuthHeader( strlen($sPayload) ),
				CURLOPT_RETURNTRANSFER => true );

		$cURL = curl_init();
		curl_setopt_array( $cURL, $options );

		for( $i=0; $i<3; $i++ ) {

			$curl_result = curl_exec($cURL);

			if ( curl_errno($cURL) == 0 ) {
				curl_close($cURL);
				$this->_authResponse = $curl_result;
				return;
			}
		}

		$this->_response['error'][] =  'cURL Error: ' . curl_error( $cURL );
		$this->_hasErrors = true;
		curl_close($cURL);
	}
	
	public function getDataString(){
	
		return( $this->_response['data'] );
	}
	
	/**
	 * Returns the Message Part of the Response
	 * Includes More Verbose Error Message
	 *
	 * @access public
	 * @return string
	 */
	public function getMessage(){
	
		$oMessage = json_decode( $this->_response['data'] );
		return( $oMessage->Message );
	}
}
