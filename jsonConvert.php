#!/usr/bin/php
<?php 

require_once( __DIR__ . DIRECTORY_SEPARATOR . 'Configure.php' );

var_dump( json_decode( '[{"enumCouponDiscounts":[{"intCouponID":179023,"strCouponCode":"9642","strCouponTargetType":"Per Sale","intItemID":0,"dblDiscountAmount":6.0}],"enumProductsSold":[{"intProductSoldUnits":1,"dblProductSoldNetPrice":7.2,"enumSerialNumbers":[],"dblProductSoldTotalTax1":0.432,"dblProductSoldTotalTax2":0.0,"dblProductSoldTotalTax3":0.0,"intProductID":1921895,"strProductName":"Chalk Photo Block - A True Love","strProductSKU":"510453"},{"intProductSoldUnits":6,"dblProductSoldNetPrice":5.4,"enumSerialNumbers":[],"dblProductSoldTotalTax1":0.324,"dblProductSoldTotalTax2":0.0,"dblProductSoldTotalTax3":0.0,"intProductID":1922251,"strProductName":"Polaroid 3.5 x 4.25","strProductSKU":"703040"},{"intProductSoldUnits":1,"dblProductSoldNetPrice":32.4,"enumSerialNumbers":[],"dblProductSoldTotalTax1":1.944,"dblProductSoldTotalTax2":0.0,"dblProductSoldTotalTax3":0.0,"intProductID":1929749,"strProductName":"WEBORDER ART","strProductSKU":"Custom Art"},{"intProductSoldUnits":1,"dblProductSoldNetPrice":8.95,"enumSerialNumbers":[],"dblProductSoldTotalTax1":0.0,"dblProductSoldTotalTax2":0.0,"dblProductSoldTotalTax3":0.0,"intProductID":1930099,"strProductName":"Shipping Charge","strProductSKU":"Ship"}],"enumPayments":[{"strCheckState":null,"strCheckLicenseNumber":null,"strCheckNumber":null,"strAuthorizationCode":"","strAuthorizationTransactionID":"","strCustomPaymentName":"","strGiftCardCode":"","strGiftCardPIN":null,"strCouponCode":"9642","bIsProcessedExternally":false,"strCreditCardExpiration":"","strCreditCardNumberLast4":"","strCreditCardTypeLabel":"N/A","intCreditCardTypeID":0,"dblAmount":6.0,"intPaymentTypeID":7,"strPaymentTypeLabel":"Coupon","intReceiptNumber":0},{"strCheckState":null,"strCheckLicenseNumber":null,"strCheckNumber":null,"strAuthorizationCode":"09680C","strAuthorizationTransactionID":"6624185178","strCustomPaymentName":"","strGiftCardCode":"","strGiftCardPIN":null,"strCouponCode":"","bIsProcessedExternally":false,"strCreditCardExpiration":"0516","strCreditCardNumberLast4":"1716","strCreditCardTypeLabel":"Visa","intCreditCardTypeID":2,"dblAmount":56.65,"intPaymentTypeID":2,"strPaymentTypeLabel":"CC","intReceiptNumber":0}],"enumEmployees":[{"intEmployeeID":81283,"strEmployeeExternalID":null,"strEmployeeFirstName":"Shannon","strEmployeeLastName":"Needleman"}],"dblReturnedTotal":0.0,"bIsTaxExempted":false,"bValueAddedTax":false,"intTransactionTypeID":0,"intPaymentTypeID":5,"strCustomerFirstName":" ","strCustomerLastName":"","strLocationAddress":"6000 Glades Road #1032C, Boca Raton, FL, 33431, US","strLocationName":"Boca Town Center","strLocationTimeZone":"(GMT-05:00) Eastern Time (US & Canada)","strLocationCurrency":"$","dtTransactionDate":"2014-10-30T16:08:09","intCustomerID":24372474,"intReferenceReceiptNumber":0,"strTransactionTypeLabel":"SALE","strPaymentTypeLabel":"Split","dblTax1":2.7,"dblTax2":0.0,"dblTax3":0.0,"dblGrandTotal":56.65,"intInvoiceNumber":99383500,"intReceiptNumber":23817855,"intLaneID":2,"intLocationID":27449}]') );

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

