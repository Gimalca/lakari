'use strict';
import BaseStore from './BaseStore';
import KartDispatcher from '../dispatchers/KartDispatcher';
import KartConstants from '../constants/actions';

var _cartItems = [],
    _orderId; 

//go to db, localstorage w/e

function _setCart(order) {
    _cartItems = order.products;
    _orderId = order.order_id;
}

function _add(update) {
}

function _itemAdded(product) {
    _cartItems.push(product);
}

function _invalidItem(error) {
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

    getOrderId() {
        return _orderId;
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
            _add(payload.action.update);
        break;
        case actions.ITEM_ADDED:
            _itemAdded(payload.action.product);
        break;
        case actions.ITEM_INVALID:
            _invalidItem(payload.action.error);
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

        case actions.ORDER_CREATED:
        case actions.ORDER_VALID:
            _setCart(payload.action.order);
        break;
    }

    console.log(payload.action.actionType);
    kartStore.emitChange();
    return true;
});

export default kartStore;
