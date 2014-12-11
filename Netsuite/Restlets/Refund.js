function createCreditMemo(refund) {

	var rec = nlapiCreateRecord('creditmemo');

	rec.setFieldValue('entity', refund.entity);
	rec.setFieldValue('department', refund.department);

	for ( var i = 0; i < refund.item.length; i++) {
		var counter = (i + 1);
		var item = refund.item[i];

		rec.setLineItemValue('item', 'item', counter, item.item);
		rec.setLineItemValue('item', 'quantity', counter, item.quantity);
		rec.setLineItemValue('item', 'rate', counter, item.rate);
	}

	var creditmemoId = nlapiSubmitRecord(rec);

	return (creditmemoId);
}

function createCustomerRefund(refund, memoId) {

	var rec = nlapiCreateRecord('customerrefund', {
		recordmode : 'dynamic'
	});

	rec.setFieldValue('customer', refund.entity);
	rec.setFieldValue('department', refund.department);
	rec.setFieldValue('account', refund.account);
	rec.setFieldValue('paymentmethod', refund.paymentmethod);
	rec.setFieldValue('location', refund.location);
	rec.setFieldValue('memo', refund.memo);

	var lineCount = rec.getLineItemCount('apply');
	// nlapiLogExecution('DEBUG', 'lines', lineCount);

	for ( var i = 1; i <= lineCount; i++) {
		rec.selectLineItem('apply', i);
		var applyID = rec.getCurrentLineItemValue('apply', 'doc');

		var amountRemaining = rec.getCurrentLineItemValue('apply', 'due');

		// nlapiLogExecution('DEBUG','applyID : amountRemaining :
		// applyIdToApply',applyID + ' : ' + amountRemaining + ' : '
		// +applyIdToApply);

		if (applyID == memoId) {
			rec.setCurrentLineItemValue('apply', 'apply', 'T');
			rec.setCurrentLineItemValue('apply', 'amount', amountRemaining);
			rec.commitLineItem('apply');
		}
	}

	var refundId = nlapiSubmitRecord(rec, true, false);

	return (refundId);
}