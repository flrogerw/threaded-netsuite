<?php 

require_once( __DIR__ . DIRECTORY_SEPARATOR . 'Configure.php' );

	try {
		
		/*
		$file_handle = fopen( APPLICATION_DIR . 'TestOrders/POS_TEST.csv', "r");
		while (!feof($file_handle)) {
			$aOutput[] = fgets($file_handle);
		}
		fclose($file_handle);

		
		$sJson = OrderJSON::convert( $aOutput );
		*/
	
		/** FIXES
			Removed:
			 Backslashes from dates
			 "_itemlocation":"corporate"

		 */
		
		$encoded = "nx3arHBVbhV2elo6n7cdf46hqZw+di9SKB7KIWI/3fKX+egQXU8pA1YYaKkjnbsNHrg8xk4+Loa4BMMs22VLwrcQqd9kKzt5v07+CF/uCCFndxUl2sC8TaJ/nS6KXfnfOVlp0bWkAk5A0Nb6gVSDTIhryWocO2QIvwZEUUApVslNM8tK8VglTs8F6DLjZyuwIwI5mmMewFAmjQEqOLd1vCRg36pAj/aPW756he+ZNVeP7Xlsp66lFbBnYZb57WifdgA0dUPwnxuhWKtozKZ+wCavfQTOEKClvzE2b6RV0YRugsPabV78oXaPIo/8htjkSPoN/Wt+pHUv7lBy5KU72N0eg4cpLPLf4a1E9btAQ1dLXaRCR7XQqnoZTIUZcXvGToxFSjep/uazvO6cMudtVwxeON441fJo87L9qvoTVLsUSJ/0mvP8yFPw2ZKjtVOrNzLkq+ejarjyKqbJppILXEkeHp8Spg+FOZ3wJXCFtbpK0heGuvycAqdMAoDIz+4tqypXujX6myOUCriqVZTuxAeHR7DTFNNh468mhzwOz33SWudFFMx1WIebMOUrSbDGy3zH1use/wIVYhTcrTMiKyHgzeKZh8MadmvKbd9B85viHI8qrfXpyzPEMnvjKx+aoCLB0l0c0hMEmawRWJVjtOpOb258ospNaQcLc+lOsvaeZTwUbNVXc/nEMnLv3XAB0FeZv7rBRqai+7A6nGuePHDlaquUyxuEBZNjc8GVxfiranrT5MGD5iIIhLhGCX1WGKAZ81Y4/fU4+VQZtE45bMVTeosBjpjmblr0nLZJBzO9TPrHiRChmx7KI/LjHTvIb/A+PC8vctsou+JRKIgl2zLvDufBGfrHGa212GNEM9H8gvfXW5NZH83c/z+Z9oB0DHk99ZA9nI/wTanDbhM9iIw7IyPx+4mzSXbsp1rBvj0uBn1N42sb5lOHdeUu40cNp2H5ZrIAKie0QBaj8/SnSj2nc4iF5R7NNeZITE7+2Sg4epbTxeuGiCDk3MmEA8KW43ev58xJzgIakbws+xUu2sKkxTETysvZtBmg7NfsObrHFah/btBHlcMxg6w+7P42cIHPRxQcF1HuNKKpB+gU5sqLH7oDizcTEGTZWUJ9Yy5FX+eSaVnJEQCT9l1ju47bnBA/BFPb4FRrrWnp2fLVfknDn0UntvenLDRqKwvuPzy3/UKvQP/TjWTIrniYT8tzr+XrCzrv+2XwOINajHkrpA==";


		echo(decrypt( $encoded ));
		die();
		
		
		$sJson = '{"order":{"_source":"Fotobar","location":1,"custentitycustomer_department":1,"leadsource":-6,"custbody_order_source":1,"ccprocessor":1,"custbody_order_source_id":"FD50667","trandate":"03/10/2014","entity":342609,"item":[{"_attention1":"Nathan","_attention2":"Pelton","addr1":"18090 Shamrock Blvd","city":"Big Rapids","state":"MI","zip":49307,"country":"US","phone":2489461046,"description":"$50 Gift Card","item":1119,"quantity":1,"rate":50.00,"subtotal":50.00,"custcol_produce_in_store":false,"custcol_store_pickup":false,"discounttotal":0},{"_attention1":"Nathan","_attention2":"Pelton","addr1":"18090 Shamrock Blvd","city":"Big Rapids","state":"MI","zip":49307,"country":"US","phone":2489461046,"description":"Orange Shadow Box Polaroid Picture 3.5 x 4.25","item":2526,"quantity":1,"rate":10.95,"subtotal":10.95,"custcol_produce_in_store":false,"custcol_store_pickup":false,"discounttotal":0},{"_attention1":"Nathan","_attention2":"Pelton","addr1":"18090 Shamrock Blvd","city":"Big Rapids","state":"MI","zip":49307,"country":"US","phone":2489461046,"description":"Green Shadow Box Polaroid Picture 3.5 x 4.25","item":2527,"quantity":1,"rate":10.95,"subtotal":10.95,"custcol_produce_in_store":false,"custcol_store_pickup":false,"discounttotal":0},{"_attention1":"Nathan","_attention2":"Pelton","addr1":"18090 Shamrock Blvd","city":"Big Rapids","state":"MI","zip":49307,"country":"US","phone":2489461046,"description":"Rustic Natural Shadow Box Polaroid Picture 3.5 x 4.25","item":3076,"quantity":1,"rate":15.95,"subtotal":15.95,"custcol_produce_in_store":false,"custcol_store_pickup":false,"discounttotal":0},{"_attention1":"Nathan","_attention2":"Pelton","addr1":"18090 Shamrock Blvd","city":"Big Rapids","state":"MI","zip":49307,"country":"US","phone":2489461046,"description":"3D Polaroid Picture 3.5 x 4.25","item":1141,"quantity":1,"rate":3,"subtotal":3,"custcol_produce_in_store":false,"custcol_store_pickup":false,"discounttotal":0},{"_attention1":"Nathan","_attention2":"Pelton","addr1":"18090 Shamrock Blvd","city":"Big Rapids","state":"MI","zip":49307,"country":"US","phone":2489461046,"description":"Polaroid 3.5 x 4.25","item":2892,"quantity":1,"rate":1,"subtotal":1,"custcol_produce_in_store":false,"custcol_store_pickup":false,"discounttotal":0},{"_attention1":"Nathan","_attention2":"Pelton","addr1":"18090 Shamrock Blvd","city":"Big Rapids","state":"MI","zip":49307,"country":"US","phone":2489461046,"description":"Polaroid 3.5 x 4.25","item":2892,"quantity":1,"rate":1,"subtotal":1,"custcol_produce_in_store":false,"custcol_store_pickup":false,"discounttotal":0}],"taxtotal":0,"taxrate":0,"shippingcost":7.95,"handlingcost":0,"discounttotal":0,"total":50.8,"pnrefnum":"3944777951920176056470","authcode":123456,"paymentmethod":5,"ccname":"Nathan Pelton","cczipcode":"33484","ccnumber":"4111111111111111","ccexpiredate":"07/2017","shipdate":"03/13/2014"},"customer":{"entityid":342609,"custentity_customer_source":1,"custentity_customer_source_id":"F50000","firstname":"Nathan","lastname":"Pelton","email":"npelton@gmail.com","isperson":false,"companyname":"Pelton Solutions LLC","custentity_fotomail":"nathan50000+dev@myfotobar.com","addressbook":{"billing":{"addr1":"18090 Shamrock Blvd","city":"Big Rapids","state":"MI","zip":49307,"country":"US","phone":2489461046}},"_source":"Fotobar","addressee":""}}';
		
		
		//var_dump($aOutput);
		//die();

		$pdo = new PDO('mysql:host='.SYSTEM_DB_HOST.';dbname='.SYSTEM_DB_DATABASE, SYSTEM_DB_USER, SYSTEM_DB_PASS);
		$stmt = $pdo->prepare('INSERT INTO fotobar_order_queue (customer_activa_id, order_activa_id, order_json) VALUES(:customer_activa_id, :order_activa_id, :order_json)');
		//$stmt->execute( array('customer_activa_id' => $aOrderData->customer->custentity_customer_source_id, ':order_activa_id' => $aOrderData->order->custbody_order_source_id, ':order_json' => encrypt( $sJson ) ) );
		$stmt->execute( array('customer_activa_id' => "F50005", ':order_activa_id' => "FTEST", ':order_json' => encrypt( $sJson ) ) );
		
	} catch(PDOException $e) {
		echo 'Error: ' . $e->getMessage();
	}



	function encrypt( $sData ){

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

	function decrypt( $sData ){

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
	
	