#!/usr/bin/php
<?php 

require_once( __DIR__ . DIRECTORY_SEPARATOR . 'Configure.php' );

//echo(  decrypt(   $xxx  ) );

$xxx ='{"order":{"_source":"Fotobar","location":1,"department":1,"leadsource":-6,"custbody_order_source":1,"ccprocessor":1,"custbody_order_source_id":"F166709","trandate":"12\/08\/2014","item":[{"addr1":"3900 Jog Road","addr2":"Saint Andrew\'s Upper School","city":"Boca Raton","state":"FL","zip":33434,"country":"US","phone":5612894587,"shipmethod":1011,"description":"Polaroid 3.5 x 4.25","item":1150,"_fulfilled_by":10,"quantity":4,"custcol_page_count":4,"custcol_image_url":"http:\/\/www.polaroidfotobar.com\/pdf\/166709\/1013446\/a901d1af\/1013446.pdf","rate":1,"subtotal":4,"custcol_produce_in_store":false,"custcol_store_pickup":false,"discounttotal":0,"location":10,"attention":"Giulio Capolino","addressee":"Giulio Capolino"},{"addr1":"3900 Jog Road","addr2":"Saint Andrew\'s Upper School","city":"Boca Raton","state":"FL","zip":33434,"country":"US","phone":5612894587,"shipmethod":1011,"description":"3D Polaroid 3.5 x 4.25","item":2705,"_fulfilled_by":10,"quantity":2,"custcol_page_count":2,"custcol_image_url":"http:\/\/www.polaroidfotobar.com\/pdf\/166709\/1013450\/dd233c3e\/1013450.pdf","rate":3,"subtotal":6,"custcol_produce_in_store":false,"custcol_store_pickup":false,"discounttotal":0,"location":10,"attention":"Giulio Capolino","addressee":"Giulio Capolino"}],"taxtotal":0.6,"taxrate":6,"shippingcost":5.95,"handlingcost":0,"discounttotal":0,"total":16.55,"pnrefnum":"4180962721400176326813","authcode":679996,"paymentmethod":4,"ccname":"Giulio Capolino","ccnumber":"5311718010273811","_gcamount":0,"ismultishipto":false,"shipmethod":1011,"shipaddress":"Giulio Capolino\nGiulio Capolino\n3900 Jog Road\nSaint Andrew\'s Upper School\nBoca Raton FL 33434","ccexpiredate":"06\/2018","cczipcode":33434,"shipdate":"12\/11\/2014","customform":107,"billaddress":"Giulio Capolino\nGiulio Capolino\n3900 Jog Road\nSaint Andrew\'s Upper School\nBoca Raton FL 33434","custbody_web_discount_code":""},"customer":{"custentity_customer_source":1,"custentity_customer_source_id":"F94235","firstname":"Giulio","lastname":"Capolino","email":"capolino.g@gmail.com","isperson":true,"custentity_fotomail":"giulio94235@myfotobar.com","addressbook":{"billing":{"addr1":"3900 Jog Road","addr2":"Saint Andrew\'s Upper School","city":"Boca Raton","state":"FL","zip":33434,"country":"US","phone":5612894587,"addressee":"Giulio Capolino"}},"_source":"Fotobar","custentitycustomer_department":1}}';

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

