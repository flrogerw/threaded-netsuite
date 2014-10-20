#!/usr/bin/php
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


$crap = 'nx3arHBVbhV2elo6n7cdfxtP4agsbAatrt7wMlaF6Py9XSWMvYatcrzrzwfy6xK2IDXZjbTvZ15Ljqect9Lh6D4/JlwlXBWWMy8T6jIbeUFOXJCAxVwyVWonKVjVzY8IviIX3+FJnF+8EuqW68g67NXmItDBKy+n4staotJVWgiikV6e/2Vif9MH7YCkl06UTg9MhRrOsv9iET2YAAv/ksu1bxinnGeSV5OqbL4wHmJDzUEvUEi9oyUdSd7GmlRxZMe8XHNfiOQio5P/3d/APjNcB9n5JoT+bWrZbrQgSC3BtlxPmwgEOT9QefAU2xMPbm9U6zICQ47R77EsZ/ag4xZu3v/bAJKJk/0KBomLvt6HwEHQqgoxJnhGSm9C013173/H6g1tDO/sY0zEqedR2q3VFesSsmptit4EzjEoxdVRJ5QBHR6BU22y5kEptJ8cl16ycmrVPEZb+YOuHtMea+QEQeBFwzj2aSAVdMgeJuagvsgzZzYkdsqr8v+pkWwAL65bSSh/wgRGPFrkZuv7TSxRUO127LXiR0Zp3hxF90HjukrY0hKmSWjTLreD9KGLZel/nRx3C22BGLWKwVqx9C3gdGmL9AX6MrlElCqaQ9QF+KDam1rvmeebqx9xczxGjvVW6M0tPZFdeV6rbtJWVXLXFy18d+GdmdpC00Sz++cXbqPFzdCTOPdeYSCci0vlE7ooJWG4g5CJGbiosidR1wTrFR3oBmBCE+AnVem36QqzwYudfxUAAuWZ4wB7amLK7bOSLYX5laQT5Fyy3/EQzlj+UANhELFDrxoLyX4oozqA8DdN837MTFVwaep17K3CMXfj8ADt4z7e1n/8nLCd7zVv5dTIO8C0p9KNY/c8UETKGHAvC3fS2zLuVEesBjYYQI/benWPu/AEWEHf7N3Pmlplp65H9naSO1Gv26uIrIMinuS6Bc/5mNuNvpy/hFQvlHex3D2Xu50ibPgRBc66pC3WDEXP4A2vIRiG6iZR/J3W0CeheoaEcip40AR2Ph4Ad3ffd8pxo7LZGRuvVvE7q3jATNeD5tlGrkpjk4hS+TyIVhd4uwWB1yBfw146T7IwCVz2Wo8xwO11mNU+tO0VnJRbFT0saV1Y1M0ITkE/A5suAWMaUicC8tqzzYCzpMtcz+NCJTYXne/YNh07rO84nC3mlIz4SfLUW2mhupHydDhf5zDqxqrAlY8mKMf28fb1fobqKNbt5BmntKquu+LGA1ma6Typz+zLbbfvdIVOE3USism90MLCnJS4/lZ05XFS9caGcbO1AsdmvqnRdA/fEXErl7LhS2FcTNCSSPI43vIP/elDv1PK4Xe/jRSZCK5H9EZIpV/Xqq/u09d8BAOaQ4mpdx8isk+x0Vroqv3YjaAkeOfkiOwALH4cOx+g74PUK2ULVwukrwUcFypfmruHyZvLBHzCUZlbRR5Wn4EoU4zEQs6Glr0qO+fW1f+qKcfaZPZPs5Np9co/4uqI8vNvYK03KV+vXLB3VQIVXVPo1U+5fq3kGeeSBILP3PgXXFLgHri4V0AH377P4Piw/FLi1rpFdEpM3XRuUbLaLkG8zCiGXeWRuDHbnIp4tJ/0WbI5H/p/o2EfVxhnYLpnRk5qONijuy3yHe2d/ntvj4/O9hTyA8yqQpGEr8dIA67k95NOtob/oY3qfDmzgzUf5M0tLiFGOHuu/lS7gabh/4I1OQiEF5tswtPif+1KpZzrU1wm+JHpjPkoGLA47ftI47QceEgD3RQTBNWqOQeUFIqA7w6fYfksIPM7S7tRESt5l41AmahKnBa/JXlH0CuEvDjDmWL/jed/BnPdPkyMDz0bR91Zhz3ux3XfDvU10t8kWAMcw+kmgSTBkzw9qhZYQhDWzHnYEvogFyi389k1STpm/Kk/LTyg5c03s/6fG+eXDe3wY2iGZ7cnTn6rBhWUR2+zMg==';

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

