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


//echo($sJson = decrypt('nx3arHBVbhV2elo6n7cdf46hqZw+di9SKB7KIWI/3fJ8Y+XiT7jJQi3nGJkt638aGMqc05737nwmcEzk92/FQ+wR6msIKMwlL8L2XCwDwKQYAAwIkNvd7bEb4jIzQnUWfA3L+OofUBdog7gwGnhtANL6njySGchuN3Fg9NfABmGht9L/cM9EQV4vz/HmO+qyW6bQh9hInNM520eKkFKzOatxpm3LwzJenTayl6Qykx1JxIpIG1Z3a2YFhtLOHpv6ftJ+BTd+DGWF8RvIX612z/1pPGLb09LSxpfJYwJq74fKDt9FxULAEZtHbLvqt6IfaZlu0g8Bfvjp5UEmpp8pMzsPO1pFbKGtfcHmuoWkwUfE3tcCXYCfXbriD4iabt9pH162FYXhL5/AomQ6O8PYOkOrhmD07dDjOTzZy/nQCUjT+VD08BZC8jUnNODSTPLZUSeUAR0egVNtsuZBKbSfHHvdPQtx4QWJFKrjlKCvH8y8PDGSCE2SI3jVfO1PW2aOji3a5sDFU3tFMjiodPVOFwbhJpTkladeGm4eyySSe+MsZkKf5qhNmjZtLMieDSIohWWrLhpzWsR35Ipa5YhEkQg1to3n53BqIglTdvjoOtWyiZKfHLiGH1oNXB4s5kKey6eFJXNdIIW1Uq1VsZlzTiqEdALE+3GSXAR832o1yD+DyuCpl/8j71mypb4xj+mS/3ILBR4qKg6b3xTqKAneYYCk+O2YXa3XByZN5SpdLCuNClYM5fcsRS0hPtO+I0EHPs3Wv+PzumwNTaKusMBan9OcchtythQYfGtOTg6lo+2TCdefAtuBbTDr+44tj5h6I3K0MLoB/ISj61V9P7MZjlUfK7woJ0OLusLBC4LUJYQ1jV0Oglz71nG8Euh0xQLwdxaXzJHD3PUEOYoCbYDkX2rXOiUPklf/QIC+ROZ2dAXEC5yOYt1fhWOsYMIfDUgPtEN+gQrfvDOk4Zltz34Qozq9csmUkkUy2uhnP7InvD03bgsEOEaG/pxI2k2NGawJPVvJ+jhs0mJIJ6K27UTMkpw09fYOEoiuXYW68CJ5fAsra6a52H8xYFjMyVLcXJnocHGEAjFHTE0I95fWoNm3b8QpFv/zZ73qi+lkI1iBYuRAaVdVfu41GFLqgGfQyfKnRK0Q8H1Kj+X/eKfKTxtARijxvRWiMK59vJieGITI4y0wMVXC7LnpbahmKRMe/bkERiC1U22Y+KYby9J/tGwmzrZOz/jMVK0Asv7S3W6CfhD5LsIy2aoO/ajXVwNkCe6ix/NOix+mH5j90CvXGOEe5KMDtL7qGKU0GPB3QH7Mb0x63R7LluI07wihKgqy18vHhCNh5E3Q7g3MiBz2BehgjfIOT4nlauKRP30bI25c81WPn+4AED08gqWx8uG1hO/j4JA5pemhF0f/gXr2ZRke87NHw6oFVTM2rMhURq8NtenGuiMsLE5TLU/V2JEUBlXiD+OQuLoJ1lDfcQflpGBd/I6hqZw+di9SKB7KIWI/3fIyJuzoLaX6ahCHJBY+Nftac07z9beM3b0dHPvxzbMcRGL70cjhb78Nc8AsgguOLsmChPyWasDgD1v8xhNF+pFK'));
//echo(encrypt('{"order":{"_source":"Fotobar Store 18","location":9,"department":8,"leadsource":2,"custbody_order_source":28,"ccprocessor":1,"custbody_order_source_id":"F86339","trandate":"05\/02\/2014","entity":342609,"item":[{"addr1":"218 Mt. Lebanon Blvd","city":"Pittsburgh","state":"PA","zip":15234,"country":"US","phone":"412-657-7690","shipmethod":1011,"description":"3 Classic Polaroid Pictures 11x17 Black Wood Frame","item":2980,"quantity":1,"rate":37.95,"subtotal":37.95,"custcol_produce_in_store":false,"custcol_store_pickup":false,"discounttotal":-7.59,"discountitem":1164,"location":1,"attention":"Patricia Missenda","addressee":"Patricia Missenda"}],"taxtotal":0,"taxrate":0,"shippingcost":7.95,"handlingcost":0,"discounttotal":0,"total":38.31,"pnrefnum":false,"paymentmethod":8,"_gcamount":0,"ismultishipto":true,"shipdate":"05\/07\/2014","customform":129,"custbody_web_discount_code":"S4MOM"},"customer":{"custentity_customer_source":3,"custentity_customer_source_id":"F73032","firstname":"Tim","lastname":"Missenda","email":"tim.missenda@gmail.com","isperson":true,"custentity_fotomail":"tim73032@myfotobar.com","_source":"Fotobar Store 18","custentitycustomer_department":8,"entityid":342609}}'));
exit;



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

