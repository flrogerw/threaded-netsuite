<?php 


require_once( __DIR__ . DIRECTORY_SEPARATOR . 'Configure.php' );

	try {
		
		
		$file_handle = fopen( APPLICATION_DIR . 'TestOrders/POS_TEST.csv', "r");
		while (!feof($file_handle)) {
			$aOutput[] = fgets($file_handle);
		}
		fclose($file_handle);

		
		$sJson = OrderJSON::convert( $aOutput );
		
		//var_dump( json_decode( $sJson ) );
			
		
		//$crap = '{"authcode":"*****","billaddress":"Nathan Pelton\nNathan Pelton\n18090 Shamrock Blvd\nBig Rapids MI 49307","ccapproved":"T","ccexpiredate":"05\/2016","ccname":"Nathan Pelton","ccnumber":"**** **** **** 1111","cczipcode":"49307","custbody_order_source":"1","custbody_order_source_id":"FD50674","custbody_textrequired":"F","custentity_customer_source_id":"F50000","customform":107,"department":1,"discountrate":0,"discounttotal":0,"entity":342609,"getauth":"F","handlingcost":0,"ismultishipto":"T","istaxable":"T","leadsource":-6,"location":1,"paymentmethod":5,"pnrefnum":"3945494461970176056428","recordtype":"salesorder","shipaddress":"Nathan Pelton\nNathan Pelton\n18090 Shamrock Blvd\nBig Rapids MI 49307","shipdate":"03\/14\/2014","tobeemailed":"F","tobeprinted":"F","trandate":"03\/11\/2014","item":[{"amount":80,"custcol_produce_in_store":"F","custcol_store_pickup":"F","description":"Acrylic Polaroid 9 x 11","discountitem":"F","discounttotal":-8,"isclosed":"F","isestimate":"F","istaxable":"T","item":2416,"location":1,"price":-1,"quantity":1,"rate":80,"shipaddress":"293507"},{"amount":-8,"custcol_produce_in_store":"F","custcol_store_pickup":"F","discountitem":"F","discounttotal":0,"isclosed":"F","isestimate":"F","istaxable":"F","item":"F","location":1,"price":-1,"quantity":1,"rate":-8,"shipaddress":"293507"},{"amount":1,"custcol_produce_in_store":"F","custcol_store_pickup":"F","description":"Polaroid 3.5 x 4.25","discountitem":"F","discounttotal":0,"isclosed":"F","isestimate":"F","istaxable":"T","item":3078,"location":1,"price":-1,"quantity":1,"rate":1,"shipaddress":"293507"},{"amount":1,"custcol_produce_in_store":"F","custcol_store_pickup":"F","description":"Polaroid 3.5 x 4.25","discountitem":"F","discounttotal":0,"isclosed":"F","isestimate":"F","istaxable":"T","item":3078,"location":1,"price":-1,"quantity":1,"rate":1,"shipaddress":"293507"},{"amount":1,"custcol_produce_in_store":"F","custcol_store_pickup":"F","description":"Polaroid 3.5 x 4.25","discountitem":"F","discounttotal":0,"isclosed":"F","isestimate":"F","istaxable":"T","item":3078,"location":1,"price":-1,"quantity":1,"rate":1,"shipaddress":"293507"},{"amount":1,"custcol_produce_in_store":"F","custcol_store_pickup":"F","description":"Polaroid 3.5 x 4.25","discountitem":"F","discounttotal":0,"isclosed":"F","isestimate":"F","istaxable":"T","item":3078,"location":1,"price":-1,"quantity":1,"rate":1,"shipaddress":"293507"},{"amount":1,"custcol_produce_in_store":"F","custcol_store_pickup":"F","description":"Polaroid 3.5 x 4.25","discountitem":"F","discounttotal":0,"isclosed":"F","isestimate":"F","istaxable":"T","item":3078,"location":1,"price":-1,"quantity":1,"rate":1,"shipaddress":"293507"},{"amount":1,"custcol_produce_in_store":"F","custcol_store_pickup":"F","description":"Polaroid 3.5 x 4.25","discountitem":"F","discounttotal":0,"isclosed":"F","isestimate":"F","istaxable":"T","item":3078,"location":1,"price":-1,"quantity":1,"rate":1,"shipaddress":"293507"}]}';
		
		
		
		//$aOrderData = json_decode($crap );
	//	$crap = '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';
		//var_dump(json_decode(decrypt( $crap )));
	
	die();
		
	
		/** FIXES
			Removed:
			 Backslashes from dates
			 "_itemlocation":"corporate"

		 */
		
		
		$sJson = '{"order":{"_source":"Fotobar","location":1,"custentitycustomer_department":1,"leadsource":-6,"custbody_order_source":1,"ccprocessor":1,"custbody_order_source_id":"FD50667","trandate":"03/10/2014","entity":342609,"item":[{"_attention1":"Nathan","_attention2":"Pelton","addr1":"18090 Shamrock Blvd","city":"Big Rapids","state":"MI","zip":49307,"country":"US","phone":2489461046,"description":"Orange Shadow Box Polaroid Picture 3.5 x 4.25","item":2526,"quantity":1,"rate":10.95,"subtotal":10.95,"custcol_produce_in_store":false,"custcol_store_pickup":false,"discounttotal":0},{"_attention1":"Nathan","_attention2":"Pelton","addr1":"18090 Shamrock Blvd","city":"Big Rapids","state":"MI","zip":49307,"country":"US","phone":2489461046,"description":"Green Shadow Box Polaroid Picture 3.5 x 4.25","item":2527,"quantity":1,"rate":10.95,"subtotal":10.95,"custcol_produce_in_store":false,"custcol_store_pickup":false,"discounttotal":0},{"_attention1":"Nathan","_attention2":"Pelton","addr1":"18090 Shamrock Blvd","city":"Big Rapids","state":"MI","zip":49307,"country":"US","phone":2489461046,"description":"Rustic Natural Shadow Box Polaroid Picture 3.5 x 4.25","item":3076,"quantity":1,"rate":15.95,"subtotal":15.95,"custcol_produce_in_store":false,"custcol_store_pickup":false,"discounttotal":0},{"_attention1":"Nathan","_attention2":"Pelton","addr1":"18090 Shamrock Blvd","city":"Big Rapids","state":"MI","zip":49307,"country":"US","phone":2489461046,"description":"3D Polaroid Picture 3.5 x 4.25","item":1141,"quantity":1,"rate":3,"subtotal":3,"custcol_produce_in_store":false,"custcol_store_pickup":false,"discounttotal":0},{"_attention1":"Nathan","_attention2":"Pelton","addr1":"18090 Shamrock Blvd","city":"Big Rapids","state":"MI","zip":49307,"country":"US","phone":2489461046,"description":"Polaroid 3.5 x 4.25","item":2892,"quantity":1,"rate":1,"subtotal":1,"custcol_produce_in_store":false,"custcol_store_pickup":false,"discounttotal":0},{"_attention1":"Nathan","_attention2":"Pelton","addr1":"18090 Shamrock Blvd","city":"Big Rapids","state":"MI","zip":49307,"country":"US","phone":2489461046,"description":"Polaroid 3.5 x 4.25","item":2892,"quantity":1,"rate":1,"subtotal":1,"custcol_produce_in_store":false,"custcol_store_pickup":false,"discounttotal":0}],"taxtotal":0,"taxrate":0,"shippingcost":7.95,"handlingcost":0,"discounttotal":0,"total":50.8,"pnrefnum":"3944777951920176056470","authcode":123456,"paymentmethod":5,"ccname":"Nathan Pelton","cczipcode":"33484","ccnumber":"4111111111111111","ccexpiredate":"07/2017","shipdate":"03/13/2014"},"customer":{"entityid":342609,"custentity_customer_source":1,"custentity_customer_source_id":"F50000","firstname":"Nathan","lastname":"Pelton","email":"npelton@gmail.com","isperson":false,"companyname":"Pelton Solutions LLC","custentity_fotomail":"nathan50000+dev@myfotobar.com","addressbook":{"billing":{"addr1":"18090 Shamrock Blvd","city":"Big Rapids","state":"MI","zip":49307,"country":"US","phone":2489461046}},"_source":"Fotobar","addressee":""}}';
		
		
		//var_dump($aOutput);
		//die();

		$pdo = new PDO('mysql:host='.SYSTEM_DB_HOST.';dbname='.SYSTEM_DB_DATABASE, 'netsuite', SYSTEM_DB_PASS);
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
	
	