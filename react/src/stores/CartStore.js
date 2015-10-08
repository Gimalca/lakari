'use strict';

import BaseStore from './BaseStore';
import {constants} from '../constants/actions';
import {lakariDispatcher as dispatcher} from '../dispatchers/LakariDispatcher';

var _cartItems = [];
var _isShowing = false;

function _addProduct(product) {
    if(_cartItems.indexOf(product) == -1) {
        _cartItems.push(product);
    }
    _isShowing = true;
}

function _removeProduct(product) {
    _cartItems.splice(_cartItems.indexOf(product), 1);
}

function _toggleCart() {
    console.log('toggle');
    return _isShowing = !_isShowing;
}

class CartStore extends BaseStore {

    getProducts() { 
        return _cartItems; 
    }

    isShowing() { 
        return _isShowing; 
    }
}

var _cartStore = new CartStore();

_cartStore.dispatchToken = dispatcher.register(payload => {
    switch (payload.action.actionType) {
        case constants.ADD_PRODUCT:
            _addProduct(payload.action.product);
            _cartStore.emitChange();
            break;
        case constants.REMOVE_PRODUCT:
            _removeProduct(payload.action.product);
            _cartStore.emitChange();
            break;
        case constants.TOGGLE_CART:
            _toggleCart();
            _cartStore.emitChange();
        default:
    }
    return true;
});

export default _cartStore;
