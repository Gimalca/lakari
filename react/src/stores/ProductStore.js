'use strict';

import BaseStore from './BaseStore';
import {constants} from '../constants/actions';
import {lakariDispatcher as dispatcher} from '../dispatchers/LakariDispatcher';

var _selected = null;
var _isFixed = false;

/* Catalogo sin React */ 
$(document).on('EXPAND_PRODUCT', function (e, product){
    _selectProduct(product);
    _productStore.emitChange();
});

$(document).on('FIXED_PRODUCT', function (evt){
     _isFixed = !_isFixed;
});

function _selectProduct(product) {
    _selected = product;
}

class ProductStore extends BaseStore {

    getSelected() { 
        return _selected; 
    }

    isShowing() { 
        return _selected != null; 
    }

    isFixed() {
        return _isFixed; 
    }
}

var _productStore = new ProductStore();

_productStore.dispatchToken = dispatcher.register(payload => {
    switch(payload.action.actionType) {
        case constants.EXPAND_PRODUCT_RESPONSE:
            _selectProduct(payload.action.product);
            _productStore.emitChange();
            break;
        default:
    }
    return true;
});

export default _productStore;
