#!/usr/bin/php
<?php 

require_once( __DIR__ . DIRECTORY_SEPARATOR . 'Configure.php' );


$xxx = '[{"enumCouponDiscounts":[],"enumProductsSold":[{"intProductSoldUnits":-1,"dblProductSoldNetPrice":-70.0,"enumSerialNumbers":[],"dblProductSoldCurrentRegularPrice":70.0,"dblProductSoldCurrentCost":0.0,"dblProductSoldTotalTax1":-4.2,"dblProductSoldTotalTax2":0.0,"dblProductSoldTotalTax3":0.0,"intProductID":1921875,"strProductName":"4-in-1 Lens 5/5s","strProductSKU":"510421"}],"enumPayments":[{"strCheckState":null,"strCheckLicenseNumber":null,"strCheckNumber":null,"strAuthorizationCode":"","strAuthorizationTransactionID":"0","strCustomPaymentName":"","strGiftCardCode":"","strGiftCardPIN":null,"strCouponCode":"","bIsProcessedExternally":false,"strCreditCardExpiration":"","strCreditCardNumberLast4":"","strCreditCardTypeLabel":"","intCreditCardTypeID":0,"dblAmount":-74.2,"intPaymentTypeID":1,"strPaymentTypeLabel":"Cash","intReceiptNumber":0}],"enumEmployees":[{"intEmployeeID":81290,"strEmployeeExternalID":null,"strEmployeeFirstName":"Bruno","strEmployeeLastName":"Bretas"}],"enumGroups":[],"dblReturnedTotal":0.0,"bIsTaxExempted":false,"bValueAddedTax":false,"intTransactionTypeID":1,"intPaymentTypeID":1,"strCustomerFirstName":" x","strCustomerLastName":"x","strLocationAddress":"6000 Glades Road #1032C, Boca Raton, FL, 33431, US","strLocationName":"Boca Town Center","strLocationTimeZone":"(GMT-05:00) Eastern Time (US & Canada)","strLocationCurrency":"$","dtTransactionDate":"2014-12-01T17:51:19","intCustomerID":24870542,"intReferenceReceiptNumber":24358134,"strTransactionTypeLabel":"REFUND","strPaymentTypeLabel":"Cash","dblTax1":-4.2,"dblTax2":0.0,"dblTax3":0.0,"dblGrandTotal":-74.2,"intInvoiceNumber":17543566,"intReceiptNumber":24358161,"intLaneID":2,"intLocationID":27449}]';
var_dump( json_decode(  $xxx ));

die();

try{

$xxx = '{"order":{"billaddress":"Polaroid Fotobar\nPolaroid Fotobar\n6000 Sepulveda Blvd K155\nCulver City CA 90230","ccprocessor":1,"custbody_order_source":28,"custbody_order_source_id":"POS_24062558","custbody_pos_cash_total":31.86,"custbody_pos_employee":"Jaime Herrera","custbody_pos_invoice":41888802,"custbody_pos_location":"Culver City","custbody_pos_postranstime":"12:17 pm","custbody_pos_receipt":24062558,"custbody_pos_receipt_date":"11\/18\/2014 12:17:21 pm","custbody_pos_receipt_total":31.86,"custbody_pos_tax_total":2.76,"customform":107,"department":8,"ismultishipto":"F","item":[{"addressee":"Polaroid Fotobar","addr1":"6000 Sepulveda Blvd K155","attention":"Polaroid Fotobar","city":"Culver City","country":"US","custcol_produce_in_store":"F","custcol_store_pickup":"T","description":"Shadowbox #3 Blue","discountitem":1174,"discounttotal":-20,"isclosed":"F","isresidential":"F","isestimate":"F","istaxable":"T","item":"2516","location":"2","price":-1,"quantity":1,"rate":40,"shipmethod":10,"state":"CA","zip":"90230"},{"addressee":"Polaroid Fotobar","addr1":"6000 Sepulveda Blvd K155","attention":"Polaroid Fotobar","city":"Culver City","country":"US","custcol_produce_in_store":"F","custcol_store_pickup":"T","description":"Polaroid 3.5 x 4.25","discountitem":1174,"discounttotal":-4,"isclosed":"F","isresidential":"F","isestimate":"F","istaxable":"T","item":"1137","location":"2","price":-1,"quantity":8,"rate":1,"shipmethod":10,"state":"CA","zip":"90230"},{"addressee":"Polaroid Fotobar","addr1":"6000 Sepulveda Blvd K155","attention":"Polaroid Fotobar","city":"Culver City","country":"US","custcol_produce_in_store":"F","custcol_store_pickup":"T","description":"9 x 11 Polaroid","discountitem":1174,"discounttotal":-5,"isclosed":"F","isresidential":"F","isestimate":"F","istaxable":"T","item":"1136","location":"2","price":-1,"quantity":1,"rate":10,"shipmethod":10,"state":"CA","zip":"90230"},{"addressee":"Polaroid Fotobar","addr1":"6000 Sepulveda Blvd K155","attention":"Polaroid Fotobar","city":"Culver City","country":"US","custcol_produce_in_store":"F","custcol_store_pickup":"T","description":"Retail Bag Medium","discountitem":1174,"discounttotal":-0.05,"isclosed":"F","isresidential":"F","isestimate":"F","istaxable":"T","item":"3347","location":"2","price":-1,"quantity":1,"rate":0.1,"shipmethod":10,"state":"CA","zip":"90230"}],"leadsource":2,"location":2,"orderstatus":"B","paymentmethod":8,"recordtype":"salesorder","shipaddress":"Polaroid Fotobar\nPolaroid Fotobar\n6000 Sepulveda Blvd K155\nCulver City CA 90230","shipcomplete":"T","shipmethod":10,"shipdate":"11\/18\/2014","taxtotal":2.76,"total":58.1,"trandate":"11\/18\/2014"},"customer":{"custentity_customer_source":3,"custentity_customer_source_id":"FPOS_TEST","firstname":"Anonymous","lastname":"User","email":"admin@polaroidfotobar.com","isperson":true,"custentity_fotomail":"admin@myfotobar.com","custentitycustomer_department":8,"recordtype":"customer","entitystatus":13,"globalsubscriptionstatus":1,"leadsource":2}}';

echo(  encrypt(   $xxx  ) );
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

