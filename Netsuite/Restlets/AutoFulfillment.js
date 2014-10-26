/*******************************************************************************
 * Creates fulfillment from sales order based on Location settings of header and
 * line items
 * 
 ******************************************************************************/
function onAfterSubmit() {

	try {
		if (type == 'delete')
			return;

		var deposit = nlapiGetNewRecord();

		var salesOrder = nlapiLoadRecord('salesOrder', deposit
				.getFieldValue('salesorder'));

		var location = salesOrder.getFieldValue('location');
		nlapiLogExecution('Debug', 'onAfterSubmit', 'header location - '
				+ location);
		if (location == '1') {
			nlapiLogExecution('Debug', 'onAfterSubmit', 'Location is Corporate');
			return;
		}

		// check that deposit payment amount matches total salesorder
		var salesOrderTotal = parseFloat(salesOrder.getFieldValue('total'));
		var depositPayment = deposit.getFieldValue('payment');

		if (salesOrderTotal != depositPayment) {

			depositPayment = parseFloat(getDepositTotal(salesOrder.getId()));

			if (salesOrderTotal != depositPayment) {
				nlapiLogExecution('Debug', 'onAfterSubmit', 'Not 100% deposit');
				nlapiLogExecution('Debug', 'onAfterSubmit', 'salesOrderTotal='
						+ salesOrderTotal);
				nlapiLogExecution('Debug', 'onAfterSubmit', 'depositPayment='
						+ depositPayment);
				return;
			}
		}

		// Check for line items to see if any have location, 'Corporate
		var lineItemCount = salesOrder.getLineItemCount('item');
		nlapiLogExecution('Debug', 'onAfterSubmit', 'lineItemCount - '
				+ lineItemCount);

		var itemLocation, hasLocation = false;
		for ( var i = 1; i <= lineItemCount; i++) {

			try {
				itemLocation = salesOrder.getLineItemValue('item', 'location',
						i);

				if (itemLocation == location) {
					hasLocation = true;
					break;
				}
			} catch (e) {
				nlapiLogExecution('Error', 'run', 'Error ' + e.message);
			}
		}

		// Don't do anything if there is no line item that match the header
		// location
		if (!hasLocation) {
			nlapiLogExecution('Debug', 'onAfterSubmit',
					'No line items matching header location');
			return;
		}

		// set sales order status to pending fulfillment
		salesOrder.setFieldValue('orderstatus', 'B');
		var id = nlapiSubmitRecord(salesOrder);
		nlapiLogExecution('Debug', 'onAfterSubmit', 'salesorder id - ' + id);

		// var test = nlapiLoadRecord('salesorder', id);
		// nlapiLogExecution('Debug', 'onAFterSubmit', 'status ' +
		// test.getFieldValue('orderstatus'));

		// Start creating fulfillment
		var fulfillment = nlapiTransformRecord('salesorder',
				salesOrder.getId(), 'itemfulfillment');

		var bin, itemType;
		for ( var i = 1; i <= lineItemCount; i++) {
			try {

				itemLocation = salesOrder.getLineItemValue('item', 'location',
						i);
				nlapiLogExecution('Debug', 'onAfterSubmit', 'line item - ' + i
						+ ' location - ' + itemLocation);

				// Unfulfill line items that do not match the header location
				if (itemLocation != location) {
					fulfillment.setLineItemValue('item', 'itemreceive', i, 'F');
					nlapiLogExecution('Debug', 'onAfterSubmit',
							'Line does not match header location - ' + i);
					continue;
				}

				itemType = fulfillment.getLineItemValue('item', 'itemtype', i);
				if (itemType != 'Kit') {
					bin = getBinNumber(fulfillment.getLineItemValue('item',
							'location', i));
					fulfillment.setLineItemValue('item', 'binnumbers', i, bin);
				}

			} catch (e) {
				nlapiLogExecution('Error', 'onAfterSubmit', 'Error '
						+ e.message);
			}
		}

		var fulfillmentId = nlapiSubmitRecord(fulfillment);
		nlapiLogExecution('Debug', 'onAfterSubmit', 'fulfillmentId - '
				+ fulfillmentId);

		createInvoice(fulfillment);

	} catch (e) {
		nlapiLogExecution('Error', 'onAfterSubmit', 'Error ' + e.message);
	}
}

/*******************************************************************************
 * Adds up total customer deposit payment amounts from sales order
 * 
 * @param salesOrderId
 * @returns {Number}
 ******************************************************************************/
function getDepositTotal(salesOrderId) {

	var searchFilter = new nlobjSearchFilter('salesorder', null, 'is',
			salesOrderId);

	var searchResults = nlapiSearchRecord('customerdeposit', null, searchFilter);

	if (searchResults == null)
		return;
	nlapiLogExecution('Debug', 'getDepositTotal', 'searchresults length - '
			+ searchResults.length);

	var customerDeposit, customerDepositTotal = 0.00;
	for ( var i = 0; i < searchResults.length; i++) {
		try {
			customerDeposit = nlapiLoadRecord('customerdeposit',
					searchResults[i].getId());

			nlapiLogExecution('Debug', 'getDepositTotal', 'deposit payment - '
					+ customerDeposit.getFieldValue('payment'));
			customerDepositTotal += parseFloat(customerDeposit
					.getFieldValue('payment'));

		} catch (e) {
			nlapiLogExecution('Error', 'getDepositTotal', 'Error ' + e.message);
		}
	}
	nlapiLogExecution('Debug', 'getDepositTotal', 'customerDepositTotal - '
			+ customerDepositTotal);

	return customerDepositTotal;

}

/*******************************************************************************
 * Returns binnumber based on location
 * 
 * @param location
 ******************************************************************************/
function getBinNumber(location) {
	if (location == '7')
		return 'BocaTC';
	else if (location == '2')
		return 'Delray';
	else if (location == '9')
		return 'Linq';
	else if (location == '5')
		return 'Miami';
	else if (location == '4')
		return 'Orlando';
	else if (location == '8')
		return 'Q1';
}