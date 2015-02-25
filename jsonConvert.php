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
$xxx = '{"order":{"billaddress":"Polaroid Fotobar\nPolaroid Fotobar\n6000 Glades Road #1032C\nBoca Raton FL 33431","ccprocessor":1,"custbody_order_source":28,"custbody_order_source_id":"F219447","custbody_pos_auth_code":"138273","custbody_pos_cc_exp_date":"02\/2018","custbody_pos_cc_number":"**** **** **** 4049","custbody_pos_cc_total":132.5,"custbody_pos_employee":"Alex Berger","custbody_pos_invoice":64324736,"custbody_pos_location":"Boca Town Center","custbody_pos_postranstime":"12:54 pm","custbody_pos_receipt":26043118,"custbody_pos_receipt_date":"02\/23\/2015 12:54:40 pm","custbody_pos_receipt_total":132.5,"custbody_pos_ref_num":"6947169434","custbody_pos_tax_total":7.5,"customform":107,"department":7,"ismultishipto":true,"item":[{"addressee":"Polaroid Fotobar","addr1":"6000 Glades Road #1032C","attention":"Polaroid Fotobar","city":"Boca Raton","country":"US","custcol_produce_in_store":"F","custcol_store_pickup":"T","description":"5x7 Sublimated White Metal - In Store","isclosed":"F","isresidential":"F","isestimate":"F","istaxable":"T","item":"3488","location":"7","price":-1,"quantity":4,"rate":25,"shipmethod":10,"state":"FL","zip":"33431"},{"addressee":"Polaroid Fotobar","addr1":"6000 Glades Road #1032C","attention":"Polaroid Fotobar","city":"Boca Raton","country":"US","custcol_produce_in_store":"F","custcol_store_pickup":"T","description":"5x7 Sublimated Clear Metal - In Store","isclosed":"F","isresidential":"F","isestimate":"F","istaxable":"T","item":"3485","location":"7","price":-1,"quantity":1,"rate":25,"shipmethod":10,"state":"FL","zip":"33431"},{"addressee":"Beatriz Rios","addr1":"Polaroid Fotobar - F219447","addr2":"6000 Glades Road #1032C","attention":"Beatriz Rios","city":"Boca Raton","country":"US","custcol_image_url":"http:\/\/www.polaroidfotobar.com\/pdf\/219447\/1441361\/8382e095\/1441361.pdf","custcol_page_count":1,"custcol_store_pickup":true,"custcol162":1,"description":"5\"x7\" White Metal Print with easel","isclosed":"F","isresidential":"F","isestimate":"F","istaxable":"T","item":3210,"location":1,"phone":573183056134,"price":-1,"quantity":1,"rate":25,"shipmethod":2889,"state":"FL","zip":33431,"subtotal":25,"custbody_comments":"Image Quality: High - 215"}],"leadsource":2,"location":7,"orderstatus":"B","paymentmethod":8,"recordtype":"salesorder","shipaddress":"Polaroid Fotobar\nPolaroid Fotobar\n6000 Glades Road #1032C\nBoca Raton FL 33431","shipcomplete":"T","shipmethod":10,"shipdate":"02\/23\/2015","taxtotal":7.5,"total":150,"trandate":"02\/23\/2015"},"customer":{"custentity_customer_source":3,"custentity_customer_source_id":"F192629","firstname":"Beatriz","lastname":"Rios","email":"beatrizelena77@yahoo.com","isperson":true,"custentity_fotomail":"beatriz192629@myfotobar.com","custentitycustomer_department":7,"recordtype":"customer","entitystatus":13,"globalsubscriptionstatus":1,"leadsource":2,"_source":"Fotobar Store 10"}}';

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

