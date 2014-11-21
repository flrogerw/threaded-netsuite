#!/usr/bin/php
<?php 

require_once( __DIR__ . DIRECTORY_SEPARATOR . 'Configure.php' );

try{
$exchange = '[{"enumCouponDiscounts":[],"enumProductsSold":[{"intProductSoldUnits":-1,"dblProductSoldNetPrice":10.0,"enumSerialNumbers":[],"dblProductSoldTotalTax1":0.6,"dblProductSoldTotalTax2":0.0,"dblProductSoldTotalTax3":0.0,"intProductID":1922135,"strProductName":"White Acrylic Holder #1","strProductSKU":"510181"},{"intProductSoldUnits":1,"dblProductSoldNetPrice":10.0,"enumSerialNumbers":[],"dblProductSoldTotalTax1":0.6,"dblProductSoldTotalTax2":0.0,"dblProductSoldTotalTax3":0.0,"intProductID":1921877,"strProductName":"Black Acrylic Holder #1","strProductSKU":"510146"}],"enumPayments":[{"strCheckState":null,"strCheckLicenseNumber":null,"strCheckNumber":null,"strAuthorizationCode":"092911","strAuthorizationTransactionID":"6679518049","strCustomPaymentName":"","strGiftCardCode":"","strGiftCardPIN":null,"strCouponCode":"","bIsProcessedExternally":false,"strCreditCardExpiration":"1017","strCreditCardNumberLast4":"0408","strCreditCardTypeLabel":"Visa","intCreditCardTypeID":2,"dblAmount":0.0,"intPaymentTypeID":2,"strPaymentTypeLabel":"CC","intReceiptNumber":0}],"enumEmployees":[{"intEmployeeID":81290,"strEmployeeExternalID":null,"strEmployeeFirstName":"Bruno","strEmployeeLastName":"Bretas"}],"dblReturnedTotal":-10.6,"bIsTaxExempted":false,"bValueAddedTax":false,"intTransactionTypeID":2,"intPaymentTypeID":2,"strCustomerFirstName":" lynch","strCustomerLastName":"lynch","strLocationAddress":"6000 Glades Road #1032C, Boca Raton, FL, 33431, US","strLocationName":"Boca Town Center","strLocationTimeZone":"(GMT-05:00) Eastern Time (US & Canada)","strLocationCurrency":"$","dtTransactionDate":"2014-11-19T11:43:23","intCustomerID":24601334,"intReferenceReceiptNumber":24071414,"strTransactionTypeLabel":"EXCHANGE","strPaymentTypeLabel":"CC","dblTax1":0.0,"dblTax2":0.0,"dblTax3":0.0,"dblGrandTotal":0.0,"intInvoiceNumber":21672306,"intReceiptNumber":24071528,"intLaneID":2,"intLocationID":27449}]';
$refund = '[{"enumCouponDiscounts":[],"enumProductsSold":[{"intProductSoldUnits":-1,"dblProductSoldNetPrice":-30.0,"enumSerialNumbers":[],"dblProductSoldTotalTax1":-1.8,"dblProductSoldTotalTax2":0.0,"dblProductSoldTotalTax3":0.0,"intProductID":1921919,"strProductName":"Film - PX 600 Silver Shade Coo","strProductSKU":"510027"},{"intProductSoldUnits":-1,"dblProductSoldNetPrice":-150.0,"enumSerialNumbers":[],"dblProductSoldTotalTax1":-9.0,"dblProductSoldTotalTax2":0.0,"dblProductSoldTotalTax3":0.0,"intProductID":1922164,"strProductName":"Camera Kit One Step Close up","strProductSKU":"510033"},{"intProductSoldUnits":-1,"dblProductSoldNetPrice":-30.0,"enumSerialNumbers":[],"dblProductSoldTotalTax1":-1.8,"dblProductSoldTotalTax2":0.0,"dblProductSoldTotalTax3":0.0,"intProductID":1922169,"strProductName":"Film - PX 680 Color Protection","strProductSKU":"510026"}],"enumPayments":[{"strCheckState":null,"strCheckLicenseNumber":null,"strCheckNumber":null,"strAuthorizationCode":"","strAuthorizationTransactionID":"6668882795","strCustomPaymentName":"","strGiftCardCode":"","strGiftCardPIN":null,"strCouponCode":"","bIsProcessedExternally":false,"strCreditCardExpiration":"1216","strCreditCardNumberLast4":"0193","strCreditCardTypeLabel":"Visa","intCreditCardTypeID":2,"dblAmount":-222.6,"intPaymentTypeID":2,"strPaymentTypeLabel":"CC","intReceiptNumber":0}],"enumEmployees":[{"intEmployeeID":81281,"strEmployeeExternalID":null,"strEmployeeFirstName":"Alex","strEmployeeLastName":"Berger"}],"dblReturnedTotal":0.0,"bIsTaxExempted":false,"bValueAddedTax":false,"intTransactionTypeID":1,"intPaymentTypeID":2,"strCustomerFirstName":"P Valli","strCustomerLastName":"Valli","strLocationAddress":"6000 Glades Road #1032C, Boca Raton, FL, 33431, US","strLocationName":"Boca Town Center","strLocationTimeZone":"(GMT-05:00) Eastern Time (US & Canada)","strLocationCurrency":"$","dtTransactionDate":"2014-11-15T12:23:04","intCustomerID":24523568,"intReferenceReceiptNumber":23987044,"strTransactionTypeLabel":"REFUND","strPaymentTypeLabel":"CC","dblTax1":-12.6,"dblTax2":0.0,"dblTax3":0.0,"dblGrandTotal":-222.6,"intInvoiceNumber":51296784,"intReceiptNumber":24005453,"intLaneID":2,"intLocationID":27449}]';	

$xxx ='[{"enumCouponDiscounts":[],"enumProductsSold":[{"intProductSoldUnits":1,"dblProductSoldNetPrice":60.0,"enumSerialNumbers":[],"dblProductSoldTotalTax1":0.0,"dblProductSoldTotalTax2":0.0,"dblProductSoldTotalTax3":0.0,"intProductID":1960335,"strProductName":"Silver Metal 11\"x14\"","strProductSKU":"700704"},{"intProductSoldUnits":1,"dblProductSoldNetPrice":14.95,"enumSerialNumbers":[],"dblProductSoldTotalTax1":0.0,"dblProductSoldTotalTax2":0.0,"dblProductSoldTotalTax3":0.0,"intProductID":1930099,"strProductName":"Shipping Charge","strProductSKU":"Ship"},{"intProductSoldUnits":1,"dblProductSoldNetPrice":4.2,"enumSerialNumbers":[],"dblProductSoldTotalTax1":0.0,"dblProductSoldTotalTax2":0.0,"dblProductSoldTotalTax3":0.0,"intProductID":1959794,"strProductName":"Shipped Tax","strProductSKU":"Taxes"}],"enumPayments":[{"strCheckState":null,"strCheckLicenseNumber":null,"strCheckNumber":null,"strAuthorizationCode":"061622","strAuthorizationTransactionID":"6683861411","strCustomPaymentName":"","strGiftCardCode":"","strGiftCardPIN":null,"strCouponCode":"","bIsProcessedExternally":false,"strCreditCardExpiration":"1117","strCreditCardNumberLast4":"2271","strCreditCardTypeLabel":"Visa","intCreditCardTypeID":2,"dblAmount":79.15,"intPaymentTypeID":2,"strPaymentTypeLabel":"CC","intReceiptNumber":0}],"enumEmployees":[{"intEmployeeID":81292,"strEmployeeExternalID":null,"strEmployeeFirstName":"Nikki","strEmployeeLastName":"McKenna"}],"dblReturnedTotal":0.0,"bIsTaxExempted":false,"bValueAddedTax":false,"intTransactionTypeID":0,"intPaymentTypeID":2,"strCustomerFirstName":" j","strCustomerLastName":"j","strLocationAddress":"6000 Glades Road #1032C, Boca Raton, FL, 33431, US","strLocationName":"Boca Town Center","strLocationTimeZone":"(GMT-05:00) Eastern Time (US & Canada)","strLocationCurrency":"$","dtTransactionDate":"2014-11-20T17:17:07","intCustomerID":24619243,"intReferenceReceiptNumber":0,"strTransactionTypeLabel":"SALE","strPaymentTypeLabel":"CC","dblTax1":0.0,"dblTax2":0.0,"dblTax3":0.0,"dblGrandTotal":79.15,"intInvoiceNumber":22601360,"intReceiptNumber":24091147,"intLaneID":2,"intLocationID":27449}]';

$xxx = 'nx3arHBVbhV2elo6n7cdf46hqZw+di9SKB7KIWI/3fIcHnt2nct1bT4rX2uvEPpzlV7Agzj9Zgv+QB8Ir7mPBu1gCbbgeV+r7Tc9xy4uXRUYAAwIkNvd7bEb4jIzQnUWfA3L+OofUBdog7gwGnhtANL6njySGchuN3Fg9NfABmGht9L/cM9EQV4vz/HmO+qykuAidt9XROg7cR90UUZ7tiUIS+jfKnIyA3l7Ghean8m8I/M0PM2uF8nFY7dYH0BDKXjkjjrQZkMCt+kLRPOE30XC0uPJMjl8xGyqzk8JI/dJXXK7H+Mj8Jp0UPW1UC5hINLR/Z0+/iM73l7FgX0Rca7ZZiSPlbfsYvKKv4DiGJUW9e7JPWzWo7F5dhE7G1uS0q70GX45lQ32rEQxAnxVdPygI+9C3wX0OIngmM1zfNllEMv2bn2OWUp/RVSfXg1RkAe+NqpQHXu0Ek9xwYJ3z0JetEHr+uGS96lhCuu+iUxPvzdSrnFjO7CTY4akE3oEfHkhSinA3Oz86A186E0uA250abh+igCXpdVjgQ0g3QbMYvxTP0avAIspstZylezuJemrLNXfu/z7jaO7Gb0kkkzmr1moccuRXSWIbylv5Y5F7FxbCHnkqDESaVE/7d6SGtYxtQIXDPXgtm2xtJFPVaxvBQMQ3GjzjUZ3VF0dfFZJkrbbmhR8Zz9nV1yMNo6leQy7+DHABAMpG6+mAnw/ko90me+C9Phyke0JpuQTMPYhn3KIk8/rUvKfgVOiK1o54YSyCM705TdztAyvZU4Z9Qx+x+jRX2seFc1bBSHoAgyPK5vlW/ftZp3qOL2S9NwXEUHvQTzaPuyqn31K1lCLWLIjVvbnPpfx2DbM3Fxc9t+JA0j8rxsxspu83ZplJzI5Q0wrzaBtZ8anY749Dto7DW48/kKQcTgPx0J76p7cNxWFWbraZRCCwnPt98HL4n4oF8fjCjLT0ihmIm9YS9IaGpasNYzO7O2wLI75gIBKnk0TLABWrQR7La4qBFd9P3OH4IahwItDgVmtcPnYCv6U3bwPZg4WgHtyWTqik/H9Bs4DfaLHUxSozyd37OIwQ/QMZWp9AwAGo1647nAkPYLkRxTOV8KgMiJH6G7W90LpsGqVmjB1HzT/4bWyj+7o7pahqRg6cqG5CfAa1pe8rWe+lEmpBbVYwmDcFEceYa56mk0mXYX6a0y9uc7eYWWuxk+hWS84ULCK2i2EGjjXM9pJ2VvmBoCDOMsNcJiGA8ByswPupaTzSw0rUk8kisMR/5Uf5cxU5m0//e7ym7Gm4A6LfVgxmScVC0zLXA1gmoQCDUdPWGu29hjxUtpfmRDSSN+l4V6UujPkKUrP//gH6Ux0m2tqnzLzBd3y4FZLJcaLaEdFwtLjyTI5fMRsqs5PCSP3l386ob5LgaXwuACDQ9OOAahMTaBxRty6xFA//cYSgQP32QuKfHrzaSfIxCr0q+hpk2dgRj8D5mDNzs+X+gq625WHrYpx3f+QM4PCQjkDuAvsWjoRCjHHsxWiGpc2funuv19mev2+P2jBgoDzDQrm/IxOwJtTlo5T4Z9243v6xg5v0DbrbfOvsA+P8See7QvUqAT7wPZzbpKu2IrmTD9lnotsdGYSgjv43jjg5Aer7QPquSdpHRYdxvN8oDd+9eD5R5RBZ0gW/1aKssCXS32GZQUtC5CRG9CSl9Wq0QPuzN8ofTSUzQqimiu2ujnlzIyYztSlAjRxdQQIN2MpVUfLhQNb3Ika10gY6cbzmZGMhyn9RZI3/Qmkt1FQ2H1CRJvEzcY2Ryw2OBeM9Kz3+k6xYWoW6z0uSYY8BEFZIMnbhZMhidukoCwaT1oR5Uv1Fc6nq73Qblf+lkM5MOBlkx1vd8IrKoFk8mOgpJhe7rGRt1wh+sLls8oxySynY3FjkBCYivpXWi49HdvxRBGIlbgdhgNDyQTdVwLohRJNjP0Zq6plExUWRFad1NlAtRLldesl';

print_r( json_decode( decrypt($xxx) ) );

	die();
	
	

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

