<?php 

$aSalesOrder = array(
		'_source' => 'fotobar',
		'items' => array(

				array(	'amount'=>8.96,
						'custcol_produce_in_store' => false,
						'custcol_store_pickup' => false,
						'custcol162' => 'CUSTOM',
						'description'=>'Polaroid Matboard Print 9"x11"',
						'discountitem' => null,
						//'isclosed' => false,
						//'isestimate'=>false,
						//'istaxable'=>true,
						'item'=>703040,
						'quantity'=>3,
						'custbody_comments'=>'',
						'rate'=>9.95,
						//'shipaddress' => '',
						'shippingcost'=>'',
						'_attention1'=>'Roger',
						'_attention2'=>'Williams',
						'_companyname'=>'',
						'addr1'=>'15991 Forsythia Circle',
						'addr2'=>'',
						'city'=>'Delray Beach',
						'state'=>'FL',
						'province'=>'',
						'zip'=>'33484',
						'country'=>'',
						'phone'=>'1231231234',
						'shipoverride' => false

				)),

		'order' => array(

				'_ccexpireyear' => 2015,
				'_ccexpiremonth' => 12,
				'_paymentmethod_flag' => 'creditcard',
				'_source' => 'fotobar',
				'authcode' => 3344,
				'ccapproved' => true,
				'ccname' => 'grant petersen',
				'ccnumber' => '4111111111111111',
				//'custbody_activa_order_number' => 'F12345',
				'custbody_order_source' => 'web',
				'custbody_order_source_id' => 'F12345',
				'custbody_pickticketnotes' => 'TEST ORDER - DO NOT SHIP',
				'customform' => 107,
				'discounttotal' => 0,
				'email' => "chessart@christyscatering.com",
				'engraving' => true,
				'engravingdetails' => 'Hello World',
				'exchangerate' => 1.00,
				'fax' => "831-555-5230",
				'getauth' => false,
				'handlingcost' => 0,
				'ismultishipto' => true,
				//'istaxable' => true,
				'message' => false,
				'messagedetails' => null,
				//'orderstatus' => "A",
				'paymentmethod' =>'visa',
				'recordtype' => "salesorder",
				'taxrate' => 8.25,
				'taxtotal' => 4.45,
				'tobeemailed' => false,
				'tobefaxed' => false,
				'tobeprinted' => false,
				'total' => 64.04,
				'tranid' => 120,
				'trandate' => "09/05/2013",
				'salesrep' =>null,
				'shipcomplete' => false,
				'shipmethod' => 'UGR',
				'shippingcost' => 5.67 ),

		'addressbook' => array(
				'shipping' => array(
						'label' =>null,
						'attention' => null,
						'addressee' => 'Grand Central Station',
						'addr1' => '123 Main Street',
						'addr2' => 'Suite 122',
						'addr3' => null,
						'city' => 'New York',
						'state' => 'NY',
						'province' => null,
						'zip' => 12345,
						'country' => 'US',
						'phone' => '123-123-1234',
						'defaultshipping' => true),

				'billing' => array(
						'label' =>null,
						'attention' => null,
						'addressee' => 'Grand Central Station',
						'addr1' => '123 Main Street',
						'addr2' => 'Suite 122',
						'addr3' => null,
						'city' => 'New York',
						'state' => 'NY',
						'province' => null,
						'zip' => 12345,
						'country' => 'US',
						'phone' => '123-123-1234',
						'defaultbilling' => true)),

		'customer' => array(
				'companyname'=>'Cookie Monster Inc',
				'email' => "chessart@christyscatering.com",
				'firstname' => 'John',
				'lastname' => 'Smith',
				'custentity_customer_source_id' => 'F36714',
				'isperson' => false,
				'phone' => '650-627-1000',
				'custentity_fotomail' => 'bob@myfotobar.com',
				'entitystatus' => '',
				'entityid' => null
		));



$aCustomer = $aSalesOrder['customer'];
$aOrder = $aSalesOrder['order'];
$aItems = $aSalesOrder['items'];
$aAddressBook = $aSalesOrder['addressbook'];

