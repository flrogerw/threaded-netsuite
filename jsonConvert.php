#!/usr/bin/php
<?php 

require_once( __DIR__ . DIRECTORY_SEPARATOR . 'Configure.php' );
/*
$xxx = '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';
echo(  decrypt(   $xxx  ) );

die();


$xxx = '{"order":{"_source":"Fotobar Store 2","location":2,"department":2,"leadsource":2,"custbody_order_source":28,"ccprocessor":1,"custbody_order_source_id":"F200083","trandate":"02\/05\/2015","entity":451779,"item":[{"addr1":"Polaroid Fotobar - F200083","addr2":"14851 Lyons Road #100","city":"Delray Beach","state":"FL","zip":33446,"country":"US","phone":"561-212-7752","shipmethod":2889,"description":"8\"x8\" Metal Print with easel","item":3211,"_fulfilled_by":"0","custcol162":1,"quantity":1,"custcol_page_count":1,"custcol_image_url":"http:\/\/www.polaroidfotobar.com\/pdf\/200083\/1280899\/174dda2c\/1280899.pdf","rate":35,"subtotal":35,"custcol_produce_in_store":false,"custcol_store_pickup":true,"discounttotal":0,"custbody_comments":"Image Quality: Low - 75","location":1,"attention":"Francis Donahue","addressee":"Francis Donahue"}],"taxtotal":2.1,"taxrate":6,"shippingcost":"0.00","handlingcost":"0","discounttotal":"0","total":37.1,"pnrefnum":false,"paymentmethod":"","_gcamount":"0","ismultishipto":true,"billaddress":"Francis Donahue\nFrancis Donahue\nPolaroid Fotobar - F200083\n14851 Lyons Road #100\nDelray Beach FL 33446","shipaddress":"Francis Donahue\nFrancis Donahue\nPolaroid Fotobar - F200083\n14851 Lyons Road #100\nDelray Beach FL 33446","shipdate":"02\/10\/2015","customform":129,"custbody_web_discount_code":""},"customer":{"custentity_customer_source":3,"custentity_customer_source_id":"F49382","firstname":"J","lastname":"Smith","email":"pcustomers@yahoo.com","isperson":true,"custentity_fotomail":"j49382@myfotobar.com","_source":"Fotobar Store 2","custentitycustomer_department":2,"entityid":451779}}';


var_dump(json_decode($xxx));

die();
*/
$xxx = '{"order":{"_source":"Fotobar","location":1,"department":1,"leadsource":-6,"custbody_order_source":1,"ccprocessor":1,"custbody_order_source_id":"F238089","trandate":"03\/21\/2015","item":[{"addr1":"415 oak knoll dr.","city":"manalapan","state":"NJ","zip":"07726","country":"US","phone":7324460747,"shipmethod":1011,"description":"Rustic Natural Shadowbox Polaroid 3.5 x 4.25","item":2771,"_fulfilled_by":10,"quantity":1,"custcol_page_count":1,"custcol_image_url":"http:\/\/www.polaroidfotobar.com\/pdf\/238089\/1603931\/4b917164\/1603931.pdf","rate":16,"subtotal":16,"custcol_produce_in_store":false,"custcol_store_pickup":false,"discounttotal":0,"location":10,"attention":"gus podias","addressee":"gus podias"},{"addr1":"415 oak knoll dr.","city":"manalapan","state":"NJ","zip":"07726","country":"US","phone":7324460747,"shipmethod":1011,"description":"Black Shadowbox Polaroid 9 x 11","item":2536,"_fulfilled_by":10,"quantity":1,"custcol_page_count":1,"custcol_image_url":"http:\/\/www.polaroidfotobar.com\/pdf\/238089\/1603933\/f7e0db88\/1603933.pdf","rate":35,"subtotal":35,"custcol_produce_in_store":false,"custcol_store_pickup":false,"discounttotal":0,"location":10,"attention":"gus podias","addressee":"gus podias"},{"addr1":"415 oak knoll dr.","city":"manalapan","state":"NJ","zip":"07726","country":"US","phone":7324460747,"shipmethod":1011,"description":"Black Shadowbox Polaroid 3.5 x 4.25","item":2400,"_fulfilled_by":10,"quantity":1,"custcol_page_count":1,"custcol_image_url":"http:\/\/www.polaroidfotobar.com\/pdf\/238089\/1603935\/e846bbcc\/1603935.pdf","rate":11,"subtotal":11,"custcol_produce_in_store":false,"custcol_store_pickup":false,"discounttotal":0,"location":10,"attention":"gus podias","addressee":"gus podias"}],"taxtotal":"0.00","taxrate":"0","shippingcost":14.95,"handlingcost":"0","discounttotal":"0","total":1.95,"pnrefnum":"4269723637565000002462","authcode":764167,"paymentmethod":4,"ccname":"gus podias","ccnumber":"5129935536297825","_gcamount":-75,"ismultishipto":false,"shipmethod":1011,"shipaddress":"gus podias\ngus podias\n415 oak knoll dr.\nmanalapan NJ 07726","ccexpiredate":"12\/2018","cczipcode":"07726","shipdate":"03\/25\/2015","customform":107,"billaddress":"gus podias\ngus podias\n415 oak knoll dr.\nmanalapan NJ 07726","custbody_web_discount_code":"","giftcertificateitem":[{"giftcertcode":"2k53tzs6"}]},"customer":{"custentity_customer_source":1,"custentity_customer_source_id":"F206649","firstname":"gus","lastname":"podias","email":"mmp958@aol.com","custentity_fotomail":"gus206649@myfotobar.com","addressbook":{"billing":{"addr1":"415 oak knoll dr.","city":"manalapan","state":"NJ","zip":"07726","country":"US","phone":7324460747,"addressee":"gus podias"}},"_source":"Fotobar","custentitycustomer_department":1}}';
echo( encrypt($xxx));
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