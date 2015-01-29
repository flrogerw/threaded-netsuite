#!/usr/bin/php
<?php 

require_once( __DIR__ . DIRECTORY_SEPARATOR . 'Configure.php' );


//$xxx ='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';
//echo(  decrypt(   $xxx  ) );



$xxx = '{"order":{"_source":"Fotobar","location":1,"department":1,"leadsource":-6,"custbody_order_source":1,"ccprocessor":1,"custbody_order_source_id":"F184327","trandate":"01\/04\/2015","item":[{"addr1":"6015 State Bridge Road","addr2":"Apt. 9306","city":"Johns Creek","state":"GA","zip":30097,"country":"US","phone":4045567230,"shipmethod":1011,"description":"Polaroid 3.5 x 4.25","item":1150,"_fulfilled_by":10,"quantity":6,"custcol_page_count":6,"custcol_image_url":"http:\/\/www.polaroidfotobar.com\/pdf\/184327\/1159912\/44a09756\/1159912.pdf","rate":1,"subtotal":6,"custcol_produce_in_store":false,"custcol_store_pickup":false,"discounttotal":0,"location":10,"attention":"Olivia  Moody","addressee":"Olivia  Moody"}],"taxtotal":"0.00","taxrate":"0","shippingcost":5.95,"handlingcost":"0","discounttotal":"0","total":11.95,"pnrefnum":"4203518725300176326795","authcode":219076,"paymentmethod":6,"ccname":"Harrison Smith","ccnumber":"379739491601007","_gcamount":"0","ismultishipto":false,"shipmethod":1011,"shipaddress":"Olivia  Moody\nOlivia  Moody\n6015 State Bridge Road\nApt. 9306\nJohns Creek GA 30097","ccexpiredate":"04\/2017","cczipcode":85260,"shipdate":"01\/07\/2015","customform":107,"billaddress":"Harrison Smith\nHarrison Smith\n9494 E. Redfield Road\nApt. 2080\nScottsdale AZ 85260","custbody_web_discount_code":""},"customer":{"custentity_customer_source":1,"custentity_customer_source_id":"F162432","firstname":"Harrison","lastname":"Smith","email":"harrison.smith.88@gmail.com","isperson":true,"custentity_fotomail":"harrison162432@myfotobar.com","addressbook":{"billing":{"addr1":"9494 E. Redfield Road","addr2":"Apt. 2080","city":"Scottsdale","state":"AZ","zip":85260,"country":"US","phone":4045567230,"addressee":"Harrison Smith"}},"_source":"Fotobar","custentitycustomer_department":1}}';

//$xxx = '{"order":{"_source":"Fotobar","location":1,"department":1,"leadsource":-6,"custbody_order_source":1,"ccprocessor":1,"custbody_order_source_id":"F170426","trandate":"12\/16\/2014","item":[{"addr1":"21411 partha way","city":"Houston","state":"TX","zip":77073,"country":"US","phone":9132212549,"shipmethod":1011,"description":"Clothesline Frame with Clips","item":318,"_fulfilled_by":"0","quantity":1,"custcol_page_count":1,"rate":50,"subtotal":50,"custcol_produce_in_store":false,"custcol_store_pickup":false,"discounttotal":0,"location":1,"attention":"Gia Beaver","addressee":"\'Cake\' by Gia Genea","isresidential":false},{"addr1":"21411 partha way","city":"Houston","state":"TX","zip":77073,"country":"US","phone":9132212549,"shipmethod":1011,"description":"Polaroid 3.5 x 4.25","item":1150,"_fulfilled_by":10,"quantity":19,"custcol_page_count":19,"custcol_image_url":"http:\/\/www.polaroidfotobar.com\/pdf\/170426\/1042956\/5ad214d3\/1042956.pdf","rate":1,"subtotal":19,"custcol_produce_in_store":false,"custcol_store_pickup":false,"discounttotal":0,"location":10,"attention":"Gia Beaver","addressee":"\'Cake\' by Gia Genea","isresidential":false}],"taxtotal":"0.00","taxrate":"0","shippingcost":14.95,"handlingcost":"0","discounttotal":"0","total":83.95,"pnrefnum":"4187563090670176327037","authcode":810200,"paymentmethod":4,"ccname":"Gia Beaver","ccnumber":"5581588946234317","_gcamount":"0","ismultishipto":false,"shipmethod":1011,"shipaddress":"Gia Beaver\n\'Cake\' by Gia Genea\n21411 partha way\nHouston TX 77073","ccexpiredate":"07\/2015","cczipcode":77073,"shipdate":"12\/19\/2014","customform":107,"billaddress":"\'Cake\' by Gia Genea\n\'Cake\' by Gia Genea\n21411 partha way\nHouston TX 77073","custbody_web_discount_code":""},"customer":{"custentity_customer_source":1,"custentity_customer_source_id":"F151944","firstname":"Gia","lastname":"Beaver","email":"Gia.Genea@gmail.com","isperson":true,"custentity_fotomail":"gia151944@myfotobar.com","addressbook":{"billing":{"companyname":"\'Cake\' by Gia Genea","addr1":"21411 partha way","city":"Houston","state":"TX","zip":77073,"country":"US","phone":9132212549,"addressee":"\'Cake\' by Gia Genea","isresidential":false}},"_source":"Fotobar","custentitycustomer_department":1}}';
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

