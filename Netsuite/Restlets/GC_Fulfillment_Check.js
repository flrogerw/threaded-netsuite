/**
 * Checks for Giftcertificate if Wallet item in Sales Order
 * 
 * @author gWilli
 * 
 */

var debug = true;

var items = {

	additem : function(itemname, quantity, internalid) {

		var itemKey = this.isitem(itemname);
		var item = this[itemKey];
		item.internalid = internalid;
		item.quantity = item.quantity + parseInt(quantity);
		item.dependencies = this.getdependents(itemKey);
		item.requiredby = 0;
		item.errors = [];
	},

	getdependents : function(itemname) {

		// Add logic here
		if (itemname == 'GC25BlkWallet') {
			return ("GC25");
		} else {
			return null;
		}
	},

	isitem : function(itemname) {

		itemname = itemname.replace(/\s+/g, '');
		if (typeof (this[itemname]) === "undefined") {
			this.createitem(itemname);
		}
		return itemname;
	},

	createitem : function(itemname) {

		this[itemname] = {
			"quantity" : 0
		};
	},

	setdependents : function() {

		for (i in items) {

			var item = items[i];
			if (item.dependencies != null) {
				var itemKey = this.isitem(item.dependencies);
				this.updaterequiredby(itemKey, item.quantity);
			}

		}
	},

	updaterequiredby : function(itemname, quantity) {
		items[itemname]['requiredby'] = items[itemname]['requiredby']
				+ quantity;
	},

	checkfulfillment : function() {
		for (i in items) {

			var item = items[i];
			if (item.quantity < item.requiredby) {
				item.errors.push(i + ' Requires ' + item.requiredby + ' only '
						+ item.quantity + ' ordered');
			}

		}
	},

	haserrors : function() {

		var errors = [];

		for (i in items) {
			var item = items[i];
			nlapiLogExecution('DEBUG', 'error array', item.errors);

			// if( item.errors.length > 0 ){
			for (e in item.errors) {
				errors.push(item.errors[e]);
			}
			// }
		}
		var returnstring = (errors.length > 0) ? errors.join() : false;
		return (returnstring);
	}

};

function beforeLoad(type) {

	if (nlapiGetContext().getExecutionContext() == "userinterface") {

		try {

			// load our record
			var record = nlapiGetNewRecord();

			// count # of items on order
			var numofitems = parseInt(record.getLineItemCount('item'));

			// if more than zero
			if (numofitems > 0) {

				// spin through the sublist
				for ( var i = 1; i <= numofitems; i++) {

					var itemname = record.getLineItemValue('item', 'itemname',
							i);
					var quantity = record.getLineItemValue('item', 'quantity',
							i);
					var internalid = record.getLineItemValue('item', 'item', i);
					items.additem(itemname, quantity, internalid);

				}
			}

			items.setdependents();
			items.checkfulfillment();
			var haserrors = items.haserrors();
			if (haserrors !== false) {
				throw haserrors.join();
			}
			// nlapiLogExecution('DEBUG', 'Required Item',
			// JSON.stringify(items));

		} catch (e) {

			handleException(e);
		}
	}
}

function beforeSubmit(type) {

}

function afterSubmit(type) {

}
