function afterSubmit(type) {
	if (type == 'create') {
		var FulfillmentRecord;
		var vProcessFlag = 'y';
		var vFulfillerName;
		var vDepartmentName;
		var vKitLevel;
		var vItem;
		var ccEmail = 'netsuiteemails@successories.com';

		// Added 3/25/14 for email suppression of non shipped items - gWilli
		var vCorporateLocationId = 1;

		var recordType = nlapiGetRecordType();
		var recordId = nlapiGetRecordId();
		FulfillmentRecord = nlapiLoadRecord(recordType, recordId);

		// var vTesting =
		// FulfillmentRecord.getFieldValue('custbody_testing_only');

		// if (vTesting == 'T')
		// {
		var vCustomer = FulfillmentRecord.getFieldValue('entity');
		var vSOId = FulfillmentRecord.getFieldValue('createdfrom');
		var vShipMethod = FulfillmentRecord.getFieldText('shipmethod');
		var vShipCompany = FulfillmentRecord.getFieldValue('shipcompany');
		var vShipAttention = FulfillmentRecord.getFieldValue('shipattention');
		var vShipAddr1 = FulfillmentRecord.getFieldValue('shipaddr1');
		var vShipAddr2 = FulfillmentRecord.getFieldValue('shipaddr2');
		var vShipCity = FulfillmentRecord.getFieldValue('shipcity');
		var vShipState = FulfillmentRecord.getFieldValue('shipstate');
		var vShipZip = FulfillmentRecord.getFieldValue('shipzip');

		var vLines = FulfillmentRecord.getLineItemCount('package');
		var vFedexLines = FulfillmentRecord.getLineItemCount('packagefedex');
		var vUPSLines = FulfillmentRecord.getLineItemCount('packageups');
		var vItems = FulfillmentRecord.getLineItemCount('item');

		var vTrackingNumber = FulfillmentRecord.getLineItemValue('package',
				'packagetrackingnumber', 1);
		var vFedexTrackingNumber = FulfillmentRecord.getLineItemValue(
				'packagefedex', 'packagetrackingnumberfedex', 1);
		var vUPSTrackingNumber = FulfillmentRecord.getLineItemValue(
				'packageups', 'packagetrackingnumberups', 1);

		nlapiLogExecution('DEBUG', 'Start of Fulfillment', 'vSOId  = ' + vSOId
				+ ' vFedexLines = ' + vFedexLines + ' vUPSLines = ' + vUPSLines
				+ ' vTrackingNumber = ' + vTrackingNumber
				+ ' vFedexTrackingNumber = ' + vFedexTrackingNumber
				+ ' vUPSTrackingNumber = ' + vUPSTrackingNumber);

		if (vFedexTrackingNumber != null)
			vTrackingNumber = vFedexTrackingNumber;

		if (vUPSTrackingNumber != null)
			vTrackingNumber = vUPSTrackingNumber;

		// Added 10/5
		// Get the display name of the shipping method
		var vShipMethodDisplayName = '';
		var vShipItemName = '';

		if (vShipMethod != '' && vShipMethod != null) {
			var vShipMethodArray = new Array();
			vShipMethodArray[0] = vShipMethod;

			var filters = new Array();
			filters[0] = new nlobjSearchFilter('custrecord_shipping_item_name',
					null, 'anyof', vShipMethodArray, null);

			var columns = new Array();
			columns[0] = new nlobjSearchColumn(
					'custrecord_shipping_item_display_name');
			columns[1] = new nlobjSearchColumn('custrecord_shipping_item_name');

			var searchresults = nlapiSearchRecord(
					'customrecord_shipping_items_display_name', null, filters,
					columns);

			for ( var i = 0; searchresults != null && i < searchresults.length; i++) {
				var searchresult = searchresults[i];
				vShipItemName = searchresult
						.getText('custrecord_shipping_item_name');

				nlapiLogExecution('DEBUG', 'vShipMethodDisplayName',
						'vShipItemName = ' + vShipItemName
								+ ', vShipMethodDisplayName  = '
								+ vShipMethodDisplayName + ', i = ' + i);

				if (vShipItemName == vShipMethod)
					vShipMethodDisplayName = searchresult
							.getValue('custrecord_shipping_item_display_name');
			}
		}

		nlapiLogExecution('DEBUG', 'Shipping Method Display', 'vShipMethod  = '
				+ vShipMethod + ', vShipMethodDisplayName = '
				+ vShipMethodDisplayName);
		// end of 10/5 change

		// load the sales order
		var SalesOrder = nlapiLoadRecord('salesorder', vSOId);
		var vDepartment = SalesOrder.getFieldValue('department');

		// Load Customer to Check for Email Supression : added 2/13/2014 -
		// gWilli
		var CustomerData = nlapiLoadRecord('customer', SalesOrder
				.getFieldValue('entity'));
		var vSupressEmail = CustomerData
				.getFieldValue('custentity_suppress_fulfillment_email');
		if (vSupressEmail == 'T') {
			return;
		}

		var vOrderDate = SalesOrder.getFieldValue('createddate');
		var temp = new Array();
		temp = vOrderDate.split(' ');
		vOrderDate = temp[0];

		var vOrderNumber = SalesOrder.getFieldValue('tranid');
		var vOrderTotal = SalesOrder.getFieldValue('total');
		var vMLOrderNumber = SalesOrder
				.getFieldValue('custbody_order_source_id');
		var vDYIOrderNumber = SalesOrder.getFieldValue('custbody37');
		var vPaymentMethod = SalesOrder.getFieldText('paymentmethod');

		var vBillCompany = SalesOrder.getFieldValue('billattention');
		var vBillAttention = SalesOrder.getFieldValue('billaddressee');
		var vBillName;
		var vBillAddr1 = SalesOrder.getFieldValue('billaddr1');
		var vBillAddr2 = SalesOrder.getFieldValue('billaddr2');
		var vBillCity = SalesOrder.getFieldValue('billcity');
		var vBillState = SalesOrder.getFieldValue('billstate');
		var vBillZip = SalesOrder.getFieldValue('billzip');

		// Added 10/5
		var vWebOrderId = SalesOrder.getFieldValue('custbody_order_source_id');
		var vCustomerPO = SalesOrder.getFieldValue('custbody_customer_po');
		nlapiLogExecution('DEBUG', 'vWebOrderId', 'vWebOrderId  = '
				+ vWebOrderId + ', vCustomerPO = ' + vCustomerPO);
		// end 10/5 change

		// nlapiLogExecution('DEBUG', 'vBillName', 'vBillName = ' + vBillName +
		// ' vBillCompany = ' + vBillCompany + ' vBillAttention = ' +
		// vBillAttention + ' Tracking Number = ' + vTrackingNumber);

		var vFromID = '12259';
		var vSubject = 'Polaroid Fotobar Shipping Confirmation for Order: '
				+ vOrderNumber;
		var vWebOrderNumber = vMLOrderNumber;

		var vToAddress = SalesOrder.getFieldValue('email');
		// nlapiLogExecution('DEBUG', 'vToAddress', 'vToAddress = ' +
		// vToAddress);

		// Build the body of the email
		var vBody;

		// Email Header
		vBody = '<table style="width: 700px; font-size: 12px; font-family: Arial; vertical-align: text-top; text-align: left;">';
		vBody = vBody + '<tr>';
		vBody = vBody
				+ '<td style="width: 450px; height: 21px" align="left" valign="top">';

		vBody = vBody
				+ '<img src="https://system.na1.netsuite.com/core/media/media.nl?id=14&c=3664828&h=9b79e16898324e93e52f"/>';

		vBody = vBody + '</td>';
		vBody = vBody
				+ '<td style="width: 250px; height: 21px" valign="top" align="left">';
		vBody = vBody + 'Order Date: ' + vOrderDate + '<br />';

		if (vWebOrderNumber != '' && vWebOrderNumber != null)
			vBody = vBody + 'Web Order #: ' + vWebOrderNumber + '<br />';

		vBody = vBody + 'Order #: ' + vOrderNumber + '<br />';

		vBody = vBody + '</td>';
		vBody = vBody + '</tr>';
		vBody = vBody + '</table> <br /><br />';
		vBody = vBody
				+ ' <table style="width: 700px; font-size: 12px; font-family: Arial;">';
		vBody = vBody + '<tr>';
		vBody = vBody + '<td style="width: 700px; height: 21px">';

		vBody = vBody
				+ 'Thank you for your order. The following information will help you track the shipping status of your purchase. If you have any questions or comments, please call Customer Care at 1-800-953-0025 or email us at '
		vBody = vBody
				+ '<a href="mailto:ContactUs@PolaroidFotobar.com">ContactUs@PolaroidFotobar.com</a>.';
		vBody = vBody + '<br /><br /> ';
		vBody = vBody + 'Thanks again for purchasing from Polaroid Fotobar!';

		if (vTrackingNumber != '' && vTrackingNumber != null) {
			vBody = vBody + '<br /><br />Track your package: ';

			if (vFedexTrackingNumber != null) {
				vBody = vBody
						+ '<a href="http://www.fedex.com/Tracking?action=track&tracknumbers='
						+ vTrackingNumber + '">' + vTrackingNumber + '</a>';
			} else if (vUPSTrackingNumber != null) {
				vBody = vBody
						+ '<a href="http://wwwapps.ups.com/WebTracking/processInputRequest?tracknum='
						+ vTrackingNumber + '">' + vTrackingNumber + '</a>';
			}
		}

		vBody = vBody + '</td>';
		vBody = vBody + '</tr>';
		vBody = vBody + '</table><br /><br />';

		// Billing Information
		vBody = vBody
				+ '<table style="width: 700px; font-size: 12px; font-family: Arial; vertical-align: text-top; text-align: left;">';
		vBody = vBody + '<tr>';
		vBody = vBody
				+ '<td style="width: 450px; height: 20px; background-color: #dddddd" align="left" valign="top">';
		vBody = vBody + '<strong>Billing Information</strong>';
		vBody = vBody + '</td>';
		vBody = vBody
				+ '<td style="width: 250px; height: 20px; background-color: #dddddd" valign="top" align="left">';
		vBody = vBody + '<strong>Payment Method</strong>';
		vBody = vBody + '</td>';
		vBody = vBody + '</tr>';
		vBody = vBody + '<tr>';
		vBody = vBody
				+ '<td style="width: 450px; height: 20px;" align="left" valign="top">';
		if (vBillCompany != null && vBillCompany != ''
				&& vBillCompany != vBillAttention)
			vBody = vBody + vBillCompany + '<br />';
		if (vBillAttention != null && vBillAttention != '')
			vBody = vBody + vBillAttention + '<br />';

		if (vBillAddr1 != null && vBillAddr1 != '')
			vBody = vBody + vBillAddr1 + '<br />';
		if (vBillAddr2 != null && vBillAddr2 != '')
			vBody = vBody + vBillAddr2 + '<br />';
		if (vBillCity != null && vBillCity != '')
			vBody = vBody + vBillCity + ', ';
		if (vBillState != null && vBillState != '')
			vBody = vBody + vBillState + ' ';
		if (vBillZip != null && vBillZip != '')
			vBody = vBody + vBillZip;

		vBody = vBody + '</td>';
		vBody = vBody
				+ '<td style="width: 250px; height: 20px;" valign="top" align="left">';
		vBody = vBody + vPaymentMethod;
		vBody = vBody + '</td>';
		vBody = vBody + '</tr>';
		vBody = vBody + '</table><br /><br />';

		// Shipping Information
		vBody = vBody
				+ '<table style="width: 700px; font-size: 12px; font-family: Arial; vertical-align: text-top; text-align: left;">';
		vBody = vBody + '<tr>';
		vBody = vBody
				+ '<td style="width: 450px; height: 20px; background-color: #dddddd" align="left" valign="top">';
		vBody = vBody + '<strong>Shipping Information</strong>';
		vBody = vBody + '</td>';
		vBody = vBody
				+ '<td style="width: 250px; height: 20px; background-color: #dddddd" valign="top" align="left">';
		vBody = vBody + '<strong>Shipping Method</strong>';
		vBody = vBody + '</td>';
		vBody = vBody + '</tr>';
		vBody = vBody + '<tr>';
		vBody = vBody
				+ '<td style="width: 450px; height: 20px;" align="left" valign="top">';
		if (vShipCompany != null && vShipCompany != ''
				&& vShipCompany != vShipAttention)
			vBody = vBody + vShipCompany + '<br />';
		if (vShipAttention != null && vShipAttention != '')
			vBody = vBody + vShipAttention + '<br />';
		vBody = vBody + vShipAddr1 + '<br />';
		if (vShipAddr2 != null && vShipAddr2 != '')
			vBody = vBody + vShipAddr2 + '<br />';

		if (vShipCity != null && vShipCity != '')
			vBody = vBody + vShipCity + ', ';
		if (vShipState != null && vShipState != '')
			vBody = vBody + vShipState + ' ';
		if (vShipZip != null && vShipZip != '')
			vBody = vBody + vShipZip;

		vBody = vBody + '</td>';
		vBody = vBody
				+ '<td style="width: 250px; height: 20px;" valign="top" align="left">';

		// Changed 10/5
		// vBody = vBody + vShipMethod;
		vBody = vBody + vShipMethodDisplayName;
		// end 10/5 change

		vBody = vBody + '</td>';
		vBody = vBody + '</tr>';
		vBody = vBody + '</table><br /><br />';

		// Line Items
		vBody = vBody
				+ '<table style="width: 700px; font-size: 12px; font-family: Arial; vertical-align: text-top; text-align: left;">';
		vBody = vBody + '<tr>';
		vBody = vBody
				+ '<td style="width: 250px; height: 20px; background-color: #dddddd" align="left" valign="top">';
		vBody = vBody + '<strong>Item#</strong>';
		vBody = vBody + '</td>';
		vBody = vBody
				+ '<td style="width: 350px; height: 20px; background-color: #dddddd" valign="top" align="left">';
		vBody = vBody + '<strong>Item Name</strong>';
		vBody = vBody + '</td>';
		vBody = vBody
				+ '<td style="width: 100px; height: 20px; background-color: #dddddd" valign="top" align="left">';
		vBody = vBody + '<strong>Qty Shipped</strong>';
		vBody = vBody + '</td>';
		vBody = vBody + '</tr>';
		vBody = vBody + '<tr>';

		// Item #
		vBody = vBody
				+ '<td style="width: 250px; height: 20px;" align="left" valign="top">';

		var vSendEmail = 'n';
		var vStorePickup;
		var vCreatePO;

		// first let's find out if there are any items that qualitfy for the
		// email

		for (i = 1; i <= vItems; i++) {
			vStorePickup = nlapiGetLineItemValue('item',
					'custcol_store_pickup', i)
			vProductInStore = nlapiGetLineItemValue('item',
					'custcol_produce_in_store', i)
			vCreatePO = nlapiGetLineItemValue('item', 'createpo', i);

			// Added 3/25/14 for email suppression of non shipped items - gWilli
			vItemLocation = nlapiGetLineItemValue('item', 'location', i);

			nlapiLogExecution('DEBUG', 'vStorePickup', 'vStorePickup  = '
					+ vStorePickup + ', vCreatePO = ' + vCreatePO);

			if (vStorePickup == 'F' && vProductInStore == 'F'
					&& vItemLocation == vCorporateLocationId)
				vSendEmail = 'y';
		}

		nlapiLogExecution('DEBUG', 'vSendEmail', 'vSendEmail  = ' + vSendEmail);

		if (vSendEmail == 'y') {

			for (i = 1; i <= vItems; i++) {
				vStorePickup = nlapiGetLineItemValue('item',
						'custcol_store_pickup', i)
				vProductInStore = nlapiGetLineItemValue('item',
						'custcol_produce_in_store', i)
				vCreatePO = nlapiGetLineItemValue('item', 'createpo', i)

				// Added 3/25/14 for email suppression of non shipped items -
				// gWilli
				vItemLocation = nlapiGetLineItemValue('item', 'location', i);

				if (vStorePickup == 'F' && vProductInStore == 'F'
						&& vItemLocation == vCorporateLocationId) {
					vKitLevel = nlapiGetLineItemValue('item', 'kitlevel', i)
					vItem = nlapiGetLineItemText('item', 'item', i)

					nlapiLogExecution('DEBUG', 'vItem', 'vItem  = ' + vItem
							+ ' vKitLevel = ' + vKitLevel);

					if (vKitLevel == null)
						vBody = vBody + nlapiGetLineItemText('item', 'item', i)
								+ '<br />';
				}
			}

			vBody = vBody + '</td>';

			// Item Name
			vBody = vBody
					+ '<td style="width: 350px; height: 20px;" valign="top" align="left">';
			for (i = 1; i <= vItems; i++) {

				vStorePickup = nlapiGetLineItemValue('item',
						'custcol_store_pickup', i)
				vProductInStore = nlapiGetLineItemValue('item',
						'custcol_produce_in_store', i)
				vCreatePO = nlapiGetLineItemValue('item', 'createpo', i);
				// Added 3/25/14 for email suppression of non shipped items -
				// gWilli
				vItemLocation = nlapiGetLineItemValue('item', 'location', i);

				if (vStorePickup == 'F' && vProductInStore == 'F'
						&& vItemLocation == vCorporateLocationId) {
					vKitLevel = nlapiGetLineItemValue('item', 'kitlevel', i)

					if (vKitLevel == null)
						vBody = vBody
								+ nlapiGetLineItemValue('item',
										'itemdescription', i) + '<br />';
				}
			}

			vBody = vBody + '</td>';

			// Shipped Qty
			vBody = vBody
					+ '<td style="width: 100px; height: 20px;" valign="top" align="left">';
			for (i = 1; i <= vItems; i++) {
				vStorePickup = nlapiGetLineItemValue('item',
						'custcol_store_pickup', i)
				vProductInStore = nlapiGetLineItemValue('item',
						'custcol_produce_in_store', i)
				vCreatePO = nlapiGetLineItemValue('item', 'createpo', i)

				if (vStorePickup == 'F' && vProductInStore == 'F') {
					vKitLevel = nlapiGetLineItemValue('item', 'kitlevel', i)

					if (vKitLevel == null)
						vBody = vBody
								+ nlapiGetLineItemValue('item', 'quantity', i)
								+ '<br />';
				}
			}

			vBody = vBody + '</td>';

			vBody = vBody + '</tr>';
			vBody = vBody + '</table><br /><br />';

			// vBody = vBody + '<!-- Begin did-it.com Maestro tracking code.
			// Generated on Tue, 31 Aug 2010 17:26:19 -0400-->'
			// vBody = vBody + '<img
			// src="https://track.did-it.com/n?tid=52178b0caf7e1&ordernum=' +
			// vOrderNumber + '&order=' + vOrderTotal + '">'
			// vBody = vBody + '<!-- End did-it.com tracking code -->'

			nlapiSendEmail(vFromID, vToAddress, vSubject, vBody, null, ccEmail);
		}

		// } // testing only

	}
}