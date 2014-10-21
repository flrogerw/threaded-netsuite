<?php 
class LivePos_Maps_Order extends LivePos_Maps_Map {

	protected $_aData;



	/*
		//'AuthErrorMessage' => 'custbody_web_payment_error',
	'AdditionalCustomizations' => '_additionalcustomizations',
	'AuthorizationCode' => 'authcode',
	'BillingCompanyName' => 'companyname',
	'BillingAddress1' => 'addr1',
	'BillingAddress2' => 'addr2',
	'BillingCity' => 'city',
	'BillingState' => 'state',
	'BillingProvince' => 'province',
	//'BillingProvince(Other)' => null,
	'BillingZip' => 'zip',
	'BillingCountry' => 'country',
	'BillingPhone' => 'phone',
	'CCType' => 'paymentmethod',
	'CCFullName' => 'ccname',
	'CCNumber' => 'ccnumber',
	'CCMonthExpiration' => '_ccexpiremonth',
	'CCYearExpiration' => '_ccexpireyear',
	'CustomerFirstName' => 'firstname',
	'CustomerLastName' => 'lastname',
	'CustomerE-mail' => 'email',
	'CustomerAccountType' => 'isperson',
	'CustomerCompanyName' => 'companyname',
	'CustomerFotomail' => 'custentity_fotomail',
	'CustomerID' => 'custentity_customer_source_id',
	'Engraving' => 'custbody_logorequired',
	'EngravingDetails' => '_engravingdetails',
	'entityid' => 'entityid',  // REMOVE FOR LIVE TOOL ONLY
	//'EventDate' => 'custbody_event_date',
	//'GiftMessage' => 'message', ///??????
	'GiftCertificateAmount' => '_gcamount',
	'HandlingAmount' => 'handlingcost',
	//'How did you hear about us' => null,
	'ImageSKU' => 'custcol162',
	'ItemDiscountAmount' => 'discounttotal',
	'ItemDiscountCodes' => 'discountitem',
	'Items' => 'description',
	'Message' => 'custbody_textrequired',
	'MessageDetails' => '_messagedetails',
	'MultiShipTo' => 'ismultishipto',
	'NewGiftCertificateCode' => 'giftcertnumber',
	//'NewGiftCertificateAmount' => ,
	'NewGiftCertificateFromName' => 'giftcertfrom',
	//'NewGiftCertificateFromEmail' => ,
	'NewGiftCertificateToName' => 'giftcertrecipientname',
	'NewGiftCertificateToEmail' => 'giftcertrecipientemail',
	'NewGiftCertificateMessage' => 'giftcertmessage',
	'OptionValues' => 'custbody_comments',
	'OrderItemSubtotal' => 'subtotal',
	//'OrderItemTotal' => 'amount',
	'OrderParcelNumber' => '_order_parcel_number',
	'OrderSource' => '_source',
	//'OrderStatus' => 'orderstatus',
	'OrderNumber' => 'custbody_order_source_id',
	'OrderDate' => 'trandate',
	'OrderDiscountAmount' => 'discounttotal',
	'OrderTotal' => 'total',
	'PaymentMethod' => '_paymentmethod_flag',
	//'PurchaseOrderNumber' => 'otherrefnum',
	'PickTicketNotes' => 'custbody_pickticketnotes',
	'PromoCode' => '_promocode',
	'PromoCodeAmount' => '_promoamount',
	'ProduceInStore' => 'custcol_produce_in_store',
	'ProductSKU' => 'item',
	'Qty' => 'quantity',
	//'RequestToken' => 'pnrefnum',
	'SetupFee' => 'setup',
	'ShippingMethod' => 'shipmethod',
	//'SalespersonSalespersonID' => 'salesrep',
	'StorePickup' => 'custcol_store_pickup',
	'ShippingAmount' => 'shippingcost',
	'ShippingAddress' => 'shipaddress',
	'ShippingFirstName' => '_attention1',
	'ShippingLastName' => '_attention2',
	'ShippingCompanyName' => '_companyname',
	'ShippingAddress1' => 'addr1',
	'ShippingAddress2' => 'addr2',
	'ShippingCity' => 'city',
	'ShippingState' => 'state',
	'ShippingProvince' => 'province',
	'ShippingZip' => 'zip',
	'ShippingCountry' => 'country',
	'ShippingPhone' => 'phone',
	'SourceCode' => 'custbody_source_code',
	'TaxAmount' => 'pnrefnum',
	'TaxRate' => 'taxrate',
	'TransactionKey' => 'pnrefnum',
	'UnitPrice' => 'rate'
	);
	*/
	protected $_mapArray = array(
			'intLocationID'  => '_source', // convert to NS ID
			//'strFNUMBER' => 'custbody_order_source_id',
			'dtTransactionDate' => 'trandate',
			//'OrderStatus',
			//'CustomerID' => 'entity',
			'dblTax1' => 'taxtotal',
			//'OrderDiscountAmount',
			'dblGrandTotal' => 'total',
			'intReceiptNumber' => 'otherrefnum',
			'SalespersonSalespersonID',
			//'GiftCertificateAmount',
			//'SourceCode' => 'custbody_source_code',
			//'PromoCode',
			//'PromoCodeAmount',
			'strAuthorizationTransactionID' => 'pnrefnum',
			'strAuthorizationCode' => 'authcode',
			'strCreditCardTypeLabel'  => 'paymentmethod',
			'strCustomPaymentName' => 'ccname',
			'strCreditCardNumberLast4' => 'ccnumber',
			'CCMonthExpiration' => '_ccexpiremonth',
			'CCYearExpiration' => '_ccexpireyear',
			'strPaymentTypeLabel' => '_paymentmethod_flag'
	);


	/**
	 *
	 * @access public
	 * @return void
	*/
	public function __construct( array $aOrder ) {

		parent::__construct();
		$this->_aData = $aOrder;
		$this->_mappedData = $this->_map();
	}
}