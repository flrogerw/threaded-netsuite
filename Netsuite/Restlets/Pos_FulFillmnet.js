salesOrder = nlapiLoadRecord('salesorder', 802419);
nlapiLogExecution('Debug', 'onAFterSubmit', 'load status '
		+ salesOrder.getFieldValue('orderstatus'));

var location = salesOrder.getFieldValue('location');
nlapiLogExecution('Debug', 'afterSubmit', 'header location - ' + location);
if (location == '1') {
	nlapiLogExecution('Debug', 'afterSubmit', 'Location is Corporate');
	// return;
}
var lineItemCount = salesOrder.getLineItemCount('item');
nlapiLogExecution('Debug', 'onAfterSubmit', 'lineItemCount - ' + lineItemCount);

// Start creating fulfillment
var fulfillment = nlapiTransformRecord('salesorder', salesOrder.getId(),
		'itemfulfillment');

var bin, itemType;
for ( var i = 1; i <= lineItemCount; i++) {
	try {

		itemLocation = salesOrder.getLineItemValue('item', 'location', i);
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
		nlapiLogExecution('Debug', 'onAfterSubmit', 'Item Type - ' + itemType);
		if (itemType != 'Kit') {
			bin = getBinNumber(fulfillment.getLineItemValue('item', 'location',
					i));
			fulfillment.setLineItemValue('item', 'binnumbers', i, bin);
		}

	} catch (e) {
		nlapiLogExecution('Error', 'onAfterSubmit', 'Error ' + e.message);
	}
}

var fulfillmentId = nlapiSubmitRecord(fulfillment);
nlapiLogExecution('Debug', 'onAfterSubmit', 'fulfillmentId - ' + fulfillmentId);

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