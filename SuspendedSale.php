#!/usr/bin/php
<?php
/**
 * Add Suspended Sale Class and Example Code
 * 
 * @author gWilli
 * @version 1.0
 */

require_once( __DIR__ . DIRECTORY_SEPARATOR . 'Configure.php' ); // Has LivePOS Login Credentials

/**
 * Store Location Id
 */
$iLocationId = 28225;

/**
 * Store Employee Id
 */
$iEmployeeId = 87759;

/**
* Activa Order Id
 */
$sFotobarId = 'FDEV12345';

/**
 * Customer email
 */
$sCustoemrEmail = 'roger@roger15.jp';

/**
 * Customer LivePOS ID
 */
$iCustomerId = null;


$call = new SuspendedSale();

// Test for Existence in DB before Calling 'AddCustomer'
if( $iCustomerId == null ){
	
	$aCustomer = array( 'strEmail' => $sCustoemrEmail );
	$call->sendRequest('AddCustomer', $call->getSessionId(), $aCustomer);
	
	if( $call->isOk() ){
		
		$aParsedCustomer = $call->ParseCustomer();
		$iCustomerId = $aParsedCustomer->intResultID;

		var_dump( $call->getMessage() );
		//WRITE CUSTOMER ID TO DB HERE
		
	} else{

		throw new Exception( $call->getMessage() );
	}

} else{
	
	$iCustomerId = DB_RESULT; // Use DB Result as $iCustomerId
}

	$aSuspendedSale = array(
			'intClientID' => $iCustomerId,
			'strReferenceCode' => $sFotobarId,
			'intLaneID' => 1,
			'bIsLocationTaxExempt' => false,
			'intLocationID' => $iLocationId,
			'enumEmployees' => array( array('intEmployeeID' => $iEmployeeId, 'dblEmployeeSalesPercentage' => 100)),
			'enumProducts' => array( array(
					'intProductID' => 1922251,
					'intProductUnits' => 1,
					'dblProductPrice' => 1,
					'bIsTaxExempt' => false,
					'dblTaxPerc1' => 0.095,
					'dblTaxPerc2' => 0.00,
					'dblTaxPerc3' => 0.00,
					'enumSerialNumbers' => array()))
	);

	$call->sendRequest('AddSuspendedSale', $call->getSessionId(), $aSuspendedSale );

	if( $call->isOk() ){
		
		# IT WORKED!   DO SOMETHING SUPER BITCHEN HERE
		var_dump( $call->getMessage() );
		
	}else{
		
		# UH OH SHITE BROKE!
		throw new Exception( $call->getMessage() );
	}


	
	

/**
 * Posts Suspended Sale to LivePOS
 * Also Creates LivePOS Customer if Needed
 * 
 * @author gWilli
 * @version 1.0
 * @uses Configure.php
 */
class SuspendedSale {

	/**
	 * Holds Call Response
	 * 
	 * @var array
	 * @access private
	 */
	private $_response = array();
	
	/**
	 * Flag for Errors
	 * 
	 * @var boolean
	 * @access private
	 */
	private $_hasErrors = false;
	
	/**
	 * Holds Authorization Response
	 * 
	 * @access private
	 * @var string
	 */
	private $_authResponse;

	/**
	 * Standard Object Constructor
	 * 
	 * @param boolean $bCreateAuth
	 * @throws Exception
	 */
	public function __construct( $bCreateAuth = true ) {

		if( $bCreateAuth ){
			$this->_sendAuth();
			if( !$this->isOk() ){
				throw new Exception('Could Not get Auth String from LivePOS: ' . implode(',',$this->_response['error'] ) );
			}
		}
	}

	/**
	 * Parse AddCustomer Response
	 *
	 * @access public
	 * @return standard object
	 */
	public function ParseCustomer(){

		$returnArray = array();

		$returnArray = json_decode( $this->_response['data'] );
		return( $returnArray[0] );
	}

	/**
	 * Returns Error Status
	 *
	 * @access public
	 * @return boolean
	 */
	public function isOk(){

		$bIsOk = ( $this->_hasErrors )? false: true;
		return( $bIsOk );
	}

	/**
	 * Returns Error String
	 *
	 * @access public
	 * @return string
	 */
	public function getErrors(){
		return( $this->_response['error'] );
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
	
	/**
	 * Returns Entire Response Array
	 *
	 * @access public
	 * @return array
	 */
	public function getResponse(){

		return( $this->_response );
	}

	/**
	 * Gets the Session Id From the Authorization Response
	 *
	 * @access public
	 * @return string
	 */
	public function getSessionId(){

		$oResponse = current( json_decode( $this->_authResponse ) );
		return( $oResponse->strAPISessionKey );

	}

	/**
	 * Sets Authorization Header for API Service Call
	 *
	 * @access private
	 * @return array
	 */
	private function _setHeader( $iContentLength = 0, $sSessionId ){

		$header = array('APISessionKey: ' . $sSessionId,
				'Content-Type: application/json',
				'Content-length: '. $iContentLength,
		        'Accept: */*');

		return( $header );
	}

	/**
	 * Sends API Service Call Request
	 * 
	 * @access public
	 * @return void
	 */
	public function sendRequest( $requestType, $sSessionId, array $params = null ){

		$sPayload = ( $params == null )? $params: json_encode( $params );

		$options = array(
				CURLOPT_URL => LIVEPOS_URL . $requestType,
				CURLOPT_TIMEOUT => 30,
				CURLOPT_POST => 1,
				CURLOPT_CUSTOMREQUEST => "POST",
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

	/**
	 * Sets Header for Authentication Request
	 * 
	 * @access private
	 * @return array
	 */
	private function _setAuthHeader( $iContentLength = 0 ) {

		$auth_header = array(
				'APIApplicationKey: ' . LIVEPOS_API_KEY,
				'APIApplicationID: ' . LIVEPOS_API_ID,
				'Content-Type: application/json',
				'Content-length: '. $iContentLength,
				'Accept: */*');
		
		return( $auth_header );
	}

	/**
	 * Sends Authentication Request
	 * 
	 * @access private
	 * @return void
	 */
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
}