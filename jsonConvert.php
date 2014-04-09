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
		
		$sJson ='{"order":{"_source":"Fotobar","location":1,"department":1,"leadsource":-6,"custbody_order_source":1,"ccprocessor":1,"custbody_order_source_id":"FD50689","trandate":"04\/01\/2014","entity":342609,"item":[{"attention":"Nathan Pelton","addressee":"Pelton Solutions LLC","addr1":"18090 Shamrock Blvd","city":"Big Rapids","state":"MI","zip":49307,"country":"US","phone":2489461046,"shipmethod":1011,"description":"GC50","item":1119,"quantity":1,"rate":50,"subtotal":50,"custcol_produce_in_store":true,"custcol_store_pickup":true,"discounttotal":0,"giftcertnumber":"TEST'.rand(10000,90000).'","giftcertfrom":"Nathan","giftcertrecipientname":"Nathan","giftcertrecipientemail":"npelton@gmail.com","giftcertmessage":"testing","location":1}],"taxtotal":0,"taxrate":0,"shippingcost":0,"handlingcost":0,"discounttotal":0,"total":50,"pnrefnum":"3963828264610176056428","authcode":123456,"paymentmethod":5,"ccname":"Nathan Pelton","ccnumber":"4111111111111111","ccexpiredate":"06\/2018","cczipcode":49307,"shipdate":"04\/04\/2014","customform":107,"ismultishipto":true,"custbody_web_discount_code":""},"customer":{"custentity_customer_source":1,"custentity_customer_source_id":"F50000","firstname":"Nathan","lastname":"Pelton","email":"npelton@gmail.com","isperson":false,"companyname":"Pelton Solutions LLC","custentity_fotomail":"nathan50000+dev@myfotobar.com","addressbook":{"billing":{"addr1":"18090 Shamrock Blvd","city":"Big Rapids","state":"MI","zip":49307,"country":"US","phone":2489461046}},"_source":"Fotobar","custentitycustomer_department":1,"entityid":342609}}';		

	//$sJson = '{"order":{"_source":"Fotobar Store 1","location":2,"department":2,"leadsource":2,"custbody_order_source":28,"ccprocessor":1,"custbody_order_source_id":"FD50693","trandate":"04\/08\/2014","entity":342609,"item":[{"addr1":"645 Elmcroft Blvd #13406","city":"Rockville","state":"MD","zip":20850,"country":"US","phone":2489461046,"shipmethod":1011,"description":"Black Shadowbox Polaroid 9 x 11","item":2536,"custcol162":"","quantity":1,"rate":35,"subtotal":35,"custcol_produce_in_store":true,"custcol_store_pickup":false,"discounttotal":0,"location":1,"attention":"Nathan Pelton","addressee":"Shipping Company Name","isresidential":false},{"addr1":"1040 Holland Dr.","city":"Boca Raton","state":"FL","zip":33487,"country":"US","phone":5612264355,"shipmethod":10,"description":"Polaroid 3.5 x 4.25","item":1137,"custcol162":"","quantity":6,"rate":1,"subtotal":6,"custcol_produce_in_store":true,"custcol_store_pickup":false,"discounttotal":false,"location":2,"attention":"Polaroid Fotobar","addressee":"Polaroid Fotobar","addr2":null,"province":""}],"taxtotal":0.36,"taxrate":6,"shippingcost":0,"handlingcost":0,"discounttotal":0,"total":49.31,"pnrefnum":false,"paymentmethod":"","_gcamount":0,"shipdate":"04\/11\/2014","customform":129,"ismultishipto":true,"custbody_web_discount_code":""},"customer":{"custentity_customer_source":3,"custentity_customer_source_id":"F50000","firstname":"Nathan","lastname":"Pelton","email":"npelton@gmail.com","isperson":false,"companyname":"Pelton Solutions LLC","custentity_fotomail":"nathan50000+dev@myfotobar.com","_source":"Fotobar Store 1","custentitycustomer_department":2,"entityid":342609}}';

		
		
		
	var_dump( json_decode( $sJson ) );
		die();
		
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
	
	