// checks new sales order for gift code redemption.  notifies Activa of its use.
var gcue = {

    record_id: null,
    record_type: null,
    record: null,
    order_source_id: null,
    debug: true,

    beforeSubmit: function(type) {

return;


        nlapiLogExecution('DEBUG', 'beforeSubmit()', 'type=' + type + ', context=' + gc.context);

        if(type == "create" && gc.context == "userinterface") {

            try {

                // load our record
                this.record = nlapiGetNewRecord();

                // count # of items on order
                var numofitems = parseInt(this.record.getLineItemCount('item'));

                // if more than zero
                if(numofitems > 0) {

                    // spin through the sublist
                    for(var i = 1; i <= numofitems; i++) {

                        // determine if this is a gift card by seeing if the value exists on the line item sublist
                        var code = this.record.getLineItemValue('item', 'giftcertnumber', i);

                        if(code && code !== null && code != "" ) {

                            if(this.debug) {
                                nlapiLogExecution('DEBUG', 'beforeSubmit()', 'code=' + code);
                            }

                            // activate the card
                            if(!gc.statusUpdate(code, 'active')) {
                                throw nlapiCreateError('GC_ERROR', gc.errmsg);
                            }
                            else {
                                nlapiLogExecution('DEBUG', 'beforeSubmit()', 'code=' + code + ' --- status update successful');
                            }
                        }
                    }
                }
            } catch(e) {
                SuccessoriesLibrary.handleException(e, 'error in GC_UserEvent.js beforeSubmit()', '');
                throw nlapiCreateError('GC_EXCEPTION', 'beforeSubmit(), gc.errmsg=' + gc.errmsg + ', e.message=' + e.message);
            }
        }
    },


    afterSubmit: function(type) {

        nlapiLogExecution('DEBUG', 'afterSubmit()', 'type=' + type + ', context=' + gc.context);

        if(type == "create" && gc.context == "userinterface") {

            try {

                this.record_id = nlapiGetRecordId();

                // load our record
                this.record = nlapiGetNewRecord();

                // get order source ID (if any)
                this.order_source_id = this.record.getFieldValue('custbody_order_source_id');

                // if no order source ID, default to the sales order ID
                if(!this.order_source_id || this.order_source_id == null || this.order_source_id == "") {
                    this.order_source_id = this.record_id;
                }

                // count # of gift certs used on this order
                var numofgiftcerts = parseInt(this.record.getLineItemCount('giftcertredemption'));

                // if more than zero...
                if(numofgiftcerts > 0) {

                    // spin through the sublist
                    for(var i = 1; i <= numofgiftcerts; i++) {

                        // gift card code
                        var code = this.record.getLineItemValue('giftcertredemption', 'authcode_display', i);

                        // gift card amount
                        var amount = this.record.getLineItemValue('giftcertredemption', 'authcodeapplied', i);

                        // log/debug
                        nlapiLogExecution('DEBUG', 'afterSubmit() - order ID ' + this.record_id, 'code=' + code + ', amount=' + amount + ', order_source_id=' + this.order_source_id);

                        if(gc.codeIsValid(code)) {

                            // send balance adjustment to Activa
                            if(!gc.balanceAdjustment(code, amount, this.order_source_id)) {
                                throw nlapiCreateError('GC_ERROR', gc.errmsg);
                            }
                            else {
                                nlapiLogExecution('DEBUG', 'afterSubmit()', 'code=' + code + ' --- balance update successful');
                            }
                        }
                    }
                }
            } catch(e) {
                SuccessoriesLibrary.handleException(e, 'error in GC_UserEvent.js afterSubmit()', '');
                throw nlapiCreateError('GC_EXCEPTION', 'afterSubmit(), gc.errmsg=' + gc.errmsg + ', e.message=' + e.message);
            }
        }
    },


    beforeLoad: function(type) {
    }

};