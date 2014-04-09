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
		//$crap='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';

		//$sJson ='{"order":{"_source":"Fotobar","location":1,"department":1,"leadsource":-6,"custbody_order_source":1,"ccprocessor":1,"custbody_order_source_id":"FD50689","trandate":"04\/01\/2014","entity":342609,"item":[{"attention":"Nathan Pelton","addressee":"Pelton Solutions LLC","addr1":"18090 Shamrock Blvd","city":"Big Rapids","state":"MI","zip":49307,"country":"US","phone":2489461046,"shipmethod":1011,"description":"GC50","item":1119,"quantity":1,"rate":50,"subtotal":50,"custcol_produce_in_store":false,"custcol_store_pickup":false,"discounttotal":0,"giftcertnumber":"TEST'.rand(10000,90000).'","giftcertfrom":"Nathan","giftcertrecipientname":"Nathan","giftcertrecipientemail":"npelton@gmail.com","giftcertmessage":"testing","location":1}],"taxtotal":0,"taxrate":0,"shippingcost":0,"handlingcost":0,"discounttotal":0,"total":50,"pnrefnum":"3963828264610176056428","authcode":123456,"paymentmethod":5,"ccname":"Nathan Pelton","ccnumber":"4111111111111111","ccexpiredate":"06\/2018","cczipcode":49307,"shipdate":"04\/04\/2014","customform":107,"ismultishipto":true,"custbody_web_discount_code":""},"customer":{"custentity_customer_source":1,"custentity_customer_source_id":"F50000","firstname":"Nathan","lastname":"Pelton","email":"npelton@gmail.com","isperson":false,"companyname":"Pelton Solutions LLC","custentity_fotomail":"nathan50000+dev@myfotobar.com","addressbook":{"billing":{"addr1":"18090 Shamrock Blvd","city":"Big Rapids","state":"MI","zip":49307,"country":"US","phone":2489461046}},"_source":"Fotobar","custentitycustomer_department":1,"entityid":342609}}';		

	$sJson = '{"order":{"_source":"Fotobar Store 1","location":2,"department":2,"leadsource":2,"custbody_order_source":28,"ccprocessor":1,"custbody_order_source_id":"FD50693","trandate":"04\/08\/2014","entity":342609,"item":[{"addr1":"645 Elmcroft Blvd #13406","city":"Rockville","state":"MD","zip":20850,"country":"US","phone":2489461046,"shipmethod":1011,"description":"Black Shadowbox Polaroid 9 x 11","item":2536,"custcol162":"","quantity":1,"rate":35,"subtotal":35,"custcol_produce_in_store":true,"custcol_store_pickup":false,"discounttotal":0,"location":1,"attention":"Nathan Pelton","addressee":"Shipping Company Name","isresidential":false},{"addr1":"1040 Holland Dr.","city":"Boca Raton","state":"FL","zip":33487,"country":"US","phone":5612264355,"shipmethod":10,"description":"Polaroid 3.5 x 4.25","item":1137,"custcol162":"","quantity":6,"rate":1,"subtotal":6,"custcol_produce_in_store":true,"custcol_store_pickup":false,"discounttotal":false,"location":2,"attention":"Polaroid Fotobar","addressee":"Polaroid Fotobar","addr2":null,"province":""}],"taxtotal":0.36,"taxrate":6,"shippingcost":0,"handlingcost":0,"discounttotal":0,"total":49.31,"pnrefnum":false,"paymentmethod":"","_gcamount":0,"shipdate":"04\/11\/2014","customform":129,"ismultishipto":true,"custbody_web_discount_code":""},"customer":{"custentity_customer_source":3,"custentity_customer_source_id":"F50000","firstname":"Nathan","lastname":"Pelton","email":"npelton@gmail.com","isperson":false,"companyname":"Pelton Solutions LLC","custentity_fotomail":"nathan50000+dev@myfotobar.com","_source":"Fotobar Store 1","custentitycustomer_department":2,"entityid":342609}}';
	
	//echo( decrypt( $crap ) );
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
	
	