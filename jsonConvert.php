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

	$crap ='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';
	echo(  decrypt($crap) );
	
	//$xxx = '{"order":{"_source":"Fotobar","location":1,"department":1,"leadsource":-6,"custbody_order_source":1,"ccprocessor":1,"custbody_order_source_id":"FD50750","trandate":"06\/10\/2014","entity":342609,"item":[{"addr1":"18090 Shamrock Blvd","city":"Big Rapids","state":"MI","zip":49307,"country":"US","phone":2489461046,"shipmethod":1011,"description":"Polaroid 3.5 x 4.25","item":3078,"quantity":6,"rate":1,"subtotal":6,"custcol_produce_in_store":false,"custcol_store_pickup":false,"discounttotal":0,"location":1,"attention":"Nathan Pelton","addressee":"Successories","isresidential":false}],"taxtotal":0,"taxrate":0,"shippingcost":3.95,"handlingcost":0,"discounttotal":0,"total":9.95,"pnrefnum":"4024107989410176056442","authcode":123456,"paymentmethod":5,"ccname":"Nathan Pelton","ccnumber":"4111111111111111","_gcamount":0,"ismultishipto":true,"ccexpiredate":"05\/2016","cczipcode":49307,"shipdate":"06\/13\/2014","customform":107,"addressbook":{"billing":{"companyname":"Successories","addr1":"18091 Shamrock Blvd","city":"Big Rapids","state":"MI","zip":49307,"country":"US","phone":2489461046,"addressee":"Successories","isresidential":false}},"custbody_web_discount_code":""},"customer":{"custentity_customer_source":1,"custentity_customer_source_id":"F50000","firstname":"Nathan","lastname":"Pelton","email":"npelton@gmail.com","isperson":false,"companyname":"Pelton Solutions LLC","custentity_fotomail":"nathan50000+dev@myfotobar.com","_source":"Fotobar","custentitycustomer_department":1,"entityid":342609}}';

	//echo(  encrypt( json_encode(json_decode(  $xxx  ) ) ) );
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
	$stmt->execute( array('customer_activa_id' => "F".rand(10000,90000), ':order_activa_id' => "FD".rand(10000,90000), ':order_json' => encrypt( $sJson ) ) );

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

