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

	//$sJson ='{"order":{"_source":"Fotobar","location":1,"department":1,"leadsource":-6,"custbody_order_source":1,"ccprocessor":1,"custbody_order_source_id":"FD50689","trandate":"04\/01\/2014","entity":342609,"item":[{"attention":"Nathan Pelton","addressee":"Pelton Solutions LLC","addr1":"18090 Shamrock Blvd","city":"Big Rapids","state":"MI","zip":49307,"country":"US","phone":2489461046,"shipmethod":1011,"description":"GC50","item":1119,"quantity":1,"rate":50,"subtotal":50,"custcol_produce_in_store":true,"custcol_store_pickup":true,"discounttotal":0,"giftcertnumber":"TEST'.rand(10000,90000).'","giftcertfrom":"Nathan","giftcertrecipientname":"Nathan","giftcertrecipientemail":"npelton@gmail.com","giftcertmessage":"testing","location":1}],"taxtotal":0,"taxrate":0,"shippingcost":0,"handlingcost":0,"discounttotal":0,"total":50,"pnrefnum":"3963828264610176056428","authcode":123456,"paymentmethod":5,"ccname":"Nathan Pelton","ccnumber":"4111111111111111","ccexpiredate":"06\/2018","cczipcode":49307,"shipdate":"04\/04\/2014","customform":107,"ismultishipto":true,"custbody_web_discount_code":""},"customer":{"custentity_customer_source":1,"custentity_customer_source_id":"F50000","firstname":"Nathan","lastname":"Pelton","email":"npelton@gmail.com","isperson":false,"companyname":"Pelton Solutions LLC","custentity_fotomail":"nathan50000+dev@myfotobar.com","addressbook":{"billing":{"addr1":"18090 Shamrock Blvd","city":"Big Rapids","state":"MI","zip":49307,"country":"US","phone":2489461046}},"_source":"Fotobar","custentitycustomer_department":1,"entityid":342609}}';

	//$sJson = '{"order":{"_source":"Fotobar Store 1","location":2,"department":2,"leadsource":2,"custbody_order_source":28,"ccprocessor":1,"custbody_order_source_id":"FD50693","trandate":"04\/08\/2014","entity":342609,"item":[{"addr1":"645 Elmcroft Blvd #13406","city":"Rockville","state":"MD","zip":20850,"country":"US","phone":2489461046,"shipmethod":1011,"description":"Black Shadowbox Polaroid 9 x 11","item":2536,"custcol162":"","quantity":1,"rate":35,"subtotal":35,"custcol_produce_in_store":true,"custcol_store_pickup":false,"discounttotal":0,"location":1,"attention":"Nathan Pelton","addressee":"Shipping Company Name","isresidential":false},{"addr1":"1040 Holland Dr.","city":"Boca Raton","state":"FL","zip":33487,"country":"US","phone":5612264355,"shipmethod":10,"description":"Polaroid 3.5 x 4.25","item":1137,"custcol162":"","quantity":6,"rate":1,"subtotal":6,"custcol_produce_in_store":true,"custcol_store_pickup":false,"discounttotal":false,"location":2,"attention":"Polaroid Fotobar","addressee":"Polaroid Fotobar","addr2":null,"province":""}],"taxtotal":0.36,"taxrate":6,"shippingcost":0,"handlingcost":0,"discounttotal":0,"total":49.31,"pnrefnum":false,"paymentmethod":"","_gcamount":0,"shipdate":"04\/11\/2014","customform":129,"ismultishipto":true,"custbody_web_discount_code":""},"customer":{"custentity_customer_source":3,"custentity_customer_source_id":"F50000","firstname":"Nathan","lastname":"Pelton","email":"npelton@gmail.com","isperson":false,"companyname":"Pelton Solutions LLC","custentity_fotomail":"nathan50000+dev@myfotobar.com","_source":"Fotobar Store 1","custentitycustomer_department":2,"entityid":342609}}';


var_dump(json_decode(decrypt( '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' ),true));

/**
 * 
 *  ["order"]=&gt;
  array(28) {
    ["_source"]=&gt;
    string(7) "Fotobar"
    ["location"]=&gt;
    int(1)
    ["department"]=&gt;
    int(1)
    ["leadsource"]=&gt;
    int(-6)
    ["custbody_order_source"]=&gt;
    int(1)
    ["ccprocessor"]=&gt;
    int(1)
    ["custbody_order_source_id"]=&gt;
    string(7) "FD50698"
    ["trandate"]=&gt;
    string(10) "04/14/2014"
    ["entity"]=&gt;
    int(342609)
    ["item"]=&gt;
    array(1) {
      [0]=&gt;
      array(23) {
        ["addr1"]=&gt;
        string(19) "18090 Shamrock Blvd"
        ["city"]=&gt;
        string(10) "Big Rapids"
        ["state"]=&gt;
        string(2) "MI"
        ["zip"]=&gt;
        int(49307)
        ["country"]=&gt;
        string(2) "US"
        ["phone"]=&gt;
        int(2489461046)
        ["shipmethod"]=&gt;
        int(1011)
        ["description"]=&gt;
        string(4) "GC50"
        ["item"]=&gt;
        int(1119)
        ["quantity"]=&gt;
        int(1)
        ["rate"]=&gt;
        int(50)
        ["subtotal"]=&gt;
        int(50)
        ["custcol_produce_in_store"]=&gt;
        bool(false)
        ["custcol_store_pickup"]=&gt;
        bool(false)
        ["discounttotal"]=&gt;
        int(0)
        ["giftcertnumber"]=&gt;
        string(9) "WVQ8BRZEG"
        ["giftcertfrom"]=&gt;
        string(6) "Nathan"
        ["giftcertrecipientname"]=&gt;
        string(6) "Nathan"
        ["giftcertrecipientemail"]=&gt;
        string(17) "npelton@gmail.com"
        ["giftcertmessage"]=&gt;
        string(4) "test"
        ["location"]=&gt;
        int(1)
        ["attention"]=&gt;
        string(13) "Nathan Pelton"
        ["addressee"]=&gt;
        string(13) "Nathan Pelton"
      }
    }
    ["taxtotal"]=&gt;
    int(0)
    ["taxrate"]=&gt;
    int(0)
    ["shippingcost"]=&gt;
    int(0)
    ["handlingcost"]=&gt;
    int(0)
    ["discounttotal"]=&gt;
    int(0)
    ["total"]=&gt;
    int(50)
    ["pnrefnum"]=&gt;
    string(22) "3974923843800176195842"
    ["authcode"]=&gt;
    int(123456)
    ["paymentmethod"]=&gt;
    int(5)
    ["ccname"]=&gt;
    string(13) "Nathan Pelton"
    ["ccnumber"]=&gt;
    string(16) "4111111111111111"
    ["_gcamount"]=&gt;
    int(0)
    ["ccexpiredate"]=&gt;
    string(7) "02/2017"
    ["cczipcode"]=&gt;
    int(49307)
    ["shipdate"]=&gt;
    string(10) "04/17/2014"
    ["customform"]=&gt;
    int(107)
    ["ismultishipto"]=&gt;
    bool(true)
    ["custbody_web_discount_code"]=&gt;
    string(0) ""
  }
  ["customer"]=&gt;
  array(12) {
    ["custentity_customer_source"]=&gt;
    int(1)
    ["custentity_customer_source_id"]=&gt;
    string(6) "F50000"
    ["firstname"]=&gt;
    string(6) "Nathan"
    ["lastname"]=&gt;
    string(6) "Pelton"
    ["email"]=&gt;
    string(17) "npelton@gmail.com"
    ["isperson"]=&gt;
    bool(false)
    ["companyname"]=&gt;
    string(20) "Pelton Solutions LLC"
    ["custentity_fotomail"]=&gt;
    string(29) "nathan50000+dev@myfotobar.com"
    ["addressbook"]=&gt;
    array(1) {
      ["billing"]=&gt;
      array(7) {
        ["addr1"]=&gt;
        string(19) "18090 Shamrock Blvd"
        ["city"]=&gt;
        string(10) "Big Rapids"
        ["state"]=&gt;
        string(2) "MI"
        ["zip"]=&gt;
        int(49307)
        ["country"]=&gt;
        string(2) "US"
        ["phone"]=&gt;
        int(2489461046)
        ["addressee"]=&gt;
        string(13) "Nathan Pelton"
      }
    }
    ["_source"]=&gt;
    string(7) "Fotobar"
    ["custentitycustomer_department"]=&gt;
    int(1)
    ["entityid"]=&gt;
    int(342609)
  }
}
 * 
 */



	$sJsonArray = array(
	"order"=>
		array(
		"_source"=>"Fotobar",
		"location"=>1,
		"department"=>1,
		"leadsource"=>-6,
		"custbody_order_source"=>1,
		"ccprocessor"=>1,
		"custbody_order_source_id"=>"FDX50689",
		"trandate"=>"04/01/2014",
		"entity"=>342609,
		"item"=>array(
		
		/*
		array(
				"attention"=>"Nathan Pelton",
				"addressee"=>"Pelton Solutions LLC", 
				"addr1"=>"18090 Shamrock Blvd",
				"city"=>"Big Rapids",
				"state"=>"MI",
				"zip"=>49307,
				"country"=>"US",
				"phone"=>2489461046,
				"shipmethod"=>1011,
				"description"=>"GC25",
				"item"=>1155,
				"quantity"=>1,
				"rate"=>25,
				"subtotal"=>25,
				"custcol_produce_in_store"=>false,
				"custcol_store_pickup"=>false,
				"discounttotal"=>0,
				"giftcertnumber"=>"TEST".rand(10000,90000),
				"giftcertfrom"=>"Nathan",
				"giftcertrecipientname"=>"Nathan",
				"giftcertrecipientemail"=>"npelton@gmail.com",
				"giftcertmessage"=>"test",
				"location"=>1),
		
		*/
		
			array(
				"attention"=>"Nathan Pelton",
				"addressee"=>"Nathan Pelton",
				"addr1"=>"18090 Shamrock Blvd",
				"city"=>"Big Rapids",
				"state"=>"MI",
				"zip"=>49307,
				"country"=>"US",
				"phone"=>2489461046,
				"shipmethod"=>1011,
				"description"=>"GC25",
				"item"=>1155,
				"quantity"=>1,
				"rate"=>25,
				"subtotal"=>25,
				"custcol_produce_in_store"=>false,
				"custcol_store_pickup"=>false,
				"discounttotal"=>0,
				"giftcertnumber"=>"TEST".rand(10000,90000),
				"giftcertfrom"=>"Nathan",
				"giftcertrecipientname"=>"Nathan",
				"giftcertrecipientemail"=>"npelton@gmail.com",
				"giftcertmessage"=>"testing",
				"location"=>1),
				
			
			array(
				"attention"=>"Nathan Pelton",
				"addressee"=>"Nathan Pelton",
				"addr1"=>"18090 Shamrock Blvd",
				"city"=>"Big Rapids",
				"state"=>"MI",
				"zip"=>49307,
				"country"=>"US",
				"phone"=>2489461046,
				"shipmethod"=>1011,
				"description"=>"Gift Card $25 Black Wallet",
				"item"=>2499,
				"quantity"=>2,
				"rate"=>25,
				"subtotal"=>25,
				"custcol_produce_in_store"=>false,
				"custcol_store_pickup"=>false,
				"discounttotal"=>0,
				"location"=>1)),
	
		"taxtotal"=>0,
		"taxrate"=>0,
		"shippingcost"=>0,
		"handlingcost"=>0,
		"discounttotal"=>0,
		"total"=>50,
		"pnrefnum"=>"253645576879605",
		"authcode"=>123456,
		"paymentmethod"=>8,
		"ccname"=>"Nathan Pelton",
		"ccnumber"=>"4111111111111111",
		"ccexpiredate"=>"08/2016",
		"cczipcode"=>"12345",
		"shipdate"=>"04/04/2014",
		"customform"=>107,
		"ismultishipto"=>false,
		"custbody_web_discount_code"=>""),
	
		"customer"=>array(
			"custentity_customer_source"=>1,
			"custentity_customer_source_id"=>"F50000",
			"firstname"=>"Nathan",
			"lastname"=>"Pelton",
			"email"=>"npelton@gmail.com",
			"isperson"=>false,
			"companyname"=>"Pelton Solutions LLC",
			"custentity_fotomail"=>"nathan50000+dev@myfotobar.com",
			"addressbook"=>array(
				"billing"=>array(
				"addr1"=>"18090 Shamrock Blvd",
				"city"=>"Big Rapids",
				"state"=>"MI",
				"zip"=>49307,
				"country"=>"US",
				"phone"=>2489461046)),
			"_source"=>"Fotobar",
			"custentitycustomer_department"=>1,
			"entityid"=>342609));



	$sJson = json_encode( $sJsonArray);
	//die();

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

