<?php 

require_once( __DIR__ . DIRECTORY_SEPARATOR . 'Configure.php' );
#dsfsdfsdfsdfsdf





//$good = '{"ccapproved":"T","custbody_order_source":"28","custbody_order_source_id":"F85562","custbody_textrequired":"F","customform":129,"department":8,"discountrate":0,"discounttotal":0,"entity":527685,"getauth":"F","handlingcost":0,"ismultishipto":"F","istaxable":"T","leadsource":2,"location":9,"paymentmethod":8,"recordtype":"salesorder","shipaddress":"Polaroid Fotobar\nPolaroid Fotobar\nPolaroid Fotobar\n3545 Las Vegas Boulevard South #L7\nLas Vegas NV 89109","shipdate":"05\/05\/2014","tobeemailed":"F","tobeprinted":"F","trandate":"04\/30\/2014","item":[{"addressee":"Polaroid Fotobar","addr1":"Polaroid Fotobar","addr2":"3545 Las Vegas Boulevard South #L7","amount":10,"attention":"Polaroid Fotobar","city":"Las Vegas","country":"US","custcol_produce_in_store":"T","custcol_store_pickup":"F","custcol162":"","description":"Polaroid 9 x 11","discountitem":"F","discounttotal":0,"isclosed":"F","isestimate":"F","istaxable":"T","item":1136,"location":"9","phone":"702-734-0227","price":-1,"quantity":1,"rate":10,"shipmethod":"10","state":"NV","zip":"89109"},{"addressee":"Polaroid Fotobar","addr1":"Polaroid Fotobar","addr2":"3545 Las Vegas Boulevard South #L7","amount":6,"attention":"Polaroid Fotobar","city":"Las Vegas","country":"US","custcol_produce_in_store":"T","custcol_store_pickup":"F","custcol162":"","description":"Polaroid 3.5 x 4.25","discountitem":"F","discounttotal":0,"isclosed":"F","isestimate":"F","istaxable":"T","item":1137,"location":"9","phone":"702-734-0227","price":-1,"quantity":6,"rate":1,"shipmethod":"10","state":"NV","zip":"89109"}],"giftcertificateitem":null}';
//$bad =  '{"ccapproved":"T","custbody_order_source":"28","custbody_order_source_id":"F85541","custbody_textrequired":"F","customform":129,"department":8,"discountrate":0,"discounttotal":0,"entity":800285,"getauth":"F","handlingcost":0,"ismultishipto":"F","istaxable":"T","leadsource":2,"location":9,"paymentmethod":8,"recordtype":"salesorder","shipaddress":"Polaroid Fotobar\nPolaroid Fotobar\nPolaroid Fotobar\n3545 Las Vegas Boulevard South #L7\nLas Vegas NV 89109","shipdate":"05\/02\/2014","tobeemailed":"F","tobeprinted":"F","trandate":"04\/29\/2014","item":[{"addressee":"Polaroid Fotobar","addr1":"Polaroid Fotobar","addr2":"3545 Las Vegas Boulevard South #L7","amount":35,"attention":"Polaroid Fotobar","city":"Las Vegas","country":"US","custcol_produce_in_store":"T","custcol_store_pickup":"F","custcol162":"","description":"Black Shadowbox Polaroid 9 x 11","discountitem":"F","discounttotal":0,"isclosed":"F","isestimate":"F","istaxable":"T","item":2535,"location":"9","phone":"702-734-0227","price":-1,"quantity":1,"rate":35,"shipmethod":"10","state":"NV","zip":"89109"}],"giftcertificateitem":null}';
//$bad2 = '{"ccapproved":"T","custbody_order_source":"28","custbody_order_source_id":"F85525","custbody_textrequired":"F","customform":129,"department":8,"discountrate":0,"discounttotal":0,"entity":799287,"getauth":"F","handlingcost":0,"ismultishipto":"F","istaxable":"T","leadsource":2,"location":9,"paymentmethod":8,"recordtype":"salesorder","shipaddress":"Polaroid Fotobar\nPolaroid Fotobar\nPolaroid Fotobar\n3545 Las Vegas Boulevard South #L7\nLas Vegas NV 89109","shipdate":"05\/02\/2014","tobeemailed":"F","tobeprinted":"F","trandate":"04\/29\/2014","item":[{"addressee":"Polaroid Fotobar","addr1":"Polaroid Fotobar","addr2":"3545 Las Vegas Boulevard South #L7","amount":6,"attention":"Polaroid Fotobar","city":"Las Vegas","country":"US","custcol_produce_in_store":"T","custcol_store_pickup":"F","custcol162":"","description":"3D Polaroid 3.5 x 4.25","discountitem":"F","discounttotal":0,"isclosed":"F","isestimate":"F","istaxable":"T","item":1141,"location":"9","phone":"702-734-0227","price":-1,"quantity":2,"rate":3,"shipmethod":"10","state":"NV","zip":"89109"},{"addressee":"Polaroid Fotobar","addr1":"Polaroid Fotobar","addr2":"3545 Las Vegas Boulevard South #L7","amount":9,"attention":"Polaroid Fotobar","city":"Las Vegas","country":"US","custcol_produce_in_store":"T","custcol_store_pickup":"F","custcol162":"","description":"3D Polaroid 3.5 x 4.25","discountitem":"F","discounttotal":0,"isclosed":"F","isestimate":"F","istaxable":"T","item":1141,"location":"9","phone":"702-734-0227","price":-1,"quantity":3,"rate":3,"shipmethod":"10","state":"NV","zip":"89109"},{"addressee":"Polaroid Fotobar","addr1":"Polaroid Fotobar","addr2":"3545 Las Vegas Boulevard South #L7","amount":12,"attention":"Polaroid Fotobar","city":"Las Vegas","country":"US","custcol_produce_in_store":"T","custcol_store_pickup":"F","custcol162":"","description":"Polaroid 3.5 x 4.25","discountitem":"F","discounttotal":0,"isclosed":"F","isestimate":"F","istaxable":"T","item":1137,"location":"9","phone":"702-734-0227","price":-1,"quantity":12,"rate":1,"shipmethod":"10","state":"NV","zip":"89109"}],"giftcertificateitem":null}';

try {

	/*
		$file_handle = fopen( APPLICATION_DIR . 'TestOrders/POS_TEST.csv', "r");
	while (!feof($file_handle)) {
	$aOutput[] = fgets($file_handle);
	}
	fclose($file_handle);
	$sJson = OrderJSON::convert( $aOutput );
	*/

	//$sJson ='{"order":{"_source":"Fotobar","location":1,"department":1,"leadsource":-6,"custbody_order_source":1,"ccprocessor":1,"custbody_order_source_id":"FD50689","trandate":"04\/01\/2014","entity":342609,"item":[{"attention":"Nathan Pelton","addressee":"Pelton Solutions LLC","addr1":"18090 Shamrock Blvd","city":"Big Rapids","state":"MI","zip":49307,"country":"US","phone":2489461046,"shipmethod":1011,"description":"GC50","item":1119,"quantity":1,"rate":50,"subtotal":50,"custcol_produce_in_store":true,"custcol_store_pickup":true,"discounttotal":0,"giftcertnumber":"TEST'.rand(10000,90000).'","giftcertfrom":"Nathan","giftcertrecipientname":"Nathan","giftcertrecipientemail":"npelton@gmail.com","giftcertmessage":"testing","location":1}],"taxtotal":0,"taxrate":0,"shippingcost":0,"handlingcost":0,"discounttotal":0,"total":50,"pnrefnum":"3963828264610176056428","authcode":123456,"paymentmethod":5,"ccname":"Nathan Pelton","ccnumber":"4111111111111111","ccexpiredate":"06\/2018","cczipcode":49307,"shipdate":"04\/04\/2014","customform":107,"ismultishipto":true,"custbody_web_discount_code":""},"customer":{"custentity_customer_source":1,"custentity_customer_source_id":"F50000","firstname":"Nathan","lastname":"Pelton","email":"npelton@gmail.com","isperson":false,"companyname":"Pelton Solutions LLC","custentity_fotomail":"nathan50000+dev@myfotobar.com","addressbook":{"billing":{"addr1":"18090 Shamrock Blvd","city":"Big Rapids","state":"MI","zip":49307,"country":"US","phone":2489461046}},"_source":"Fotobar","custentitycustomer_department":1,"entityid":342609}}';

	//$sJson = '{"order":{"_source":"Fotobar Store 1","location":2,"department":2,"leadsource":2,"custbody_order_source":28,"ccprocessor":1,"custbody_order_source_id":"FD50693","trandate":"04\/08\/2014","entity":342609,"item":[{"addr1":"645 Elmcroft Blvd #13406","city":"Rockville","state":"MD","zip":20850,"country":"US","phone":2489461046,"shipmethod":1011,"description":"Black Shadowbox Polaroid 9 x 11","item":2536,"custcol162":"","quantity":1,"rate":35,"subtotal":35,"custcol_produce_in_store":true,"custcol_store_pickup":false,"discounttotal":0,"location":1,"attention":"Nathan Pelton","addressee":"Shipping Company Name","isresidential":false},{"addr1":"1040 Holland Dr.","city":"Boca Raton","state":"FL","zip":33487,"country":"US","phone":5612264355,"shipmethod":10,"description":"Polaroid 3.5 x 4.25","item":1137,"custcol162":"","quantity":6,"rate":1,"subtotal":6,"custcol_produce_in_store":true,"custcol_store_pickup":false,"discounttotal":false,"location":2,"attention":"Polaroid Fotobar","addressee":"Polaroid Fotobar","addr2":null,"province":""}],"taxtotal":0.36,"taxrate":6,"shippingcost":0,"handlingcost":0,"discounttotal":0,"total":49.31,"pnrefnum":false,"paymentmethod":"","_gcamount":0,"shipdate":"04\/11\/2014","customform":129,"ismultishipto":true,"custbody_web_discount_code":""},"customer":{"custentity_customer_source":3,"custentity_customer_source_id":"F50000","firstname":"Nathan","lastname":"Pelton","email":"npelton@gmail.com","isperson":false,"companyname":"Pelton Solutions LLC","custentity_fotomail":"nathan50000+dev@myfotobar.com","_source":"Fotobar Store 1","custentitycustomer_department":2,"entityid":342609}}';
$aCrap = '{"order":{"_source":"Fotobar Store 1","location":2,"department":2,"leadsource":2,"custbody_order_source":28,"ccprocessor":1,"custbody_order_source_id":"FD50749","trandate":"06\/05\/2014","entity":342609,"item":[{"addr1":"1040 Holland Dr.","city":"Boca Raton","state":"FL","zip":"33487","country":"US","phone":"5612264355","shipmethod":10,"description":"Polaroid 3.5 x 4.25","item":1137,"quantity":6,"rate":1,"subtotal":6,"custcol_produce_in_store":true,"custcol_store_pickup":false,"discounttotal":0,"location":2,"attention":"Polaroid Fotobar","addressee":"Polaroid Fotobar","addr2":"","province":""}],"taxtotal":0.36,"taxrate":6,"shippingcost":0,"handlingcost":0,"discounttotal":0,"total":6.36,"pnrefnum":false,"paymentmethod":8,"_gcamount":0,"ismultishipto":false,"addressbook":{"shipping":{"attention":"Polaroid Fotobar","addressee":"Polaroid Fotobar","addr1":"1040 Holland Dr.","addr2":"","city":"Boca Raton","state":"FL","province":"","zip":"33487","country":"US","phone":"5612264355"}},"shipaddress":"Polaroid Fotobar\nPolaroid Fotobar\n1040 Holland Dr.\nBoca Raton FL 33487","shipdate":"06\/10\/2014","customform":129,"custbody_web_discount_code":""},"customer":{"custentity_customer_source":3,"custentity_customer_source_id":"F50000","firstname":"Nathan","lastname":"Pelton","email":"npelton@gmail.com","isperson":false,"companyname":"Pelton Solutions LLC","custentity_fotomail":"nathan50000+dev@myfotobar.com","_source":"Fotobar Store 1","custentitycustomer_department":2,"entityid":342609}}';
echo( encrypt(json_encode(json_decode( $aCrap, true )) ));	
	$crap="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";
//echo(  decrypt($crap) );
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

