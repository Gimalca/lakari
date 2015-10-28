'use strict';
import BaseStore from './BaseStore';
import {constants} from '../constants/actions';
import {lakariDispatcher as dispatcher} from '../dispatchers/LakariDispatcher';

var _cartItems = [],
    _order = {
        order_id: null,
        isValid: false
    };

//go to db, localstorage w/e

function _setCart(order) {
    _cartItems = order.products || [];
    _order.order_id = order.order_id;
    _order.isValid = true;
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

function _deleteOrder(params) {
    if (params.order_id == _order.order_id) {
        _cartItems = [];
        _order.isValid = false;
        return true;
    } else {
        return false;
    }
}

function _invalidateOrder() {
    _order.order_id = null;
    _order.isValid = false;
    _cartItems = [];
}

class KartStore extends BaseStore {

    getOrderId() {
        return _order.order_id;
    }

    isOrderValid() {
        return _order.isValid;
    }

    getCart() {
        return _cartItems;
    }
}

let kartStore = new KartStore();

kartStore.dispatchToken = dispatcher.register( payload => {

    let actions = constants;

    switch(payload.action.actionType) {

        case actions.ADD_ITEM:
            _add(payload.action.update);
            kartStore.emitChange();
        break;
        case actions.ITEM_ADDED:
            _itemAdded(payload.action.product);
            kartStore.emitChange();
        break;
        case actions.ITEM_INVALID:
            _invalidItem(payload.action.error);
            kartStore.emitChange();
        break;
        case actions.DELETE_PRODUCT:
            _remove(payload.action.index);
            kartStore.emitChange();
        break;
        case actions.INCREASE_ITEM:
            _increase(payload.action.index);
            kartStore.emitChange();
        break;
        case actions.DECREASE_ITEM:
            _decrease(payload.action.index);
            kartStore.emitChange();
        break;
        case actions.EMPTY_KART:
            _clearKart();
            kartStore.emitChange();
        break;
        case actions.CHANGE_ITEM:
            _change(payload.action.item);
            kartStore.emitChange();
        break;

        case actions.ORDER_CREATED:
        case actions.ORDER_VALID:
            _setCart(payload.action.order);
            kartStore.emitChange();
        break;
        case actions.ORDER_DELETED:
            if(_deleteOrder(payload.action.params)) {
                kartStore.emitChange();
            }
            break;
        case actions.SELECT_USER:
            _invalidateOrder();
            kartStore.emitChange();
            break;
        default:
    }

    return true;
});

export default kartStore;
