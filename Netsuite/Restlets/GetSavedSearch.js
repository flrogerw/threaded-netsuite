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

		columns.push(new nlobjSearchColumn("name"));
		columns.push(new nlobjSearchColumn("type"));

		filters.push(new nlobjSearchFilter("isinactive", null, "is",
				"F"));

		var savedsearch = nlapiCreateSearch('item', filters, columns);
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