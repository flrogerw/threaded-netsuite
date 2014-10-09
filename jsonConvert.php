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

	$crap = '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';
	echo(  decrypt($crap) );
die();
	
	//$xxx = '{"order":{"_source":"Fotobar","location":1,"department":1,"leadsource":-6,"custbody_order_source":1,"ccprocessor":1,"custbody_order_source_id":"FD50750","trandate":"06\/10\/2014","entity":342609,"item":[{"addr1":"18090 Shamrock Blvd","city":"Big Rapids","state":"MI","zip":49307,"country":"US","phone":2489461046,"shipmethod":1011,"description":"Polaroid 3.5 x 4.25","item":3078,"quantity":6,"rate":1,"subtotal":6,"custcol_produce_in_store":false,"custcol_store_pickup":false,"discounttotal":0,"location":1,"attention":"Nathan Pelton","addressee":"Successories","isresidential":false}],"taxtotal":0,"taxrate":0,"shippingcost":3.95,"handlingcost":0,"discounttotal":0,"total":9.95,"pnrefnum":"4024107989410176056442","authcode":123456,"paymentmethod":5,"ccname":"Nathan Pelton","ccnumber":"4111111111111111","_gcamount":0,"ismultishipto":true,"ccexpiredate":"05\/2016","cczipcode":49307,"shipdate":"06\/13\/2014","customform":107,"addressbook":{"billing":{"companyname":"Successories","addr1":"18091 Shamrock Blvd","city":"Big Rapids","state":"MI","zip":49307,"country":"US","phone":2489461046,"addressee":"Successories","isresidential":false}},"custbody_web_discount_code":""},"customer":{"custentity_customer_source":1,"custentity_customer_source_id":"F50000","firstname":"Nathan","lastname":"Pelton","email":"npelton@gmail.com","isperson":false,"companyname":"Pelton Solutions LLC","custentity_fotomail":"nathan50000+dev@myfotobar.com","_source":"Fotobar","custentitycustomer_department":1,"entityid":342609}}';
$xxx = '{"order":{"_source":"Fotobar Store 18","location":9,"department":8,"leadsource":2,"custbody_order_source":28,"ccprocessor":1,"custbody_order_source_id":"F105543","trandate":"06\/17\/2014","item":[{"addr1":"Polaroid Fotobar","addr2":"3545 Las Vegas Boulevard South #L7","city":"Las Vegas","state":"NV","zip":89109,"country":"US","phone":"702-734-0227","shipmethod":10,"description":"Polaroid 3.5 x 4.25","item":1137,"quantity":6,"rate":1,"subtotal":6,"custcol_produce_in_store":true,"custcol_store_pickup":false,"discounttotal":0,"location":9,"attention":"Polaroid Fotobar","addressee":"Polaroid Fotobar","province":""}],"taxtotal":0.49,"taxrate":8.1,"shippingcost":0,"handlingcost":0,"discounttotal":0,"total":6.49,"pnrefnum":false,"paymentmethod":8,"_gcamount":0,"ismultishipto":false,"shipaddress":"Polaroid Fotobar\nPolaroid Fotobar\nPolaroid Fotobar\n3545 Las Vegas Boulevard South #L7\nLas Vegas NV 89109","shipdate":"06\/20\/2014","customform":132,"custbody_web_discount_code":""},"customer":{"custentity_customer_source":3,"custentity_customer_source_id":"F97835","firstname":"Anonymous","lastname":"ahmad","email":"n.ahmad702@gmail.com","isperson":true,"custentity_fotomail":"hiimtheguywiththebeard97835@myfotobar.com","_source":"Fotobar Store 18","custentitycustomer_department":8}}';
	echo(  encrypt( json_encode(json_decode(  $xxx  ) ) ) );
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

