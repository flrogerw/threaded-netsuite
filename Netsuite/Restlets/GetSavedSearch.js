function main(data) {

	var filters = [];
	var columns = [];
	var results = [];

	var args = JSON.parse(decodeURIComponent(data));

	switch (args.searchFunction) {

	case ('getCustomers'):
		return (getCustomers());
		break;

	case ('getItems'):
		return (getItems());
		break;

	default:
		throw nlapiCreateError('Bad Search Name',
				'System does not understand: '
						+ args.searchFunction.toLowerCase());
		break;

	}

	function getItems() {
		;
		var searchResults = new Array();
		var col = new Array();

		col[0] = new nlobjSearchColumn('name');
		col[1] = new nlobjSearchColumn('internalId');

		var results = nlapiSearchRecord('location', null, null, col);
		var locations = {};
		for ( var i = 0; results != null && i < results.length; i++) {
			var res = results[i];
			locations[res.getValue('name').toLowerCase()] = res
					.getValue('internalId');

		}

		columns.push(new nlobjSearchColumn("name"));
		columns.push(new nlobjSearchColumn("type"));
		columns.push(new nlobjSearchColumn("price"));
		columns.push(new nlobjSearchColumn("description"));
		columns.push(new nlobjSearchColumn("custitem_fulfilled_by"));

		filters.push(new nlobjSearchFilter("isinactive", null, "is", "F"));

		var savedsearch = nlapiCreateSearch('item', filters, columns);
		var resultset = savedsearch.runSearch();
		var searchid = 0;
		do {
			var resultslice = resultset.getResults(searchid, searchid + 1000);
			for ( var rs in resultslice) {
				var oItem = {};
				var aItem = resultslice[rs];
				oItem.id = aItem.id;
				oItem.type = aItem.getValue('type');
				var fulfilled_by = aItem.getText('custitem_fulfilled_by')
						.toLowerCase();
				oItem.fulfilled_by = (fulfilled_by != null) ? locations[fulfilled_by]
						: aItem.getText('custitem_fulfilled_by');
				oItem.description = aItem.getValue('description');
				oItem.name = aItem.getValue('name');
				searchResults.push(oItem);

				searchid++;
			}
		} while (resultslice.length >= 1000);
		return JSON.stringify(searchResults);

	}

	function getCustomers() {

		columns.push(new nlobjSearchColumn("custentity_customer_source_id"));
		filters.push(new nlobjSearchFilter("custentity_customer_source_id",
				null, "isnotempty", null));

		var savedsearch = nlapiCreateSearch('customer', filters, columns);
		var resultset = savedsearch.runSearch();
		var searchid = 0;
		do {
			var resultslice = resultset.getResults(searchid, searchid + 1000);
			for ( var rs in resultslice) {
				results.push(resultslice[rs]);
				searchid++;
			}
		} while (resultslice.length >= 1000);
		return JSON.stringify(results);
	}

}