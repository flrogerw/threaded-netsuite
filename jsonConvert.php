#!/usr/bin/php
<?php 

require_once( __DIR__ . DIRECTORY_SEPARATOR . 'Configure.php' );

$xxx= '[{"enumCouponDiscounts":[],"enumProductsSold":[{"intProductSoldUnits":1,"dblProductSoldNetPrice":99.95,"enumSerialNumbers":[],"dblProductSoldTotalTax1":5.997,"dblProductSoldTotalTax2":0.0,"dblProductSoldTotalTax3":0.0,"intProductID":1929749,"strProductName":"WEBORDER ART","strProductSKU":"Custom Art"}],"enumPayments":[{"strCheckState":null,"strCheckLicenseNumber":null,"strCheckNumber":null,"strAuthorizationCode":"","strAuthorizationTransactionID":"0","strCustomPaymentName":"","strGiftCardCode":"","strGiftCardPIN":null,"strCouponCode":"","bIsProcessedExternally":false,"strCreditCardExpiration":"","strCreditCardNumberLast4":"","strCreditCardTypeLabel":"","intCreditCardTypeID":0,"dblAmount":105.95,"intPaymentTypeID":1,"strPaymentTypeLabel":"Cash","intReceiptNumber":0}],"enumEmployees":[{"intEmployeeID":81282,"strEmployeeExternalID":null,"strEmployeeFirstName":"Stefan","strEmployeeLastName":"Kwiatkowski"}],"dblReturnedTotal":0.0,"bIsTaxExempted":false,"bValueAddedTax":false,"intTransactionTypeID":0,"intPaymentTypeID":1,"strCustomerFirstName":"Karen Scott","strCustomerLastName":"Scott","strLocationAddress":"6000 Glades Road #1032C, Boca Raton, FL, 33431, US","strLocationName":"Boca Town Center","strLocationTimeZone":"(GMT-05:00) Eastern Time (US & Canada)","strLocationCurrency":"$","dtTransactionDate":"2014-11-12T15:15:50","intCustomerID":24507335,"intReferenceReceiptNumber":0,"strTransactionTypeLabel":"SALE","strPaymentTypeLabel":"Cash","dblTax1":6.0,"dblTax2":0.0,"dblTax3":0.0,"dblGrandTotal":105.95,"intInvoiceNumber":65677908,"intReceiptNumber":23969045,"intLaneID":2,"intLocationID":27449}]';
$xxx = '{"order":{"billaddress":"robynn ginsberg\nrobynn ginsberg\nPolaroid Fotobar - F157208\n6000 Glades Road #1032C\nBoca Raton FL 33431","ccapproved":"T","custbody_order_source":"28","custbody_order_source_id":"F157208","custbody_pos_trans_id":"13072726","custbody_textrequired":"F","customform":107,"department":7,"discountrate":0,"discounttotal":0,"entity":25069,"getauth":"F","handlingcost":0,"ismultishipto":"T","istaxable":"T","leadsource":2,"location":7,"paymentmethod":8,"pnrefnum":"13072726","recordtype":"salesorder","shipaddress":"robynn ginsberg\nrobynn ginsberg\nPolaroid Fotobar - F157208\n6000 Glades Road #1032C\nBoca Raton FL 33431","shipdate":"11\/14\/2014","shipmethod":2889,"shippingcost":0,"taxrate":"6","taxtotal":9.6,"tobeemailed":"F","tobeprinted":"F","total":169.6,"trandate":"11\/11\/2014","item":[{"addressee":"robynn ginsberg","addr1":"Polaroid Fotobar - F157208","addr2":"6000 Glades Road #1032C","amount":80,"attention":"robynn ginsberg","city":"Boca Raton","country":"US","custcol_image_url":"http:\/\/www.polaroidfotobar.com\/pdf\/157208\/935662\/51d83acd\/935662.pdf","custcol_page_count":"1","custcol_produce_in_store":"F","custcol_store_pickup":"T","custcol162":"1","discountitem":"F","discounttotal":0,"isclosed":"F","isestimate":"F","isresidential":"T","istaxable":"T","item":929,"location":"1","phone":"5617561941","price":-1,"quantity":1,"rate":80,"shipmethod":"2889","state":"FL","zip":"33431"},{"addressee":"robynn ginsberg","addr1":"Polaroid Fotobar - F157208","addr2":"6000 Glades Road #1032C","amount":80,"attention":"robynn ginsberg","city":"Boca Raton","country":"US","custcol_image_url":"http:\/\/www.polaroidfotobar.com\/pdf\/157208\/935663\/a3fc3bcb\/935663.pdf","custcol_page_count":"1","custcol_produce_in_store":"F","custcol_store_pickup":"T","custcol162":"1","discountitem":"F","discounttotal":0,"isclosed":"F","isestimate":"F","isresidential":"T","istaxable":"T","item":929,"location":"1","phone":"5617561941","price":-1,"quantity":1,"rate":80,"shipmethod":"2889","state":"FL","zip":"33431"}],"giftcertificateitem":null,"addressbook":[]}}';
print_r(json_decode($xxx, true));
echo(encrypt( $xxx ));

die();

try{

	/*
		$file_handle = fopen( APPLICATION_DIR . 'TestOrders/POS_TEST.csv', "r");
	while (!feof($file_handle)) {
	$aOutput[] = fgets($file_handle);
	}
	fclose($file_handle);
	$sJson = OrderJSON::convert( $aOutput );
	*/

$xxx = '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';
echo(  decrypt(   $xxx  ) );
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

