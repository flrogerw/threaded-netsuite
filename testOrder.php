#!/usr/bin/php
<?php

$orders = array();


$order = array(
		'enumCouponDiscounts' => array(),
		'enumProductsSold' => array(
				/*  same product quantity 2
				array(
						'intProductSoldUnits' => 2,
						'dblProductSoldNetPrice' => 59.90,
						'enumSerialNumbers' => array(),
						'dblProductSoldTotalTax1' => 3.594,
						'dblProductSoldTotalTax2' => 0,
						'dblProductSoldTotalTax3' => 0,
						'intProductID' => 1929749,
						'strProductName' => 'Silver Metal 8"x8"',
						'strProductSKU' => '700702') 
						*/
				/*  same product 2 line items  */
				array(
						'intProductSoldUnits' => 1,
						'dblProductSoldNetPrice' => 80,
						'enumSerialNumbers' => array(),
						'dblProductSoldTotalTax1' => 0,
						'dblProductSoldTotalTax2' => 0,
						'dblProductSoldTotalTax3' => 0,
						'intProductID' => 1960161,
						'strProductName' => 'Plaque 16x20 Infinty Edge',
						'strProductSKU' => '703005'),
				array(
						'intProductSoldUnits' => 1,
						'dblProductSoldNetPrice' => 80,
						'enumSerialNumbers' => array(),
						'dblProductSoldTotalTax1' => 0,
						'dblProductSoldTotalTax2' => 0,
						'dblProductSoldTotalTax3' => 0,
						'intProductID' => 1960161,
						'strProductName' => 'Plaque 16x20 Infinty Edge',
						'strProductSKU' => '703005'),
				array(
						'intProductSoldUnits' => 1,
						'dblProductSoldNetPrice' => 15,
						'enumSerialNumbers' => array(),
						'dblProductSoldTotalTax1' => .9,
						'dblProductSoldTotalTax2' => 0,
						'dblProductSoldTotalTax3' => 0,
						'intProductID' => 1922092,
						'strProductName' => 'Snapshots Metal Cigar Box',
						'strProductSKU' => '510016'),
				array(
						'intProductSoldUnits' => 1,
						'dblProductSoldNetPrice' => 9.60,
						'enumSerialNumbers' => array(),
						'dblProductSoldTotalTax1' => 0,
						'dblProductSoldTotalTax2' => 0,
						'dblProductSoldTotalTax3' => 0,
						'intProductID' => 1959794,
						'strProductName' => 'Shipped Taxes',
						'strProductSKU' => 'Taxes'),
				array(
						'intProductSoldUnits' => 1,
						'dblProductSoldNetPrice' => 0,
						'enumSerialNumbers' => array(),
						'dblProductSoldTotalTax1' => 0,
						'dblProductSoldTotalTax2' => 0,
						'dblProductSoldTotalTax3' => 0,
						'intProductID' => 1930099,
						'strProductName' => 'Shipping Charge',
						'strProductSKU' => 'Ship'),
		),

		'enumPayments' => array (
				array(
						'strCheckState' => '',
						'strCheckLicenseNumber' => '',
						'strCheckNumber' => '',
						'strAuthorizationCode' => '',
						'strAuthorizationTransactionID' => 0,
						'strCustomPaymentName' => '',
						'strGiftCardCode' => '',
						'strGiftCardPIN' => '',
						'strCouponCode' => '',
						'bIsProcessedExternally' => '',
						'strCreditCardExpiration' => '',
						'strCreditCardNumberLast4' => '',
						'strCreditCardTypeLabel' => '',
						'intCreditCardTypeID' => 0,
						'dblAmount' => 185.5,
						'intPaymentTypeID' => 1,
						'strPaymentTypeLabel' => 'Cash',
						'intReceiptNumber' => 0)
		),

		'enumEmployees' => array(
				array(
						'intEmployeeID' => 81282,
						'strEmployeeExternalID' => '',
						'strEmployeeFirstName' => 'Stefan',
						'strEmployeeLastName' => 'Kwiatkowski')
		),

		'dblReturnedTotal' => 0,
		'bIsTaxExempted' => 0,
		'bValueAddedTax' => 0,
		'intTransactionTypeID' => 0,
		'intPaymentTypeID' => 1,
		'strCustomerFirstName' => 'Karen Scott',
		'strCustomerLastName' => 'Scott',
		'strLocationAddress' => '6000 Glades Road #1032C, Boca Raton, FL, 33431, US',
		'strLocationName' => 'Boca Town Center',
		'strLocationTimeZone' => '(GMT-05:00) Eastern Time (US & Canada)',
		'strLocationCurrency' => '$',
		'dtTransactionDate' => '2014-11-12T15:15:50',
		'intCustomerID' => 24507335,
		'intReferenceReceiptNumber' => 0,
		'strTransactionTypeLabel' => 'SALE',
		'strPaymentTypeLabel' => 'Cash',
		'dblTax1' => .9,
		'dblTax2' => 0,
		'dblTax3' => 0,
		'dblGrandTotal' => 185.5,
		'intInvoiceNumber' => 99999999,
		'intReceiptNumber' => 11111111,
		'intLaneID' => 2,
		'intLocationID' => 27449
);


$orders[] =  $order;
echo(json_encode($orders));