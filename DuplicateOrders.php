#!/usr/bin/php
<?php

require_once( __DIR__ . DIRECTORY_SEPARATOR . 'Configure.php' );



$model = Model::getInstance();
$sth = $model->prepare( 'Select * from order_errors' );

if ( !$sth ) {
	throw new Exception( explode(',', $sth->errorInfo() ) );
}

$sth->execute();
$aResults = $sth->fetchAll( PDO::FETCH_ASSOC );

//var_dump($aResults);


foreach( $aResults as $aresult ){
	
	
$nscall = new GetRecord($aresult['order_activa_id']);
$sth = $model->prepare( 'UPDATE order_errors set ns_id = ? where order_activa_id = ?' );
$sth->execute( array( json_decode($nscall->response), $aresult['order_activa_id'] ) );
echo( $aresult['order_activa_id'] . ' - ' .json_decode($nscall->response). "\n" );
	
}

die();



final class GetRecord {


	public $response = null;
	protected $_hasErrors = false;
	protected $_recordType;

	public function __construct( $sData ) {

		$this->_recordType = $sRecordType;
		$this->_data =  $sData;
		$this->_send();
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

		$rest_args = array(
				'method' => $this->_recordType,
				'rq' => base64_encode( $this->_data )
		);


		$sPayload = ( json_encode( $this->_data ) );


		$options = array(
				CURLOPT_URL => 'https://rest.na1.netsuite.com/app/site/hosting/restlet.nl?script=31&deploy=1',
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




final class Model extends PDO
{
	

	/**
	 * Singleton instance
	 * @access protected
	 * @staticvar PresswiseDB
	 */
	protected static $_instance = null;
	

	/**
	 * Standard Object Constructor
	 *
	 * @access public
	 * @return void
	 */
	public function __construct() {
		try{
			$dsn = 'mysql:host=' . SYSTEM_DB_HOST . ';dbname=' . SYSTEM_DB_DATABASE;
			parent::__construct( $dsn, SYSTEM_DB_USER, SYSTEM_DB_PASS );
			$this->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

		}catch( Exception $e ) {
			echo( $e->getMessage() );
		}
	}
	
	public static function getInstance()
	{
		if ( null === self::$_instance ) {
			self::$_instance = new self();
		}
	
		return self::$_instance;
	}
	
	
	
}
