/**
 * Checks for Items Dependent on Other Items for Fulfillment
 * 
 * @author gWilli
 * @date 04/2014
 * @platform NetSuite 
 */

/** 
 * Items Required by Other Items 
 */
var dependentitems = [];

/** 
 * Items That Require Other Items 
 */
var itemsdependent = [];

/**
 * 
 */
var items = {
		
	/**
	 * Loads all items with dependencies
	 * 
	 * @return void
	 */ 
	getdependentitems : function() {

		if (dependentitems.length > 0) {
			return;
		}

		var loadSearch = nlapiLoadSearch('item', 'customsearch_dependent_items');

		var getData = loadSearch.runSearch();
		getData.forEachResult(function(searchRow) {

					itemsdependent.push(searchRow.getValue('name').replace(
							/\s+/g, ''));
					dependentitems.push(searchRow.getText(
							'custitem_dependent_item').replace(/\s+/g, ''));

					return true;
				});
	},
	
	/**
	 * Adds new item to items object 
	 * 
	 * @param string itemname
	 * @param int quantity
	 * @param int internalid
	 * @returns void
	 */ 
	additem : function(itemname, quantity, internalid) {

		var itemKey = this.isitem(itemname);
		var item = this[itemKey];
		item.internalid = internalid;
		item.quantity = item.quantity + parseInt(quantity);
		item.dependencies = this.getdependents(itemKey);
		item.requiredby = 0;
		item.errors = [];
	},

	/**
	 * Gets an Items dependent item from itemsdependent/dependentitems arrays
	 * 
	 * @param string itemname
	 * @return mixed 
	 */
	getdependents : function(itemname) {

		if (itemsdependent.indexOf(itemname) >= 0) {

			return (dependentitems[itemsdependent.indexOf(itemname)]);
		} else {
			return null;
		}
	},

	/**
	 * Test for exsistance of item in items object, creates new if not
	 * 
	 * @param string itemname
	 * @returns string itemname
	 */ 
	isitem : function(itemname) {

		itemname = itemname.replace(/\s+/g, '');
		if (typeof (this[itemname]) === "undefined") {
			this.createitem(itemname);
		}
		return itemname;
	},

	/**
	 * Creates new item object
	 * 
	 * @param string itemname
	 * @returns void
	 */
	createitem : function(itemname) {

		this[itemname] = {
			"quantity" : 0
		};
	},

	/**
	 * Checks for Dependencies and Creates Item Object if Needed
	 * 
	 * @return void
	 */
	setdependents : function() {

		for (i in items) {

			var item = items[i];
			if (item.dependencies != null) {
				var itemKey = this.isitem(item.dependencies);
				this.additem(itemKey, 0, null);
				this.updaterequiredby(itemKey, item.quantity);
			}

		}
	},

	/**
	 * Updates the Number of Items that Require Dependent Item
	 * 
	 * @return void
	 */
	updaterequiredby : function(itemname, quantity) {

		var item = items[itemname];
		item.requiredby = item.requiredby + quantity;
	},

	/**
	 * Checks for Correct Amount of Ordered Compared to Required
	 * 
	 * @return void
	 */
	checkfulfillment : function() {
		for (i in items) {

			var item = items[i];
			if (item.quantity < item.requiredby) {
				item.errors.push(' ' + item.requiredby + ' Item(s) Require ' + i
						+ ': ' + item.quantity + ' Were Ordered.');
			}
		}
	},

	/**
	 * Checks Items Object for an Item(s) with Missing Dependencies
	 * 
	 * @return void
	 */
	haserrors : function() {

		var errors = [];

		for ( var i in items) {

			var item = items[i];

			if (typeof (item) !== "function") {
				if (item.errors.length > 0) {
					for ( var e in item.errors) {
						errors.push(item.errors[e]);
					}
				}
			}
		}

		var returnstring = (errors.length > 0) ? errors : false;
		return (returnstring);
	}

};

/**
 * Function Run Before Document Load
 * 
 * @param type
 */
function beforeLoad(type) {

	if (nlapiGetContext().getExecutionContext() == "userinterface") {

		try {

			// load our record
			var record = nlapiGetNewRecord();

			// count # of items on order
			var numofitems = parseInt(record.getLineItemCount('item'));

			// if more than zero
			if (numofitems > 0) {

				// load all items with dependencies
				items.getdependentitems();

				// spin through the sublist
				for ( var i = 1; i <= numofitems; i++) {

					var itemname = record.getLineItemValue('item', 'itemname',
							i);
					var quantity = record.getLineItemValue('item', 'quantity',
							i);
					var internalid = record.getLineItemValue('item', 'item', i);
					
					// add item to items array
					items.additem(itemname, quantity, internalid);

				}
			}
			
			// sets item dependencies
			items.setdependents();
			// check for correct number if dependencies
			items.checkfulfillment();
			
			// check for fulfillment errors
			var haserrors = items.haserrors();
			if (haserrors !== false) {
				throw haserrors;
			}
			//nlapiLogExecution('DEBUG', 'Final Array', JSON.stringify(items));

		} catch (e) {
			throw e.join("<br>");
		}
	}
}

function beforeSubmit(type) {

}

function afterSubmit(type) {

}