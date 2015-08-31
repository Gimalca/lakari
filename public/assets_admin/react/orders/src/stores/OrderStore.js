'use strict';
import React from 'react';
import BaseStore from './BaseStore';
import KartDispatcher from '../dispatchers/KartDispatcher';
import KartConstants from '../constants/actions';

var _orders = [];

function _setOrders(orders) {
    _orders = orders;
}

function _newOrder(order) {
    _orders.push(order);
}

function _deleteOrder(index) {
    _orders.splice(index, 1);
}

function _invalidateOrders() {
    _orders = []
}

class OrderStore extends BaseStore {

    getOrders() {
        return _orders;
    }
}

let _orderStore = new OrderStore();

_orderStore.dispatchToken = KartDispatcher.register( payload => {

    let actions = KartConstants.actions;

    switch(payload.action.actionType) {
        case actions.FETCH_USER:
            _setOrders(payload.action.user.orders);
            _orderStore.emitChange();
            break;
        case actions.ORDER_CREATED:
            _newOrder(payload.action.order);
            _orderStore.emitChange();
            break;
        case actions.ORDER_DELETED:
            _deleteOrder(payload.action.index);
            _orderStore.emitChange();
            break;
        case actions.SELECT_USER:
            _invalidateOrders();
            _orderStore.emitChange();
            break;
        default:
    }
    return true;
});

export default  _orderStore;
