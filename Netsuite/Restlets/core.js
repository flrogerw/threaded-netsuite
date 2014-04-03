var keyStr = "ABCDEFGHIJKLMNOP" +
               "QRSTUVWXYZabcdef" +
               "ghijklmnopqrstuv" +
               "wxyz0123456789+/" +
               "=";

function getAddressString( address ){
var addressString = [ address.addressee,
		address.attention,
		address.addr1,
		address.addr2,
		address.addr3,
		address.city + ' ' + address.state + ' ' + address.zip ];
addressString = addressString.filter(function(n){return n});
return( addressString.join('\n') )
}


  function encode64(input) {
     input = escape(input);
     var output = "";
     var chr1, chr2, chr3 = "";
     var enc1, enc2, enc3, enc4 = "";
     var i = 0;

     do {
        chr1 = input.charCodeAt(i++);
        chr2 = input.charCodeAt(i++);
        chr3 = input.charCodeAt(i++);

        enc1 = chr1 >> 2;
        enc2 = ((chr1 & 3) << 4) | (chr2 >> 4);
        enc3 = ((chr2 & 15) << 2) | (chr3 >> 6);
        enc4 = chr3 & 63;

        if (isNaN(chr2)) {
           enc3 = enc4 = 64;
        } else if (isNaN(chr3)) {
           enc4 = 64;
        }

        output = output +
           keyStr.charAt(enc1) +
           keyStr.charAt(enc2) +
           keyStr.charAt(enc3) +
           keyStr.charAt(enc4);
        chr1 = chr2 = chr3 = "";
        enc1 = enc2 = enc3 = enc4 = "";
     } while (i < input.length);

     return output;
  }

  function decode64(input) {
     var output = "";
     var chr1, chr2, chr3 = "";
     var enc1, enc2, enc3, enc4 = "";
     var i = 0;

     // remove all characters that are not A-Z, a-z, 0-9, +, /, or =
     var base64test = /[^A-Za-z0-9\+\/\=]/g;
     if (base64test.exec(input)) {
        var error = "There were invalid base64 characters in the input text.\n" +
              "Valid base64 characters are A-Z, a-z, 0-9, '+', '/',and '='\n" +
              "Expect errors in decoding.";
        handleException(error)
     }
     input = input.replace(/[^A-Za-z0-9\+\/\=]/g, "");

     do {
        enc1 = keyStr.indexOf(input.charAt(i++));
        enc2 = keyStr.indexOf(input.charAt(i++));
        enc3 = keyStr.indexOf(input.charAt(i++));
        enc4 = keyStr.indexOf(input.charAt(i++));

        chr1 = (enc1 << 2) | (enc2 >> 4);
        chr2 = ((enc2 & 15) << 4) | (enc3 >> 2);
        chr3 = ((enc3 & 3) << 6) | enc4;

        output = output + String.fromCharCode(chr1);

        if (enc3 != 64) {
           output = output + String.fromCharCode(chr2);
        }
        if (enc4 != 64) {
           output = output + String.fromCharCode(chr3);
        }

        chr1 = chr2 = chr3 = "";
        enc1 = enc2 = enc3 = enc4 = "";

     } while (i < input.length);

     return unescape(output);
  }


	function getCurrentCustomer( var customer ) {

		var filters = [];
		var columns = [];
		var results = [];

		
		columns.push(new nlobjSearchColumn("custentity_customer_source_id"));
		filters.push(new nlobjSearchFilter("custentity_customer_source_id", null, "is", customer.custentity_customer_source_id));
		filters.push(new nlobjSearchFilter("email", null, "is", customer.email));
		if(customer.isperson == 'F'){
			filters.push(new nlobjSearchFilter("companyname", null, "is", customer.companyname));
		}else{
			filters.push(new nlobjSearchFilter("firstname", null, "is", customer.firstname));
			filters.push(new nlobjSearchFilter("lastname", null, "is", customer.lastname));
		}
		

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
  
  
  
  
function handleException(error) {
	var message;
	if (error instanceof nlobjError) {
		message = {
			"code" : error.getCode(),
			"id" : error.getId(),
			"details" : error.getDetails(),
			"internalId" : error.getInternalId(),
			"userEvent" : error.getUserEvent(),
			"stackTrace" : error.getStackTrace()
		};
	} else {
		message = {
			"code" : 'unexpected error',
			"details" : ((typeof error == 'object') ? error.toString() : error)
		};
	}
	nlapiLogExecution('ERROR', message.code, message.details);
	return message;
}