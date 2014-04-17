function main(data) {


	var args = JSON.parse(decodeURIComponent(data));

	switch (args.searchFunction) {

	case ('openOrderReport'):
		return (openOrderReport());
		break;

	case ('backOrderReport'):
		return (backOrderReport());
		break;

	case ('openOrderReportDYR'):
		return (openOrderReportDYR());
		break;
		
	case ('loadSearch'):
		return (loadSearch( args ));
		break;	

	default:
		throw nlapiCreateError('Bad Search Name',
				'System does not understand: ' + args.searchFunction);
		break;
	}

}


/**
 * @param obj args
 * Max Rows: 4000
 */
function loadSearch( args ){

	var results = [];
	var loadSearch=nlapiLoadSearch(args.recordtype, args.searchname );
        loadSearch.addFilter(new nlobjSearchFilter('shipdate', null, 'onOrAfter', 'daysAgo14'));
	var getData = loadSearch.runSearch();
	getData.forEachResult(function (searchRow) {

	    results.push( searchRow );
	    return true;
	});
	
	return JSON.stringify(results);
}

/**
 * Search Name: Open Order Report DYR! 
 * Internal ID: customsearch502
 * Max Rows: Unlimitied
 * 
 */
function openOrderReportDYR() {

	var filters = [];
	var columns = [];

	/* COLUMNS */

	columns.push(new nlobjSearchColumn("trandate"));
	columns.push(new nlobjSearchColumn("status"));
	columns.push(new nlobjSearchColumn("tranid"));
	columns.push(new nlobjSearchColumn("entity"));
	columns.push(new nlobjSearchColumn("CUSTBODY37"));
	columns.push(new nlobjSearchColumn("shipdate"));
	columns.push(new nlobjSearchColumn("custbody_inhandsdate"));
	columns.push(new nlobjSearchColumn("custbody_proofdate"));
	columns.push(new nlobjSearchColumn("CUSTBODY_APPROVALRECD"));
	columns.push(new nlobjSearchColumn("salesrep"));
	columns.push(new nlobjSearchColumn("total"));

	/* FILTERS */
	filters.push(new nlobjSearchFilter("recordtype", null, "is", "salesorder"));
	filters.push(new nlobjSearchFilter('mainline', null, 'is', 'T'));
	filters.push(new nlobjSearchFilter('department', null, 'is', 'DYR'));
	filters.push(new nlobjSearchFilter('status', null, 'anyof', ['SalesOrd:A', 'SalesOrd:B', 'SalesOrd:D', 'SalesOrd:E','ItemShip:C' ]));

	var savedsearch = nlapiCreateSearch('transaction', filters, columns);
	var results = runSearch(savedsearch);

	return JSON.stringify(results);
}

/**
 * GGMFG Backorder Report
 * 
 */
function backOrderReport() {

	var filters = [];
	var columns = [];

	/* COLUMNS */
	columns.push(new nlobjSearchColumn("type"));

	/* FILTERS */
	filters.push(new nlobjSearchFilter("type", null, "anyof", [ 'InvtPart','Assembly' ]));
	filters.push(new nlobjSearchFilter("isinactive", null, "is", "F"));
	filters.push(new nlobjSearchFilter("quantitybackordered", null,
			"greaterthan", 0));

	var savedsearch = nlapiCreateSearch('item', filters, columns);
	var results = runSearch(savedsearch);

	return JSON.stringify(results);
}
/**
 * Open Order Report w/Engraving Completed 3
 */
function openOrderReport() {

	var filters = [];
	var columns = [];

	/* COLUMNS */
	columns.push(new nlobjSearchColumn("mainline"));
	columns.push(new nlobjSearchColumn("trandate"));
	columns.push(new nlobjSearchColumn("department"));
	columns.push(new nlobjSearchColumn("salesrep"));
	columns.push(new nlobjSearchColumn("entity"));
	columns.push(new nlobjSearchColumn("tranid"));
	columns.push(new nlobjSearchColumn("shipdate"));
	columns.push(new nlobjSearchColumn("custbody_textrequired"));
	columns.push(new nlobjSearchColumn("custbody_artworkscheduled"));
	columns.push(new nlobjSearchColumn("custbody_proofdate"));
	columns.push(new nlobjSearchColumn("custbody42"));
	columns.push(new nlobjSearchColumn("custbody_inhandsdate"));
	columns.push(new nlobjSearchColumn("custbody_inproductiondate"));

	/* FILTERS */
	filters.push(new nlobjSearchFilter("recordtype", null, "is", "salesorder"));
	filters.push(new nlobjSearchFilter('custbody_inhandsdate', null,
			'onOrAfter', 'daysAgo14'));
	filters.push(new nlobjSearchFilter('mainline', null, 'is', 'T'));
	filters.push(new nlobjSearchFilter('department', null, 'anyof', [
			'Awards.com', 'DYR', 'Successories', 'Trophy.com' ]));
	filters.push(new nlobjSearchFilter('status', null, 'anyof', [ 'SalesOrd:B',
			'SalesOrd:D', 'SalesOrd:E' ]));

	var savedsearch = nlapiCreateSearch('transaction', filters, columns);
	var results = runSearch(savedsearch);

	return JSON.stringify(results);
}

/**
 * Proccess search
 * 
 * @param nlobjSearchResult Object savedsearch
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