'use strict';
import BaseStore from './BaseStore';
import {constants} from '../constants/actions';
import {lakariDispatcher as dispatcher} from '../dispatchers/LakariDispatcher';

var _selected = null;

function _selectProduct(product) {
    _selected = product;
}

class ProductStore extends BaseStore {

    getSelected() { return _selected; }
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
