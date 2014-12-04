var custID = 28685;
var applyIdToApply = creditmemoId;
var acctID = 112;
var paymethID = 8;
var departmentId = 7;

var rec = nlapiCreateRecord('creditmemo');

rec.setFieldValue('entity', custID);
rec.setFieldValue('department', 7);

rec.setLineItemValue('item', 'item', 1, 1137);
rec.setLineItemValue('item', 'quantity', 1, 1);
rec.setLineItemValue('item', 'rate', 1, 20);

var creditmemoId = nlapiSubmitRecord(rec);

var rec = nlapiCreateRecord('customerrefund', {
	recordmode : 'dynamic'
});

rec.setFieldValue('customer', custID);
rec.setFieldValue('department', departmentId);
rec.setFieldValue('account', acctID);
rec.setFieldValue('paymentmethod', paymethID);
// rec.setFieldValue('location', );
// rec.setFieldValue('memo', );

var lineCount = rec.getLineItemCount('apply');
nlapiLogExecution('DEBUG', 'lines', lineCount);
for ( var i = 1; i <= lineCount; i++) {
	rec.selectLineItem('apply', i);
	var applyID = rec.getCurrentLineItemValue('apply', 'doc');

	var amountRemaining = rec.getCurrentLineItemValue('apply', 'due');

	// nlapiLogExecution('DEBUG','applyID : amountRemaining :
	// applyIdToApply',applyID + ' : ' + amountRemaining + ' : '
	// +applyIdToApply);

	if (applyID == applyIdToApply) {
		rec.setCurrentLineItemValue('apply', 'apply', 'T');
		rec.setCurrentLineItemValue('apply', 'amount', amountRemaining);
		rec.commitLineItem('apply');
	}
}

var newRecord = nlapiSubmitRecord(rec, true, false);