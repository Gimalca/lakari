'use strict';
import BaseStore from './BaseStore';
import KartDispatcher from '../dispatchers/KartDispatcher';
import KartConstants from '../constants/actions';

var _catalog = [];
var _cartItems = []; 

//go to db, localstorage w/e

function _add(id) {

    var found = _cartItems.filter( product => {
        return id == product.id;
    });

    if (found.length == 0) {

        let item = _catalog.filter( product => {
            return product.id == id;
        });

        item[0].quantity = 1;
        _cartItems.push(item[0]);
    }
}

function _remove(index) {
    _cartItems.splice(index, 1);
}

function _increase(index) {
    if(++_cartItems[index].quantity >= 100) {
        _cartItems[index].quantity = 100;
    }
}

function _decrease(index) {
    if(--_cartItems[index].quantity < 1) {
        _cartItems[index].quantity = 1;
    }
}

function _clearKart() {
    _cartItems = [];
}

function _change(item) {
    let value  = parseInt(item.value, 10);
    _cartItems[item.index].quantity = value;
}

class KartStore extends BaseStore {

    getCatalog() {
        _catalog = JSON.parse(PRODUCTS);
        return _catalog;
    }

    getCart() {
        return _cartItems;
    }
}

let kartStore = new KartStore();

kartStore.dispatchToken = KartDispatcher.register( payload => {

    let actions = KartConstants.actions;

    switch(payload.action.actionType) {
        case actions.ADD_ITEM:
            _add(payload.action.id)
        break;
        case actions.REMOVE_ITEM:
            _remove(payload.action.index);
        break;
        case actions.INCREASE_ITEM:
            _increase(payload.action.index);
        break;
        case actions.DECREASE_ITEM:
            _decrease(payload.action.index);
        break;
        case actions.EMPTY_KART:
            _clearKart();
        break;
        case actions.CHANGE_ITEM:
            _change(payload.action.item);
        break;
    }

    kartStore.emitChange();
    return true;
});

export default kartStore;
