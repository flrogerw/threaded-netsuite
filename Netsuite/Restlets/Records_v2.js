function Records(datain) {

	var record = {
		'status' : 'success',
		'payload' : {}
	};

	var request_args = [ 'method', 'rq' ];

	try {
		// extract args from request
		var request_fields = {};
		for ( var ra in request_args) {
			request_fields[request_args[ra]] = datain[request_args[ra]];
			if (typeof request_fields[request_args[ra]] == 'undefined'
					|| request_fields[request_args[ra]] == null) {
				throw nlapiCreateError('Invalid request', request_args[ra]
						+ ' is not specified.');
			}
		}

		var args = JSON
				.parse(decode64(decodeURIComponent(request_fields['rq'])));

		switch (request_fields['method'].toLowerCase()) {

		case ('bongocontact'):
			return createBongoContact(args);
			break;

		case ('customer'):
			return createCustomer(args);
			break;

		case ('contact'):
			return createContact(args);
			break;

		case ('salesorder'):
			return createOrder(args);
			break;

		default:
			throw nlapiCreateError('Bad Verb', 'System does not understand: '
					+ request_fields['method'].toLowerCase());
			break;
		}
	} catch (exc) {
		record.status = 'failure';
		record.payload = handleException(exc);
		return record;
	}

}

function setAddress(entity, addresses) {

	/* Holds AddressTxt Hash for Comparison */
	var addresshash = new Array();

	/* Netsuite Record of Customer */
	var record = nlapiLoadRecord('customer', entity);

	/* Current Address Book of Customer */
	var addressbook = getAddressbook(record);

	/* Length of Customer's Current Address Book */
	var addressbookCount = addressbook.length;

	/* Data Returned to Client */
	var returnAddrBook = new Array();

	/* Holds Indexes of New Addresses */
	var newIndexes = new Array();

	/* If True, Inserts new Record for Customer with Updated Address Book */
	var addedNew = false;

	/* Build Array of Hashed AddrTxt Field for Comparison to Incoming PayLoad */
	for ( var address in addressbook) {
		addresshash.push(md5(addressbook[address]['text']));
	}

	for ( var i = 0; i < addresses.length; i++) {

		var address = addresses[i];
		if (addresshash.indexOf(md5(getAddressString(address))) == -1) {

			addressbookCount++;
			newIndexes.push(addressbookCount);
			addedNew = true;
			record.selectNewLineItem('addressbook');
			for (key in address) {
				record
						.setCurrentLineItemValue('addressbook', key,
								address[key]);
			}
			record.commitLineItem('addressbook');
			addresshash.push(md5(getAddressString(address)));

		} else {
			var addrIndex = addresshash.indexOf(md5(getAddressString(address)));
			var defaultshipping = (address.defaultshipping != null) ? address.defaultshipping
					: 'F';
			var defaultbilling = (address.defaultbilling != null) ? address.defaultbilling
					: 'F';

			record.setLineItemValue('addressbook', 'defaultshipping',
					(addrIndex + 1), defaultshipping);
			record.setLineItemValue('addressbook', 'defaultbilling',
					(addrIndex + 1), defaultbilling);

			if (typeof addressbook[addrIndex] === 'object') {
				returnAddrBook.push(addressbook[addrIndex]);
			}
		}
	}

	nlapiSubmitRecord(record);

	if (addedNew) {
		var record = nlapiLoadRecord('customer', entity);
		for ( var i in newIndexes) {
			address = new Object();
			address.text = record.getLineItemValue('addressbook', 'addrtext',
					newIndexes[i]);
			address.id = record.getLineItemValue('addressbook', 'id',
					newIndexes[i]);
			returnAddrBook.push(address);
		}
	}
	return (returnAddrBook);
	// nlapiLogExecution('DEBUG', 'xxxxxx ', JSON.stringify( address ) );
}

function getAddressbook(record) {

	var addressbook = new Array();

	for (i = 1; i <= record.getLineItemCount('addressbook'); i++) {
		address = new Object();
		address.text = record.getLineItemValue('addressbook', 'addrtext', i);
		address.id = record.getLineItemValue('addressbook', 'id', i);
		addressbook.push(address);
	}
	return (addressbook);
}

function setAddressBook(record, addressBook) {

	// --- Set Address Book line items.
	var counter = 0;

	for (count in addressBook) {
		counter = parseInt(count) + 1;
		for (key in addressBook[count]) {
			record.setLineItemValue('addressbook', key, counter,
					addressBook[count][key]);
		}
	}
}

function setItems(record, items) {

	// --- Set Address Book line items.
	var counter = 0;
	var addressIdArray = [];
	var addressTextArray = [];
	var entityAddressBook = [];

	if (record.getFieldValue('ismultishipto') == 'T') {

		for (count in items) {
			var item = items[count];
			var addressObj = {
				"attention" : item.attention,
				"addressee" : item.addressee,
				"addr1" : item.addr1,
				"city" : item.city,
				"defaultshipping" : 'F',
				"defaultbilling" : 'F',
				"state" : item.state,
				"zip" : item.zip,
				"country" : item.country,
				"phone" : item.phone,
				"isresidential" : (item.isresidential == null) ? 'T'
						: item.isresidential
			};

			if (item.addr2 != null) {
				addressObj.addr2 = item.addr2;
			}

			entityAddressBook.push(addressObj);
		}
	}

	if (record.getFieldValue('shipaddress') != null
			&& record.getFieldValue('billaddress') != null
			&& md5(record.getFieldValue('billaddress')) == md5(record
					.getFieldValue('shipaddress'))) {
		entityAddressBook.push(getAddressObj(record
				.getFieldValue('shipaddress'), true, true));
	}

	else {

		if (record.getFieldValue('shipaddress') != null) {
			entityAddressBook.push(getAddressObj(record
					.getFieldValue('shipaddress'), false, true));
		}
		if (record.getFieldValue('billaddress') != null) {
			entityAddressBook.push(getAddressObj(record
					.getFieldValue('billaddress'), true, false));
		}
	}

	var addressbook = setAddress(record.getFieldValue('entity'),
			entityAddressBook);

	for (i in addressbook) {
		var address = addressbook[i];
		addressIdArray.push(address.id);
		addressTextArray.push(md5(address.text));

	}

	for (count in items) {
		counter = parseInt(count) + 1;
		for (key in items[count]) {

			record.setLineItemValue('item', key, counter, items[count][key]);
		}

		if (record.getFieldValue('ismultishipto') == 'T') {
			var addrIndex = addressTextArray
					.indexOf(md5(getAddressString(items[count])));
			record.setLineItemValue('item', 'shipaddress', counter,
					addressIdArray[addrIndex]);

		}
	}
}

function createOrder(args) {

	var fulfillLocations = [ 7, 11, 12, 13, 14, 15, 16 ];
	var record = nlapiCreateRecord('salesorder');
	var order = JSON.parse(args.data);
	var response = {};

	// Check For Duplicate Orders
	if (order.hasOwnProperty('custbody_order_source_id')) {

		var isOrder = checkDuplicates(order.custbody_order_source_id);
		if (isOrder > 0) {
			response.recordid = isOrder;
			return (response);
		}
	}
	/*
	 * if (typeof order.addressbook !== 'undefined') { setAddress(order.entity,
	 * order.addressbook); }
	 */

	for ( var fieldname in order) {
		if (order.hasOwnProperty(fieldname)) {
			if (fieldname != 'recordtype' && fieldname != 'item'
					&& fieldname != 'giftcertificateitem'
					&& fieldname != 'addressbook') {
				var value = order[fieldname];
				if (value && typeof value != 'object') {
					record.setFieldValue(fieldname, value);
				}
			}
		}
	}

	if (order.hasOwnProperty('giftcertificateitem')) {
		setGiftCertificates(record, order.giftcertificateitem);
	}

	var bFulFill = (record.getFieldValue('orderstatus') == 'B' && fulfillLocations
			.indexOf(parseInt(record.getFieldValue('location'))) != -1) ? true
			: false;
	setItems(record, order.item);
	var iOrderId = nlapiSubmitRecord(record);

	response.recordid = iOrderId;

	if (bFulFill) {
		try {
			fulfillOrder(iOrderId);
		} catch (e) {
			response.status = 'warn';
			var warn = "Could Not Fulfill Order: " + e.message;
			response.payload = {
				"details" : warn
			};
		}
	}
	return response;
}

function setGiftCertificates(record, gcDataArray) {

	// Apply Gift Certificate

	columns = [];
	filters = [];
	certIdResults = [];
	certCodeResults = [];

	columns.push(new nlobjSearchColumn("giftcertcode"));

	for (count in gcDataArray) {

		filters.push(new nlobjSearchFilter("giftcertcode", null, "is",
				gcDataArray[count]['giftcertcode']));
	}

	var search = nlapiCreateSearch('giftcertificate', filters, columns);

	var resultset = search.runSearch();
	var resultslice = resultset.getResults(0, 100);

	for ( var rs in resultslice) {
		var resultObj = resultslice[rs];
		certIdResults.push(resultObj.getId());
		certCodeResults.push(resultObj.getValue('giftcertcode'));
	}

	for (count in gcDataArray) {
		counter = parseInt(count) + 1;
		var index = certCodeResults.indexOf(gcDataArray[count]['giftcertcode']);
		if (index != -1) {
			record.insertLineItem('giftcertredemption', counter);
			record.setLineItemValue('giftcertredemption', 'authcode', counter,
					certIdResults[index]);
			record.setLineItemValue('giftcertredemption', 'giftcertcode',
					counter, gcDataArray[count]['giftcertcode']);
		} else {
			// ///////////////////// PUT DISCOUNT HERE
			// //////////////////////////////

			var discountAmount = parseInt(record.getFieldValue('discountrate')) || 0;
			var gcAmount = (parseInt(record
					.getFieldValue('custbody_pos_gc_total')) * -1) || 0;
			var newDiscountAmount = (gcAmount + discountAmount);
			var discountItem = (discountAmount > 0) ? 1164 : 1165;

			record.setFieldValue('discountitem', discountItem);
			record.setFieldValue('discountrate', newDiscountAmount);

		}
	}
	// nlapiLogExecution('DEBUG', 'Added the Following Gift Certificates: ',
	// JSON
	// .stringify(certCodeResults));
}

function createBongoContact(args) {

	var response = {};
	var record = nlapiCreateRecord('contact');
	var contact = JSON.parse(args.data);
	;
	for ( var fieldname in contact) {
		if (contact.hasOwnProperty(fieldname)) {
			if (fieldname != 'recordtype' && fieldname != 'id'
					&& fieldname != 'addressbook') {
				var value = contact[fieldname];
				if (value && typeof value != 'object') {
					record.setFieldValue(fieldname, value);
				}
			}
		}
	}

	var entityid = Math.floor(Math.random() * (10000 - 1 + 1)) + 1;
	record.setFieldValue('entityid', entityid + ' ' + contact.firstname + ' '
			+ contact.lastname + ' - ' + contact.email);

	var recordId = nlapiSubmitRecord(record);

	nlapiAttachRecord('contact', recordId, 'customer', contact.entityid, null)

	response.recordid = recordId;
	return response;
}

function createContact(args, contactCount) {

	var response = {};
	var record = nlapiCreateRecord('contact');
	var contact = JSON.parse(args.data);

	for ( var fieldname in contact) {
		if (contact.hasOwnProperty(fieldname)) {
			if (fieldname != 'recordtype' && fieldname != 'id'
					&& fieldname != 'addressbook') {
				var value = contact[fieldname];
				if (value && typeof value != 'object') {
					record.setFieldValue(fieldname, value);
				}
			}
		}
	}

	var entityid = Math.floor(Math.random() * (10000 - 1 + 1)) + 1;
	record.setFieldValue('entityid', entityid + ' ' + contact.firstname + ' '
			+ contact.lastname + ' - ' + contact.email);

	var recordId = nlapiSubmitRecord(record);
	response.recordid = recordId;
	return response;

}

function createCustomer(args) {

	var response = {};
	var record = nlapiCreateRecord('customer');
	var customer = JSON.parse(args.data);

	if (customer['isperson'] == 'F') {
		var existingContact = getExistingContact(customer);
	}

	for ( var fieldname in customer) {
		if (customer.hasOwnProperty(fieldname)) {
			if (fieldname != 'recordtype' && fieldname != 'id'
					&& fieldname != 'addressbook') {
				var value = customer[fieldname];
				if (value && typeof value != 'object') {
					record.setFieldValue(fieldname, value);
				}
			}
		}
	}

	var recordId = nlapiSubmitRecord(record);

	if (record.getFieldValue('isperson') == "F") {
		var contact = createContact(args, existingContact.length);
		nlapiAttachRecord('contact', contact.recordid, 'customer', recordId,
				null)
	}

	response.recordid = recordId;
	return response;
}

function checkDuplicates(orderId) {

	var filters = [];
	var columns = [];

	/* COLUMNS */

	/* FILTERS */
	filters.push(new nlobjSearchFilter("recordtype", null, "is", "salesorder"));
	filters.push(new nlobjSearchFilter('custbody_order_source_id', null, 'is',
			orderId));

	var savedsearch = nlapiCreateSearch('transaction', filters, columns);
	var results = runSearch(savedsearch);

	var iReturn = (results.length > 0) ? results[0]['id'] : 0;
	return (iReturn);
}

/**
 * Proccess search
 * 
 * @param nlobjSearchResult
 *            Object savedsearch
 * @returns void
 */
function runSearch(savedsearch) {

	var results = [];

	var resultset = savedsearch.runSearch();
	var searchid = 0;
	do {
		var resultslice = resultset.getResults(searchid, searchid + 1000);
		for ( var rs in resultslice) {
			results.push(resultslice[rs]);
			searchid++;
		}
	} while (resultslice.length >= 1000);

	return (results);
}