#!/usr/bin/php
<?php 

require_once( __DIR__ . DIRECTORY_SEPARATOR . 'Configure.php' );



$xxx= '[{"enumCouponDiscounts":[{"intCouponID":178648,"strCouponCode":"5192","strCouponTargetType":"Per Item","intItemID":1922251,"dblDiscountAmount":1.0},{"intCouponID":178648,"strCouponCode":"5192","strCouponTargetType":"Per Item","intItemID":1922264,"dblDiscountAmount":0.0}],"enumProductsSold":[{"intProductSoldUnits":7,"dblProductSoldNetPrice":6.3,"enumSerialNumbers":[],"intProductID":0,"intProductCategoryID":0,"intProductStatus":0,"strProductName":"Polaroid 3.5 x 4.25","strProductCategoryName":null,"strProductDescription":null,"strProductSKU":"703040"},{"intProductSoldUnits":1,"dblProductSoldNetPrice":1.8,"enumSerialNumbers":[],"intProductID":0,"intProductCategoryID":0,"intProductStatus":0,"strProductName":"3D Addition","strProductCategoryName":null,"strProductDescription":null,"strProductSKU":"703045"}],"enumPayments":[{"strCheckState":null,"strCheckLicenseNumber":null,"strCheckNumber":null,"strAuthorizationCode":"","strAuthorizationTransactionID":"","strCustomPaymentName":"","strGiftCardCode":"","strGiftCardPIN":null,"strCouponCode":"5192","bIsProcessedExternally":false,"strCreditCardExpiration":"","strCreditCardNumberLast4":"","strCreditCardTypeLabel":"N/A","intCreditCardTypeID":0,"dblAmount":0.9,"intPaymentTypeID":7,"strPaymentTypeLabel":"Coupon","intReceiptNumber":0},{"strCheckState":null,"strCheckLicenseNumber":null,"strCheckNumber":null,"strAuthorizationCode":"083219","strAuthorizationTransactionID":"6616246814","strCustomPaymentName":"","strGiftCardCode":"","strGiftCardPIN":null,"strCouponCode":"","bIsProcessedExternally":false,"strCreditCardExpiration":"0517","strCreditCardNumberLast4":"4356","strCreditCardTypeLabel":"Visa","intCreditCardTypeID":2,"dblAmount":8.59,"intPaymentTypeID":2,"strPaymentTypeLabel":"CC","intReceiptNumber":0}],"enumEmployees":[{"intEmployeeID":81289,"strEmployeeExternalID":null,"strEmployeeFirstName":"Wilder","strEmployeeLastName":"Rumpf"}],"dblReturnedTotal":0.0,"bIsTaxExempted":false,"bValueAddedTax":false,"intTransactionTypeID":0,"intPaymentTypeID":5,"strCustomerFirstName":" roefaro","strCustomerLastName":"roefaro","strLocationAddress":"6000 Glades Road #1032C, Boca Raton, FL, 33431, US","strLocationName":"Boca Town Center","strLocationTimeZone":"(GMT-05:00) Eastern Time (US & Canada)","strLocationCurrency":"$","dtTransactionDate":"2014-10-27T19:33:46","intCustomerID":24348551,"intReferenceReceiptNumber":0,"strTransactionTypeLabel":"SALE","strPaymentTypeLabel":"Split","dblTax1":0.49,"dblTax2":0.0,"dblTax3":0.0,"dblGrandTotal":8.59,"intInvoiceNumber":78147580,"intReceiptNumber":23790803,"intLaneID":2,"intLocationID":27449}]';
var_dump(json_decode($xxx));
//die();
try {

	/*
		$file_handle = fopen( APPLICATION_DIR . 'TestOrders/POS_TEST.csv', "r");
	while (!feof($file_handle)) {
	$aOutput[] = fgets($file_handle);
	}
	fclose($file_handle);
	$sJson = OrderJSON::convert( $aOutput );
	*/
$xxx='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';
//$xxx = 'nx3arHBVbhV2elo6n7cdf46hqZw+di9SKB7KIWI/3fK5irhS7zouHynVl9AU6btXeq0NIlzFdxgynOL2HTghJPu3+Demtqwt7DdBNGVcmiYaUxDK1QoD8/v44N2vzmYPR1XsNlSIWefdpyNRkYqAQqvDaMHZXn2HthesS5apJL2BHpU8mwVI0UjzHpHuJdq1bw6/xAHdyRe/ykdtYGyYPCrQSdyfPK8HpdXmqvefILLhspSBb8lzgL3FOqwIMof/ZBGarlfJ0GLcXnLfn1hFasHJO8B5vZ50CU9v3D/+4VdGa3lf5kenlCSuN6eHnpX8LU4LGVjIpfpVcXqldhleX6ydt/eZbD41X9Mm03p+mH62PuRoBjpV3NbCGLHIQJxStf2Pkfe/iLFshFobq4GbbLE8tgzZ0FbrcLf3r9VYFivu4CIuIQmoWl9BFXt/5SWj0Jl8ylRtxvlCPcTBOJXF0lzlGX9SCHEUlaJLFWo1+0aNsCtBoVmC/0qvP8q83R0W9aKq1vU35l4q2y8M806SfLrCSwaiMtzKXjB3DxXXlN/7FLwTxyHAV57OmMpFA5G3oKEJUdosrkmHt74/p7UIdJTEL3u3NlLoQiX2kSR5uz1c+YfWwTilkRGKu94K+PENXgMLM6V1c4BHDExVCpJZ1FKx2SOY+kao/aZmKA7z5Q8T299htvaMC/VbZ4/4eZLV3EpU2cfys5S18LT0A+ujFF8QVwLUWw5yhvObyC5UCVohn3KIk8/rUvKfgVOiK1o54YSyCM705TdztAyvZU4Z9Qx+x+jRX2seFc1bBSHoAgyPK5vlW/ftZp3qOL2S9NwXEUHvQTzaPuyqn31K1lCLWNBx3O1x3DqgeQWMTqAdWZO6L4EcOdoAH86D25GAitBTXQKhor6oQHlRtSEOjbI1Lqr7MwzykRsH1HM32MZ4l/JAVz+s/xqJ68HuhRR7JQBI3I2gBqxK7VrR/G+x+NgbzW44sar2vUZE6PIhXhzlQ0mbZvUK31XlxNXpVBHV7ZM0wmFOKd4ozCqQX78Ww1BiJ6nmeFVaGrJ3WCuhcPzqyBk6+kbY9XJXl7cnjFm9fMv0o0RAfYKzqEAjYFGvnOAxuIenx6o2T/IL3NxAmgLYJwZoMtee01e0Rl6PPjLJeVDbEFvwNojy77klpACH27ilVWWjN3w7yz2eFSlGayFwGUld063vDvdE26lSxg+ta+c+rtJCqc32zHDFakCTIGByJ7x+uMGWHTuovl2P8KQVbc7K0iZuwkZMBNBnAiUp/vXTTJLd6jYEJVhTiCYn8MVBlYpc6VmBKdC+hk8iy9nx++ay3CqVVWPgcyOhwkBa+oI4q7jxNmwm6GjRIuJKst4QO9mqRQXmv70c/6ciy0MX5CbhL//UxvfmkHpfa9mt/wUBGhv4yirLYVr7AUJg2RY7y3BzvOFdoWgbjOlBGsldWPSRXoX4FfVWBP5f6iLT7pPgOvoRpiDS1QtGhU9Kln7ZhCwJNR9UP9gDYC5rKHXUaTMaOiVbGgoHqdTtt2NnbdCvw8tHJ83QXbvsKHHdfSkQ01EqJLSPvu6FKEYSxH7UAvHqg2tQ5z8pDllQNzYNCsZmzQMAx+MRRt41PI1RhlufIGHKNc6Pa096bMS5WieSiJO0zooCVvERgxBNY43Jhbvl0RIF8ZeTb4sOWIg6oZL4R/LSpzV1LL292ZPXpZCEpNCSUla0ODqxvAY6ROXstvuLkcjiAnQE7JMS9wkfcl4ixZ/KGt+uKDZj7oXQamR2/1xxSqt0TrxlG2ZJs8D6CXTmpEBSpESkO9ffyv8Sqm0uyxEnFUqBIw7v6HlU437MqxL6mky9e4S98CyCOAdyQ7KSUw0SalWpde4xIm0W5eEQRQb7iiGNXIiehaC51N7x9Y6R125ONMfLC9M4OW4bkm6rKDEDP1unkbW7ZTO2zqLcD7C8QQq13fe7j5wQKmxVjnk=';
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

