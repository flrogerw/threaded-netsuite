<?php 
//////////////////////////
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
		
		$crap='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';

		$sJson = '{"order":{"_source":"Fotobar","location":1,"department":1,"leadsource":-6,"custbody_order_source":1,"ccprocessor":1,"custbody_order_source_id":"FD50689","trandate":"04\/01\/2014","entity":"354514","item":[{"_attention1":"Nathan","_attention2":"Pelton","addr1":"18090 Shamrock Blvd","city":"Big Rapids","state":"MI","zip":49307,"country":"US","phone":2489461046,"shipmethod":1011,"description":"GC50","item":1119,"quantity":1,"rate":50,"subtotal":50,"custcol_produce_in_store":false,"custcol_store_pickup":false,"discounttotal":0,"giftcertnumber":"wf7p79prf","giftcertfrom":"Nathan","giftcertrecipientname":"Nathan","giftcertrecipientemail":"npelton@gmail.com","giftcertmessage":"testing","location":1}],"taxtotal":0,"taxrate":0,"shippingcost":0,"handlingcost":0,"discounttotal":0,"total":50,"pnrefnum":"3963828264610176056428","authcode":123456,"paymentmethod":5,"ccname":"Nathan Pelton","ccnumber":"4111111111111111","ccexpiredate":"06\/2018","cczipcode":49307,"shipdate":"04\/04\/2014","customform":107,"ismultishipto":true,"custbody_web_discount_code":""},"customer":{"custentity_customer_source":1,"custentity_customer_source_id":"F50000","firstname":"Nathan","lastname":"Pezzzzltonson","email":"npelton@gmail.com","isperson":"true","companyname":"Pelton Solutions2 LLC2","custentity_fotomail":"nathan50000+dev@myfotobar.com","addressbook":{"billing":{"addr1":"18090 Shamrock Blvd","city":"Big Rapids","state":"MI","zip":49307,"country":"US","phone":2489461046}},"_source":"Fotobar","custentitycustomer_department":1,"entityid":"354514"}}';
		
		////echo( decrypt( $crap ) );
		//die();
		
		/** FIXES
			Removed:
			 Backslashes from dates
			 "_itemlocation":"corporate"

		 */
		
//Use GC		
		//$sJson = '{"order":{"_source":"Fotobar Store 2","giftcertificateitem":[{"giftcertcode":"store405"}],"location":2,"department":2,"leadsource":2,"custbody_order_source":28,"ccprocessor":1,"custbody_order_source_id":"F74831","trandate":"03\/27\/2014","taxtotal":3.96,"taxrate":6,"shippingcost":0,"handlingcost":0,"discounttotal":0,"total":69.96,"pnrefnum":false,"paymentmethod":"","item":[{"shipmethod":10,"description":"Orange Shadowbox Polaroid 3.5 x 4.25","item":1197,"quantity":6,"rate":11,"subtotal":66,"custcol_produce_in_store":false,"custcol_store_pickup":false,"discounttotal":0,"location":2}],"shipdate":"04\/01\/2014","customform":129,"ismultishipto":false,"custbody_web_discount_code":""},"customer":{"custentity_customer_source":3,"custentity_customer_source_id":"F73242","firstname":"Jen","lastname":"Stone","email":"roger.williams@successories.com","isperson":true,"custentity_fotomail":"jen73242@myfotobar.com","_source":"Fotobar Store 2","addressee":"","custentitycustomer_department":2}}';
		
// Buy GC
		//$sJson = '{"order":{"_source":"Fotobar Store 2","location":2,"department":2,"leadsource":2,"custbody_order_source":28,"ccprocessor":1,"custbody_order_source_id":"F74831","trandate":"03\/27\/2014","taxtotal":3.96,"taxrate":6,"shippingcost":0,"handlingcost":0,"discounttotal":0,"total":69.96,"pnrefnum":false,"paymentmethod":"","item":[{"giftcertrecipientname":"Roger Willliams","giftcertrecipientemail":"roger.williams@successories.com","giftcertnumber":"ROGERTEST","giftcertmessage":"Happy Birthday","giftcertfrom":"Roger Williams","shipmethod":10,"description":"Gift Certificate","item":1119,"quantity":1,"rate":50,"subtotal":50,"custcol_produce_in_store":false,"custcol_store_pickup":false,"discounttotal":0,"location":2},{"shipmethod":10,"description":"Orange Shadowbox Polaroid 3.5 x 4.25","item":1197,"quantity":6,"rate":11,"subtotal":66,"custcol_produce_in_store":true,"custcol_store_pickup":false,"discounttotal":0,"location":2}],"shipdate":"04\/01\/2014","customform":129,"ismultishipto":false,"custbody_web_discount_code":""},"customer":{"custentity_customer_source":3,"custentity_customer_source_id":"F73242","firstname":"Jen","lastname":"Stone","email":"roger.williams@successories.com","isperson":true,"custentity_fotomail":"jen73242@myfotobar.com","_source":"Fotobar Store 2","addressee":"","custentitycustomer_department":2}}';
		
	
	
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
	
	