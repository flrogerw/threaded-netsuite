<?php
class Netsuite_Crypt {
	
	public static function encrypt( $sData ){
	
		$td = mcrypt_module_open('rijndael-128', '', 'ecb', '');
		$iv = mcrypt_create_iv( mcrypt_enc_get_iv_size( $td ), MCRYPT_RAND );
		$ks = mcrypt_enc_get_key_size( $td );
		$key = substr( md5( SECRET_KEY ), 0, $ks );
		mcrypt_generic_init( $td, $key, $iv );
		$encrypted = mcrypt_generic( $td, $sData );
		mcrypt_generic_deinit( $td );
		mcrypt_module_close( $td );
	
		return( base64_encode( $encrypted ) );
	}
	
	public static function decrypt( $sData ){
	
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