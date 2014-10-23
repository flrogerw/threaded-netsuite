#!/usr/bin/php
<?php 

require_once( __DIR__ . DIRECTORY_SEPARATOR . 'Configure.php' );


try {

	/*
		$file_handle = fopen( APPLICATION_DIR . 'TestOrders/POS_TEST.csv', "r");
	while (!feof($file_handle)) {
	$aOutput[] = fgets($file_handle);
	}
	fclose($file_handle);
	$sJson = OrderJSON::convert( $aOutput );
	*/



	
$xxx = 'nx3arHBVbhV2elo6n7cdf46hqZw+di9SKB7KIWI/3fJ8Y+XiT7jJQi3nGJkt638aGMqc05737nwmcEzk92/FQ+wR6msIKMwlL8L2XCwDwKQYAAwIkNvd7bEb4jIzQnUWfA3L+OofUBdog7gwGnhtANL6njySGchuN3Fg9NfABmGht9L/cM9EQV4vz/HmO+qy7XNzEoxFnxW0uBI0rfzpd7BuILUy82ek8f/qFQVEOG5LLHkY1wPHnoAfFq2IMneoNa5NbcR3evMX5E6UanjBEbgFX39tBvOxrk36yRFLqQPZauXV3p14s2vgMJa7WZow2VOA9zFhikUm6na+z8z4Ufq2Av/ePDl0/u2p0/ELPaPrUZixTMIWuBtl1Qf7YYZiR+a00cZb93uKSV85l8KQftIbraVdvqKMq+AYt02pxk7lJzSWcBbpgXpmW/3iruEvvOeRNwUmC2PglFDEFTzIIQ3hDg19gV8v72L2bevLDxzXOwjtmvg2eoJayW9NZFMqPKEZFZ100gitPWXOwN2W5b+ZRyBft2WZwPsw7oUHrsjSQo/1yn78PPitrnKPi52lvg47tWECb9Ts/1mKBMOMO5KsdYUXjjvRd9TNSwWXyraOT8LckwlAzNfVrFU1ip5M77CIKlBBFgYRAvcCAGcbGYqNMVZkJRdp5YlkAtix7veDyuCpl/8j71mypb4xj+mS/3ILBR4qKg6b3xTqKAneYWo41J8cTe9A3WjIF741DeTsXof5/zyliV4L7VYWtS2U757Pc6QVcj9YdnrNr0eBGB9P2Rqgvl9r1hWh/6/tJZgrFFA0WTPe6tN+nUqwjDV0q93ku3e6ByKWmTeznulN17cxbMmV9Mmq/Bon/rU7Y/xGEE0Yd/z2+j7ZybYyQ52bxi9XGORgc2Xu70c7tKe/LoDwN03zfsxMVXBp6nXsrcKO9VbozS09kV15Xqtu0lZVy5J7docKyjDEejE616RJPxByOHjiGSrwMN6wb2KrfCWNsGqpFA1CPYzdO+ZO23eT+WuSfHzw0DZtaBmycIEkbNrcwiaLq1k4t54V5zj6conq4upQoI4YS/NbZmfXQhMyQ8boTN9F/IbarRrhrFdkzkVvVMEjyBpZx1I7hB+ZsEO3Dt9In2bFkjvJc5Rh0/nJvkUvCS0C8ORYC2Ts+OsXGd+/iKTYRi4KknyGAullxxLlqUjVDIEfwTM4jvXz1NE8iiA4sCQdWa3AXJVE8WYkDtUveRtzVIW3IlDUszQznrdwMDpmZndqbp6COo1iRcaP0DfxWGeb3wU5GoaUBTmA1dKWoSp/BNFcWCO8bSwx/e4Id7cgWeb3dMfpbDO5HG0dBaIHfMJpGdV1zgVYKT0pzs2Qg4pIhbpQfc8KfAEPptcMv22TtyoEakWsu3a2WKHzm7IM+BLkjV8Ajhu9iDxUvxo6JVsaCgep1O23Y2dt0K/Dy0cnzdBdu+wocd19KRDTUSoktI++7oUoRhLEftQC8eqDa1DnPykOWVA3Ng0KxmbNAwDH4xFG3jU8jVGGW58gYco1zo9rT3psxLlaJ5KIkzFYgPJXWEOLMdl77+kxOZCiSQj/GRAJShksecOWEwKSBMOYUrhdMtCmVlcfP7vAsptyXK6CCfxoG353/VwF74hgGZkL4iEDz3xBIPL7LIbWSMkaA1cpOFcVFgkN3PIBQ+kqSOROcNU/+4mn2XSXqDPYZcrbWL+ezHQ7pXjuzPCyL0dzeaiOr++r/TBic4Ehyn2jyoepIz+8Jzc1TMOZ6G29kSQ+rukxKsc8JUq5EV27yxfhXhe6TFphu+TPxTe1Obf9Qq9A/9ONZMiueJhPy3OXhhfdH2nsbU1P5497unpcXl1JBm/WBhKToeAV0IrNQoH87Nblnv56cSVk973EcVg=';
$xxx = 'nx3arHBVbhV2elo6n7cdf46hqZw+di9SKB7KIWI/3fK5irhS7zouHynVl9AU6btXeq0NIlzFdxgynOL2HTghJPu3+Demtqwt7DdBNGVcmiYaUxDK1QoD8/v44N2vzmYPR1XsNlSIWefdpyNRkYqAQqvDaMHZXn2HthesS5apJL2BHpU8mwVI0UjzHpHuJdq1bw6/xAHdyRe/ykdtYGyYPCrQSdyfPK8HpdXmqvefILLhspSBb8lzgL3FOqwIMof/ZBGarlfJ0GLcXnLfn1hFasHJO8B5vZ50CU9v3D/+4VdGa3lf5kenlCSuN6eHnpX8LU4LGVjIpfpVcXqldhleX6ydt/eZbD41X9Mm03p+mH62PuRoBjpV3NbCGLHIQJxStf2Pkfe/iLFshFobq4GbbLE8tgzZ0FbrcLf3r9VYFivu4CIuIQmoWl9BFXt/5SWj0Jl8ylRtxvlCPcTBOJXF0lzlGX9SCHEUlaJLFWo1+0aNsCtBoVmC/0qvP8q83R0W9aKq1vU35l4q2y8M806SfG7mVEXJrE6hhqOCgwQITBnO3rLnARFM46qNUCYqlhhnzdBvBCLbKbhvtbifvIC9kED1cZD7+VCTsyBX/41CQgjF3AI6lpqT5HvVNN4ll+ciycDv1yGdh4bRCIl9rGUGzl9BHVQXtB4Mj18q4RZNPv9+UgmbP2UlPDvKyG9e0kgxLbdtSAY1cOmHUc2MZbEugSYtKfS/p9cY2B3QypxtNAxrFDn0BLvzijv71AGCm+wREv0YnrqvcGuYrtsBF0wwmjJkUNEEU5nlO8+nAwcTHxP+PrD2wIrV2lVua5NsWFotFbStIsE0f/QacyeSlC3Hn4q3wh1VAEhQH4IY5k8DmRflJzSWcBbpgXpmW/3iruEvWNpCE6DBi1s8rLlI/a9Zbvv0cvHn1HY+n2GH4ggmMa6zLyDQeSQRqomvpDlm94GeuYQ7ztq0YfwJVUKKLBhOAV9dAXEPTZC6+q5eL03mRUG+Dju1YQJv1Oz/WYoEw4w7VECsW41lnpvnKEdCKsljsQVJuoOEuG+Km2QOcHQMeIP2hwvo0EGfO63DslOEODzKd9MLy5TRcerZt7KXAn/Uy/9pXcutcSEB/alj6VEhP10YbjviIF/lGsqe7xYAWC2/keZJb+4NTJhkLNEquHYwNivFOXJcMoz0wKMELfo+sFC4Ny3wBTyyK+7mi8Oa8VTOudZz/HCoD2krwqUFmFiz4pbj39Bx+zdBqMa9rz/uCoCPVKczpuN0q8X7l8/VrPgOeZ3v82s0N7yU0LAVFQifJoZToGMw6BIsRYVIxD/G55z8WTVqE9ENCdgU+0osxWysVkdlDp64uu2Ow5lPOljhtcnuYpn0AhtYosLA+B7kMYy3REkp7HgJDqOev26j2A3AYYwFEo0sa7hHFmWYrnhGuBXj/67YI7jzPUwtScxkdknvIrUGm6PVYz5LujBT+ce+AIKTPLvGgIdEIiWATByeWscKSfyVo0TObU+L5MUCUh7P9w4dY4J3hGVe+x7/bsIXmm6FhAmq4QP3fY3x1EhpNNf2cPkjBw4vu8QZKNypSrqgIsHSXRzSEwSZrBFYlWO06k5vbnyiyk1pBwtz6U6y9p5lPBRs1Vdz+cQycu/dcAE+zda/4/O6bA1Noq6wwFqfnR+fUTIzVBP3uZbcEpLCOVvJ7j+lV7jF7xk60Wukbr4dqc5Ojn2OYJYRj4XeaImge51BAoGmH5SlZAoEO7tClkJwBguFx2KwCeORxMLTcbfbZFl7C77MBRKiAwK/qr8ZzS+N6sjXCIrkEW6AwSOR70mMlsHZzEqu6A9bLnPpChjCuCgOS70bB8pDWiIzM5vrV9+H//5sNqyWKRNCAwbEDMJ45A9P7vPlmYGSx+eJFu/XOwjtmvg2eoJayW9NZFMqmQSjuflATUCo8QfWbmoXL12FiZ+/79Xzh/sLF3jPD2f3OxcyQq/L8XsohKNB7FkZA1HGMCZkOb5a+Pw4ITbrIzRna75ZWEjR1ZgcP51lOv2zeNQWmf8Abd1SNfqZTV1vGUIIdCxGfvJotUxxPE01C7xeODvXK39t/oWV9HHfgVSlUkPHrK6hw82609bDgJ/5onKIIBf0Z0qgQ2XuuaDzBg1+oBfiX6bg8DVYAJWuBhDvAJNyCUkiDv5W6SoNUe8RK3usA2SEm2AdIgZYOnXhdguWb5Ncg+yihCwSJMF1C2Yk/vvVc0Y8c/LVEximeGcraKdYH0dV8YAVACV1VRSbiCO7dQkh3t08sqSIaPoqAQxBu87m7tA9mN34nlxjPXpIveYrnQQ63+Tf3JsMCFJvRIPJ9G3iFHFn6vhnr/4YH/eIMXA0ckbT3MzfFMMGOwmmJAkcTTI9Abe+0UdgK2Gs64uMAoS6h3kruwigw6+CzF+8rxlkPlHKszOTErT9yOhuAkSJ4C+YPpGwYxj4t7vvOFEEdVHsFS8lNFoufHEYl0OMkwzyeBJf5LFfQEv1ji7SwZmXwO8MXnZSGhuBzeX9W29c9RZ1LLgFv756oEzlWOuTdkv1AQuYFrjN8KDZRv67Qfvil0zGr3WRdhQHVEKRl/B8iNQTQrR4X8C1b1X6Vv2IoCxjGe2YvajVjO/48/ZCwG4yw2DNz4Kf1/PV07yKYcBWjEU9IRc4rsYwDI5pxBstt21IBjVw6YdRzYxlsS6B9hlvNLk+ZybVIN0qmFGoYBEAwsbnZDM7Xtrudz7AMePfdxSK4T96vD21fjtGTr5cL6DnBDSDOg+n3A+aDjt7KS5/v/NfrxSiNoXhT0v6vsCfYfksIPM7S7tRESt5l41AKC4KNuhLdibUnlbFYPGxUSdzoSQDk0QA5/TvCsF0LT12iFx72eNeONKivaa00WeGBh/whAB8WIuH9Xmb2vkQzhsHSwMVh+SCUyK0/mSayptGKjRr9QVhfaetZcG+sbaorI2bzrrNdN05txkSe0Px+KJ5vVS13EZIkVh+nvoeJy6AFbDbB16eF4C9HIS/Wg6jFw0PJKiLarZ9s8TlC4knq5MULnyHLk0ALIUkx4CsWhCKapxIoN9lMQI6J2ehiN0c9/4jVCaUGs7O0PHdhVUmIZj/+ZL+IwaZqc9O1ntVNmN+kFZTMDXp8/ahXJuVcVx9unWdfFXLq3wTJgThRAYlGzDJ8iiARUbtIUkByGfCt9/Te7uBIr/KvXB0KHBbf653UIZkInenMe7OZFVbH9gUakhYYV5ebifKtBsMPBV6u0r76r0JXh583RkgrGD7VqcqqfQeuHNI7QSSGvrWBjrcxEx3f7F2MGpR+MwY+wAxYpj5/bKtIcjjyNnv1khAQK0Gos+1aH5TcvM1fKTJlIy8JRMuWvYnGdRK3iTYJgp3AOTlvPtxeVdRwGKFJV6m4gkY+JF3sUgjprQLrrSi4nhIsr3RBFvY0/lJ8GVJ7WdVvJUoqK9xJXstrFc4ACVdP7idzhD2vzLIbzyAPoIIIGXSalk9B8lhE+gmonxGgoBKbiiSLQumgAikGKlHp1l9iNSJG3l5sHtvytYBmJwRv2eA4h4d31Ho7xHHosGQPFsIKoliJ0Crgh0eXtqdeYAOD5ATQWZh3xlVI2jWvV50E6tDQU5pHiguqdk4qMn3Gdbt+2nA+u2ZKlsRp0QDBoafZI/4rGj1s++z5ZtDhaQ7wcH3NdFXy0yC9ETcFY2Llln6jGDSSv0DVhZG2RHBV+X+vRV5kUNkNquWVEzEm3iH8rYlzLnqQoEcKDwv8So+fOeY8dv2rlUc/LbQsRbjoAmXesGwPpZpYSVZ5Gloj5Bt6euv0gRB7+hcmo3dHaITjHbxy5HO5kPPL/GluSC1QNLDdG+8/IL311uTWR/N3P8/mfaAdIbrOzPv6hORrzbv9SIWxDCBWgYC9V1TgTI11GesV4YEVVmhAKoM+z8s3baTg2qlKnQgU2GXtfwrL+tF3rbB4KePKk6egEG8kj5PDbIQt69zu7B4pKUNcm3V+3ubuj3jR0wUc5ApGCBOTw+XUXcKgSPEK5cbtRunSdnb79jvNwdnWk8YBV2PIkOgwAWHNPa3BX2jyoepIz+8Jzc1TMOZ6G29kSQ+rukxKsc8JUq5EV27IlzdSWhrL/6Aq5xoYYaHrLf9Qq9A/9ONZMiueJhPy3OimErwXEfOAKoQiqTFZZXpbPCl7/EJxHpqsnUPiM+LM1yGMwYxdkYdpNyq9Lj8Ahc=';
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

