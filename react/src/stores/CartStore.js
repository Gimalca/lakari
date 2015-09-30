'use strict';

import BaseStore from './BaseStore';
import {constants} from '../constants/actions';
import {lakariDispatcher as dispatcher} from '../dispatchers/LakariDispatcher';

var _cartItems = [];

function _addProduct(product) {
    if(_cartItems.indexOf(product) == -1) {
        _cartItems.push(product);
    }
}

function _removeProduct(product) {
    _cartItems.splice(_cartItems.indexOf(product), 1);
}

class CartStore extends BaseStore {
    getProducts() { return _cartItems; }
}

var _cartStore = new CartStore();

_cartStore.dispatchToken = dispatcher.register(payload => {
    switch(payload.action.actionType) {
        case constants.ADD_PRODUCT:
            _addProduct(payload.action.product);
            _cartStore.emitChange();
            break;
        case constants.REMOVE_PRODUCT:
            _removeProduct(payload.action.product);
            _cartStore.emitChange();
            break;
        default:
    }
    return true;
});

export default _cartStore;
