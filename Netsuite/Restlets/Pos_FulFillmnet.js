function main() {
}

function fulfillOrder(iOrderId) {

	salesOrder = nlapiLoadRecord('salesorder', iOrderId);
	// nlapiLogExecution('Debug', 'fulfillOrder', 'load status ' +
	// salesOrder.getFieldValue('orderstatus'));

	var location = salesOrder.getFieldValue('location');

	if (location == '1') {
		return;
	}
	var lineItemCount = salesOrder.getLineItemCount('item');

	// Start creating fulfillment
	var fulfillment = nlapiTransformRecord('salesorder', salesOrder.getId(),
			'itemfulfillment');

	var bin, itemType;
	for ( var i = 1; i <= lineItemCount; i++) {
		try {

			itemLocation = salesOrder.getLineItemValue('item', 'location', i);

			// Unfulfill line items that do not match the header location
			if (itemLocation != location) {
				fulfillment.setLineItemValue('item', 'itemreceive', i, 'F');
				continue;
			}

			itemType = fulfillment.getLineItemValue('item', 'itemtype', i);

			if (itemType != 'Kit') {
				bin = getBinNumber(fulfillment.getLineItemValue('item',
						'location', i));
				fulfillment.setLineItemValue('item', 'binnumbers', i, bin);
			}

		} catch (e) {
			nlapiLogExecution('Error', 'onAfterSubmit', 'Error ' + e.message);
		}
	}

	var fulfillmentId = nlapiSubmitRecord(fulfillment);
}

/*******************************************************************************
 * Returns binnumber based on location
 * 
 * @param location
 ******************************************************************************/
function getBinNumber(location) {

	switch (parseInt(location)) {

	case (7):
		return 'BocaTC';
		break;
	case (11):
		return 'Culver';
		break;

	}

}