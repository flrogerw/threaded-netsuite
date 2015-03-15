function main( data ){

var filters = [];
var columns = [];
var items = [];
 var itemObj = {};

filters.push( new nlobjSearchFilter('inventorylocation',null,'is',  data.locationId  ) );


          columns.push( new nlobjSearchColumn( 'itemid' ) );
          columns.push( new nlobjSearchColumn( 'inventorylocation' ) );
          columns.push( new nlobjSearchColumn( 'locationquantityavailable' ) );
          columns.push( new nlobjSearchColumn( 'locationquantityonhand' ) );


var rec = nlapiSearchRecord('item',null,filters,columns);


 for (var i=0, l=rec.length; i < l; i++)
    {
        var result = rec[i];
       
        itemObj[ result.getValue( 'itemid' )  ] = result.getValue( 'locationquantityavailable' );

      // items.push(  itemObj );
    } 

//return(  JSON.stringify(  itemObj )   );
return(  itemObj  );
//nlapiLogExecution('DEBUG', 'xxxxxx ', JSON.stringify( items ) );

}