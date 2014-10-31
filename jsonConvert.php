#!/usr/bin/php
<?php 

require_once( __DIR__ . DIRECTORY_SEPARATOR . 'Configure.php' );


$xxx= '[{"enumCouponDiscounts":[{"intCouponID":178722,"strCouponCode":"5383","strCouponTargetType":"Per Sale","intItemID":0,"dblDiscountAmount":20.0}],"enumProductsSold":[{"intProductSoldUnits":27,"dblProductSoldNetPrice":0.3103,"enumSerialNumbers":[],"intProductID":0,"intProductCategoryID":0,"intProductStatus":0,"strProductName":"Polaroid 3.5 x 4.25","strProductCategoryName":null,"strProductDescription":null,"strProductSKU":"703040"},{"intProductSoldUnits":1,"dblProductSoldNetPrice":0.6207,"enumSerialNumbers":[],"intProductID":0,"intProductCategoryID":0,"intProductStatus":0,"strProductName":"bubblelope CD holder black","strProductCategoryName":null,"strProductDescription":null,"strProductSKU":"510106"}],"enumPayments":[{"strCheckState":null,"strCheckLicenseNumber":null,"strCheckNumber":null,"strAuthorizationCode":"","strAuthorizationTransactionID":"","strCustomPaymentName":"","strGiftCardCode":"","strGiftCardPIN":null,"strCouponCode":"5383","bIsProcessedExternally":false,"strCreditCardExpiration":"","strCreditCardNumberLast4":"","strCreditCardTypeLabel":"N/A","intCreditCardTypeID":0,"dblAmount":20.0,"intPaymentTypeID":7,"strPaymentTypeLabel":"Coupon","intReceiptNumber":0},{"strCheckState":null,"strCheckLicenseNumber":null,"strCheckNumber":null,"strAuthorizationCode":"","strAuthorizationTransactionID":"0","strCustomPaymentName":"","strGiftCardCode":"","strGiftCardPIN":null,"strCouponCode":"","bIsProcessedExternally":false,"strCreditCardExpiration":"","strCreditCardNumberLast4":"0","strCreditCardTypeLabel":"N/A","intCreditCardTypeID":0,"dblAmount":9.54,"intPaymentTypeID":1,"strPaymentTypeLabel":"Cash","intReceiptNumber":0}],"enumEmployees":[{"intEmployeeID":81291,"strEmployeeExternalID":null,"strEmployeeFirstName":"Christian","strEmployeeLastName":"Bedregal"}],"dblReturnedTotal":0.0,"bIsTaxExempted":false,"bValueAddedTax":false,"intTransactionTypeID":0,"intPaymentTypeID":5,"strCustomerFirstName":" Ordoyne","strCustomerLastName":"Ordoyne","strLocationAddress":"6000 Glades Road #1032C, Boca Raton, FL, 33431, US","strLocationName":"Boca Town Center","strLocationTimeZone":"(GMT-05:00) Eastern Time (US & Canada)","strLocationCurrency":"$","dtTransactionDate":"2014-10-26T14:42:54","intCustomerID":24335768,"intReferenceReceiptNumber":0,"strTransactionTypeLabel":"SALE","strPaymentTypeLabel":"Split","dblTax1":0.54,"dblTax2":0.0,"dblTax3":0.0,"dblGrandTotal":9.54,"intInvoiceNumber":29002530,"intReceiptNumber":23776345,"intLaneID":2,"intLocationID":27449}]';
var_dump(json_decode($xxx));
die();
try {

	/*
		$file_handle = fopen( APPLICATION_DIR . 'TestOrders/POS_TEST.csv', "r");
	while (!feof($file_handle)) {
	$aOutput[] = fgets($file_handle);
	}
	fclose($file_handle);
	$sJson = OrderJSON::convert( $aOutput );
	*/

$xxx = 'nx3arHBVbhV2elo6n7cdf46hqZw+di9SKB7KIWI/3fK5irhS7zouHynVl9AU6btXeq0NIlzFdxgynOL2HTghJPu3+Demtqwt7DdBNGVcmiYaUxDK1QoD8/v44N2vzmYPR1XsNlSIWefdpyNRkYqAQqvDaMHZXn2HthesS5apJL2BHpU8mwVI0UjzHpHuJdq1bw6/xAHdyRe/ykdtYGyYPCrQSdyfPK8HpdXmqvefILLhspSBb8lzgL3FOqwIMof/ZBGarlfJ0GLcXnLfn1hFasHJO8B5vZ50CU9v3D/+4VdGa3lf5kenlCSuN6eHnpX8LU4LGVjIpfpVcXqldhleX6ydt/eZbD41X9Mm03p+mH62PuRoBjpV3NbCGLHIQJxStf2Pkfe/iLFshFobq4GbbLE8tgzZ0FbrcLf3r9VYFivu4CIuIQmoWl9BFXt/5SWj0Jl8ylRtxvlCPcTBOJXF0lzlGX9SCHEUlaJLFWo1+0aNsCtBoVmC/0qvP8q83R0W9aKq1vU35l4q2y8M806SfLrCSwaiMtzKXjB3DxXXlN/7FLwTxyHAV57OmMpFA5G3oKEJUdosrkmHt74/p7UIdJTEL3u3NlLoQiX2kSR5uz1c+YfWwTilkRGKu94K+PENXgMLM6V1c4BHDExVCpJZ1FKx2SOY+kao/aZmKA7z5Q8T299htvaMC/VbZ4/4eZLV3EpU2cfys5S18LT0A+ujFF8QVwLUWw5yhvObyC5UCVohn3KIk8/rUvKfgVOiK1o54YSyCM705TdztAyvZU4Z9Qx+x+jRX2seFc1bBSHoAgyPK5vlW/ftZp3qOL2S9NwXEUHvQTzaPuyqn31K1lCLWNBx3O1x3DqgeQWMTqAdWZO6L4EcOdoAH86D25GAitBTXQKhor6oQHlRtSEOjbI1Lqr7MwzykRsH1HM32MZ4l/JAVz+s/xqJ68HuhRR7JQBI3I2gBqxK7VrR/G+x+NgbzW44sar2vUZE6PIhXhzlQ0mbZvUK31XlxNXpVBHV7ZM0wmFOKd4ozCqQX78Ww1BiJ6nmeFVaGrJ3WCuhcPzqyBk6+kbY9XJXl7cnjFm9fMv0o0RAfYKzqEAjYFGvnOAxuIenx6o2T/IL3NxAmgLYJwZoMtee01e0Rl6PPjLJeVDbEFvwNojy77klpACH27ilVWWjN3w7yz2eFSlGayFwGUld063vDvdE26lSxg+ta+c+rtJCqc32zHDFakCTIGByJ7x+uMGWHTuovl2P8KQVbc7K0iZuwkZMBNBnAiUp/vXTTJLd6jYEJVhTiCYn8MVBlYpc6VmBKdC+hk8iy9nx++ay3CqVVWPgcyOhwkBa+oI4q7jxNmwm6GjRIuJKst4QO9mqRQXmv70c/6ciy0MX5CbhL//UxvfmkHpfa9mt/wUBGhv4yirLYVr7AUJg2RY7y3BzvOFdoWgbjOlBGsldWPSRXoX4FfVWBP5f6iLT7pPgOvoRpiDS1QtGhU9Kln7ZhCwJNR9UP9gDYC5rKHXUaTMaOiVbGgoHqdTtt2NnbdCvw8tHJ83QXbvsKHHdfSkQ01EqJLSPvu6FKEYSxH7UAvHqg2tQ5z8pDllQNzYNCsZmzQMAx+MRRt41PI1RhlufIGHKNc6Pa096bMS5WieSiJO0zooCVvERgxBNY43Jhbvl0RIF8ZeTb4sOWIg6oZL4R/LSpzV1LL292ZPXpZCEpNCSUla0ODqxvAY6ROXstvuLkcjiAnQE7JMS9wkfcl4ixZ/KGt+uKDZj7oXQamR2/1xxSqt0TrxlG2ZJs8D6CXTmpEBSpESkO9ffyv8Sqm0uyxEnFUqBIw7v6HlU437MqxL6mky9e4S98CyCOAdyQ7KSUw0SalWpde4xIm0W5eEQRQb7iiGNXIiehaC51N7x9Y6R125ONMfLC9M4OW4bkm6rKDEDP1unkbW7ZTO2zqLcD7C8QQq13fe7j5wQKmxVjnk=';
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

