// Get and Set Netsuite Records
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

		case ('customer'):
			return createCustomer(args);
			break;

		case ('contact'):
			return createContact(args);
			break;

		case ('salesorder'):
			return createOrder(args);
			break;

		case ('get_record'):
			return getRecord(args);
			break;

		case ('get_addressbook'):
			return getAddressbook(args);
			break;

		case ('set_address'):
			return setAddress(args);
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

function setAddress(args) {

	/* Holds AddressTxt Hash for Comparison */
	var addresshash = new Array();

	/* Current Address Book of Customer */
	var addressbook = getAddressbook(args);

	/* Length of Customer's Current Address Book */
	var addressbookCount = addressbook.length;

	/* Data Returned to Client */
	var returnAddrBook = new Array();

	/* Holds Indexes of New Addresses */
	var newIndexes = new Array();

	/* If True, Inserts new Record for Customer with Updated Address Book */
	var addedNew = false;

	/* Netsuite Record of Customer */
	var record = nlapiLoadRecord('customer', args.data.id);

	/* Build Array of Hashed AddrTxt Field for Comparison to Incoming PayLoad */
	for ( var address in addressbook) {
		addresshash.push(md5(addressbook[address]['text']));
	}

	for ( var i = 0; i < args.data.address.length; i++) {
		var address = args.data.address[i];
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
		} else {
			var addrIndex = addresshash.indexOf(md5(getAddressString(address)))
			returnAddrBook.push(addressbook[addrIndex]);
		}

	}

	if (addedNew) {
		nlapiSubmitRecord(record);
		var record = nlapiLoadRecord('customer', args.data.id);
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

}

function getAddressbook(args) {

	var record = nlapiLoadRecord('customer', args.data.id);

	var addressbook = new Array();

	for (i = 1; i <= record.getLineItemCount('addressbook'); i++) {
		address = new Object();
		address.text = record.getLineItemValue('addressbook', 'addrtext', i);
		address.id = record.getLineItemValue('addressbook', 'id', i);
		addressbook.push(address);
	}
	return (addressbook);
}

function getRecord(args) {
	var record = nlapiLoadRecord(args.recordtype, args.id);
	return record;
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

	for (count in items) {
		counter = parseInt(count) + 1;
		for (key in items[count]) {
			record.setLineItemValue('item', key, counter, items[count][key]);
		}
	}
}

function createOrder(args) {
	// Validate if mandatory record type is set in the request
	if (!args.recordtype) {
		throw nlapiCreateError('Missing Record Type',
				'This function requires a record type');
	}
	var record = nlapiCreateRecord(args.recordtype);
	var order = JSON.parse(args.data);

	for ( var fieldname in order) {
		if (order.hasOwnProperty(fieldname)) {
			if (fieldname != 'recordtype' && fieldname != 'item' && fieldname != 'giftcertificateitem' ) {
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
	setItems(record, order.item);
	var isOk = nlapiSubmitRecord(record);
	return isOk;
}

function setGiftCertificates(record, gcDataArray) {

	for (count in gcDataArray) {
		counter = parseInt(count) + 1;
		for (key in gcDataArray[count]) {
			record.setLineItemValue('giftcertificateitem', key, counter,
					gcDataArray[count][key]);
		}
	}
}

function createContact(args) {
	// Validate if mandatory record type is set in the request
	if (!args.recordtype) {
		throw nlapiCreateError('Missing Record Type',
				'This function requires a record type');
	}
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

	// setAddressBook(record, contact.addressbook);
	var recordId = nlapiSubmitRecord(record);
	return recordId;
}

function createCustomer(args) {
	// Validate if mandatory record type is set in the request
	if (!args.recordtype) {
		throw nlapiCreateError('Missing Record Type',
				'This function requires a record type');
	}
	var record = nlapiCreateRecord(args.recordtype);
	var customer = JSON.parse(args.data);

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

	setAddressBook(record, customer.addressbook);
	var recordId = nlapiSubmitRecord(record);
	
	if (record.getFieldValue('isperson') == "F") {
		var contactId = createContact(args);
		nlapiAttachRecord('contact', contactId, 'customer', recordId, null)

	}
	return recordId;
}