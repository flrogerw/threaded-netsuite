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

	//$crap = 'nx3arHBVbhV2elo6n7cdf46hqZw+di9SKB7KIWI/3fJ8Y+XiT7jJQi3nGJkt638aGMqc05737nwmcEzk92/FQ+wR6msIKMwlL8L2XCwDwKQYAAwIkNvd7bEb4jIzQnUWfA3L+OofUBdog7gwGnhtANL6njySGchuN3Fg9NfABmGht9L/cM9EQV4vz/HmO+qyK4uJ1aagmULoIxhzZZo/4678y3PtmUqY2y/NV3cApdkjuQrUU1Jolk0M7QPd1mZD/sG6fU50xRlmeLQw5u/0mUKgU8Xmdyf7nTV3KsQ8bMYVmXBi5OepqWewQHt+pPKiOf8gpip0B2VXDJprkNzFt+1BkWvsXdVbV64RU9W0ganRRi3yB0poJiojSEtTZ75F9DzTHAf3rFd4yiqgp0yLDejC3xTW2gDvknYMfyZ1cef7BPmutLnYQLA8f9XXMS8TeIJlgt42P7p7PFb8rw3AOU0SgD8CE8kgXNdvyag9IyGYrXr1Vx5YhlVCCsEO+1qXRTaY6k7nQUYFbUXgj4oPlIKgZmu/XSH7mU0PBgEpgNdjQsoCgztM4toMJ83C4W2VpcLbK4WUg975X1/lbTWEBpMenYRgRnE4YN9F5BWfZ/dxpYLWl0dE/WM1uCC8l7F4d9MLy5TRcerZt7KXAn/Uy/9pXcutcSEB/alj6VEhP10YbjviIF/lGsqe7xYAWC2/o/lubnXurQ+slJy4TlqkytMG7K7JRT+vpnImt+VU3xMX9rQDf4gJT4D5ETRcAqPb7kye3sMvYEqatxeol2fFxLekOfIRFWMlAWjV+GYUuow0Bn7tnGFWRMm+XJogYyaC2/OW5AKPEPKSQgwzlGf5Z1clFoSxj0YFpe9QTHMSzdsxBfWUY9KRz4An/bgM7G6J+YdObeWiSiagAMPWw63+gukMzAAwMb/8hZRXVFqjCEp6eGAizq8L7E+69v2pnzknA2mpuv9gYUikXGwG7TVo2OL46b7X9CMfZZFLm52m4C7f8P+1PmQc0AyzC8+OtNNqmqwMkdCGMj50aI8jJnniVhpzyH/a3nVXSzqEmsJ6MRFZYmN+Hn7MwdNB00eabuQ6AgjSMb0xXPaygXA+/2Q43nD05yDGqOUkYy8fx35goBVDqoJpFQo1fqH0bYwNHqSXFkNbzWAYj23eTByiqkuDq2Otv5K/syrlNBc32/LdwQ6B55rpST9W3dBipJm76PFcHrzns1DATia9b+h8hmfQx0OTfhW62TsszoQEbx/IWMMVcxvc3dNY4W3aBM1mrNXUvUz6x4kQoZseyiPy4x07yG/wPjwvL3LbKLviUSiIJdsy7w7nwRn6xxmttdhjRDPR/IL311uTWR/N3P8/mfaAdAx5PfWQPZyP8E2pw24TPYiMOyMj8fuJs0l27Kdawb49fjTJ7/x/iTg6QbRn0uByq9vgEVTbP1HEqv5y8h93Rn35rLpvvwUU/9rUGGbhP4ADxlMbqkemKsUTtkhZ5ikiFDp9TnzegLov/J2XG2VZrKUQmJJ7zFI/r042G/trSHwi8xMh728902lq6QMiUoT0Q+To6e/ece0Noe+Ss/DTf03X15E0h1OsKbGa3Vtrzs6LztJXZPPNDkuHgG0GrY16BrCTDmuviKxti90X1FUcWZSvwrZwRBYq9VVuWCXd7N6MfFXa3QmJsRK4+XaSCvYRKyd/yO4oWZ8So5U5Gri1CbP9nvPd2lr/fJQw6zgEYbdS4Q7/V0GRSia/vwYTWIC06pW4+AuKg1TbtELrrjyfnR+39g2do/Qi9jZlLn1P2mKf';
	//echo(  decrypt($crap) );
	
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

