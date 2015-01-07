#!/usr/bin/php
<?php 
/**
 * 1
 * After hours of negotiating you finally convince me that lunch, while not a great idea, it isnt the end of the world.  Our first hurdle...
 * getting off property without being seen together.  We pour over reams of google map printouts and do miriads of reverse tri-anglation calculations
 * and finally agree to just pick me up on the corner.
 *    At first you could feel a small but understandable amount of aprehension in the conversation, but after a few jokes and a near miss with a bus, we both settle
 *    in for an hour of uninterupted time together away from prying eyes. After just a few minuets of driving, I direct you to a small parking lot across from our destination and instruct you to park.
 *    As we begin to cross the street I see a car coming towards us, I instinctly reach out and grab your hand and lead you to safety. As the car passes
 *    you comment on how that would have been a perfect oportunity to get rid of you.  to which I reply, i like manual strangulation."it is more personal".
 *    we are still lauging when we reach the door where we realize we are still holdng hands.  With a resounding "EWWWWWW" you pull it back and wipe it on your jeans.
 *    I laugh and open the door for you.
 *    
 *    2
 *    Once inside, we wander around commenting and wise cracking at the wide variety of crap they sell.  After some debate, we settle on a couple of slices of pizza and water.
 *    we find a table outside and settle in.  As I finish my first sip of water, I explain my phobia for eating in front of strangers and you laugh and take a huge bite off your slice and
 *    chew with your mouth open. We laugh and find ourself caught in an awkward extended stare.  This was just the first of several we would have during lunch.
 *    So many so we hear the people at the next table comment on 'How cute it is'.  We realize the time and get up to leave, I offer you my hand and you refuse, laughing "Not this time sailor'.
 *    
 *    3
 *    We spend the ride back patting ourselves one the back for not ending up in the back seat and re affirming one another that we can pull this off.  we laugh at the old lady in the check out lane
 *    at the market that had the shit stains in her shorts that we didnt think the other one had seen.  You tell me a little about 'him' and I tell you about 'her' and before we knew it you were pulling over
 *    to drop me off at the corner.  As I jump out I remind you that this is a one time thing and we have our last 'uncomfortable stare'.  As you pull off, you nearly side swipe a car driving by.  I laugh and
 *    remind myself to tease you about it later.
 * 
 * 
 */
require_once( __DIR__ . DIRECTORY_SEPARATOR . 'Configure.php' );

$xxx = 'nx3arHBVbhV2elo6n7cdf46hqZw+di9SKB7KIWI/3fIcHnt2nct1bT4rX2uvEPpzlV7Agzj9Zgv+QB8Ir7mPBu1gCbbgeV+r7Tc9xy4uXRUYAAwIkNvd7bEb4jIzQnUWfA3L+OofUBdog7gwGnhtANL6njySGchuN3Fg9NfABmGht9L/cM9EQV4vz/HmO+qyEcslcXPlHR1qvhQ6Gu6JFD3FzOWTlFuYQ+jjuZ/er0Teg1P9+PFYpA84NH50Qsj4KXjkjjrQZkMCt+kLRPOE31yEo3fvpYQtrH55NLFWL5cay1RZ+qQZnBE7rGDEy57D0/pwNMCltVJH1i2Ho3zyJA1eq6iJkrtQSgCrYClktJP7BPmutLnYQLA8f9XXMS8TcJaekjtZY33+rcSdJyvn9gCsH7L5I+FL9eBPueqZmU6Cm/bLjzEVKDC8DzIJJsJOKj1NRv7hEAd4uzzv297u4emZdHzgXcy+AdIeZ3xhv0dGldHXRfWdAGmTmBoPRF6wE1YyzSRPMMqwGdp4BgeuL09kVc61ezjXv3xhk+s/1QomVInEpOm4pQZryFMOXttSTOavWahxy5FdJYhvKW/ljkXsXFsIeeSoMRJpUT/t3pIa1jG1AhcM9eC2bbG0kU9Vi2qTCqrDt6AO+LdJQ90vE/GHzwTNkv0J6kVKp3Wru4q8FJ4WWTbPmnP58aQ9I6WA6+ogT8hR8Idzg9cT7+plNAVJuoOEuG+Km2QOcHQMeIP2hwvo0EGfO63DslOEODzKd9MLy5TRcerZt7KXAn/Uy/9pXcutcSEB/alj6VEhP10YbjviIF/lGsqe7xYAWC2/D1Ob+y+Rx1huuZsNrHf3vHRhs5wrr/w46BG/2oY2tr84A66RDz+YhzLo5f0aJrhe+6xNrWe1BKrS1/j+pfjIrExqj5wpwSH9C0/2I1Dl+z2ts8RL1ln/myB4Doi1AZDxmwZXJzv3vta7+6l7nXuDno9Vp+LyBehppdrRAGoc2s8FEMHcQZCNfZWJq47a9+p0t0rTo+MP/vme7hSBuF9bw6BHj8sTSuopGFxHbIoimiQKq8kyrRpxj5889qlb62Wt0Ouxg4Dhnx3lgvUot8T5lYenx6o2T/IL3NxAmgLYJwY3GfQEzIbIgbkPxq4ecZUPhdNSN9JPmJsXDdUIvw9BJ0tGKVrf6zfk9HttmZhIg1ZCdrxTKMcM6sGNPBjD8hg/YvCSovE+fraKHaiN7sDo5v/JKgxr35HbYQDL+NaMrMPbU7Ykj6LVwZlX/ytY6EkFw/H5bW24Ni7MDtNxctwrXoencxuDpyag/M3QqUE07OP6TplneBJAVB5p+aTzqPLrgmf3tNyZO90yDY+DF/FNwHvAbGciUBUGH7bi9smiOVSgkvgWIqtYlh2t6b9jx2r6F9nIosjFTNjpY8WoQzKZVjc8+KftJv4gRJndNwStkNB/unaP4wWKoB2ZWyM3sHKMO+UG5KqJnjv4gybdjJK0hrm+5+56vQEfvd7nPaWF5z+/bYasZsM8gFM6LJwYaKFIKoLXRg4bke6HY3Vk5nkuy01ZA5WPXRcs2wok6XK0btGMOyMj8fuJs0l27Kdawb49gKN8v/Q8Ajn2RW59hWBDu0rSjrrkvF4NVO+933CtG1GLnX3atqtSDEJmWTVoBq3IoCm8BHPd+ImtwO8MN1Iccn3AZvKD4LXV8zvHYErRnfpKqiJmKCw+tAE+fUC1rV1O8v5zEBOJdqfQKsolyfVQL/bFsJ9ZJLAGJj2LeaDkFk5qFus9LkmGPARBWSDJ24WTBL5b38v9mlm1PiniGQIKAWG/OTdXH91LNwkDYnTWZH3CKyqBZPJjoKSYXu6xkbdcIfrC5bPKMcksp2NxY5AQmIr6V1ouPR3b8UQRiJW4HYYDQ8kE3VcC6IUSTYz9GauqZRMVFkRWndTZQLUS5XXrJQ==';
echo(  decrypt(   $xxx  ) );


//$xxx = '{"order":{"_source":"Fotobar","location":1,"department":1,"leadsource":-6,"custbody_order_source":1,"ccprocessor":1,"custbody_order_source_id":"F170426","trandate":"12\/16\/2014","item":[{"addr1":"21411 partha way","city":"Houston","state":"TX","zip":77073,"country":"US","phone":9132212549,"shipmethod":1011,"description":"Clothesline Frame with Clips","item":318,"_fulfilled_by":"0","quantity":1,"custcol_page_count":1,"rate":50,"subtotal":50,"custcol_produce_in_store":false,"custcol_store_pickup":false,"discounttotal":0,"location":1,"attention":"Gia Beaver","addressee":"\'Cake\' by Gia Genea","isresidential":false},{"addr1":"21411 partha way","city":"Houston","state":"TX","zip":77073,"country":"US","phone":9132212549,"shipmethod":1011,"description":"Polaroid 3.5 x 4.25","item":1150,"_fulfilled_by":10,"quantity":19,"custcol_page_count":19,"custcol_image_url":"http:\/\/www.polaroidfotobar.com\/pdf\/170426\/1042956\/5ad214d3\/1042956.pdf","rate":1,"subtotal":19,"custcol_produce_in_store":false,"custcol_store_pickup":false,"discounttotal":0,"location":10,"attention":"Gia Beaver","addressee":"\'Cake\' by Gia Genea","isresidential":false}],"taxtotal":"0.00","taxrate":"0","shippingcost":14.95,"handlingcost":"0","discounttotal":"0","total":83.95,"pnrefnum":"4187563090670176327037","authcode":810200,"paymentmethod":4,"ccname":"Gia Beaver","ccnumber":"5581588946234317","_gcamount":"0","ismultishipto":false,"shipmethod":1011,"shipaddress":"Gia Beaver\n\'Cake\' by Gia Genea\n21411 partha way\nHouston TX 77073","ccexpiredate":"07\/2015","cczipcode":77073,"shipdate":"12\/19\/2014","customform":107,"billaddress":"\'Cake\' by Gia Genea\n\'Cake\' by Gia Genea\n21411 partha way\nHouston TX 77073","custbody_web_discount_code":""},"customer":{"custentity_customer_source":1,"custentity_customer_source_id":"F151944","firstname":"Gia","lastname":"Beaver","email":"Gia.Genea@gmail.com","isperson":true,"custentity_fotomail":"gia151944@myfotobar.com","addressbook":{"billing":{"companyname":"\'Cake\' by Gia Genea","addr1":"21411 partha way","city":"Houston","state":"TX","zip":77073,"country":"US","phone":9132212549,"addressee":"\'Cake\' by Gia Genea","isresidential":false}},"_source":"Fotobar","custentitycustomer_department":1}}';
//echo( encrypt($xxx));
die();

try{

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

