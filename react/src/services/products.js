'use strict';

import {lakariDispatcher as dispatcher} from '../dispatchers/LakariDispatcher';
import {constants} from '../constants/actions';
import {actions} from '../actions/cart';

var ProductService = {
    findById: function (id) {
        $.get(URL_AJAX + '/index/expander', {id: id}, null, 'json')
            .then(function (response) {
                actions.expandProductResult(response);
            })
            .fail(function (error) {
                actions.expandProductError(error);
            })
            .done();
    },
    addProduct: function (product) {
        //go to web service/ localstorage
    }
};

dispatcher.register((payload) => {
    let action = payload.action;
    switch(action.actionType) {
        case constants.EXPAND_PRODUCT:
           ProductService.findById(action.product.id);
           break;
       case constants.ADD_PRODUCT:
           ProductService.addProduct(action.product.id);
           break;
    }
    return true;
});

export default ProductService;
