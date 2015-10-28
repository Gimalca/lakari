'use strict';

import {lakariDispatcher as dispatcher} from '../dispatchers/LakariDispatcher';
import {constants} from '../constants/actions';
import {actions} from '../actions/orders';

var OrderService = {
    fetchOrder: (id) => {
        $.get(URL_AJAX, { id }, null, 'json')
            .then(function (response) {
                actions.orderValid(response);
            })
            .fail(error => {
                actions.orderInvalid(error);
            })
            .done();
    },
    createOrder: (user) => {
        $.post(URL_AJAX + '/add', { user }, null, 'json')
            .then(function (response) {
                actions.orderCreated(response);
            })
            .fail(function (error) {
                actions.invalidUser(error);
            })
            .done();
    },
    deleteOrder: (params) => {
        $.post(URL_AJAX + '/delete', { id: params.id }, null, 'json')
            .then((response) => {
                actions.orderDeleted({
                    order_id: response.order_id,
                    index: params.index
                });
            })
            .fail(error => {
                actions.orderDeleteFail(error);
            })
            .done();
    },
    orderProduct: (params) => {
        $.post(URL_AJAX + '/addProduct', params, null, 'json')
            .then((response) => {
                actions.itemAdded(response);
            })
            .fail((error) => {
                actions.invalidItem(error)
            })
            .done();
    },
    removeProduct: (params) => {
        $.post(URL_AJAX + '/deleteProduct', { id: params.id }, null, 'json')
            .then(function (response) {
                actions.productDeleted(params.index);
            })
            .fail(function (error){
                actions.productDeleteError(error);
            })
            .done();
    }
}

dispatcher.register((payload) => {
    let action = payload.action;
    switch(action.actionType) {
        case constants.SELECT_ORDER:
            OrderService.fetchOrder(action.id);
            break;
        case constants.DELETE_ORDER:
            OrderService.deleteOrder(action.params);
            break;
        case constants.USER_CONFIRM:
            OrderService.createOrder(action.user);
            break;
        case constants.ADD_ITEM:
            OrderService.orderProduct(action.update);
            break;
        case constants.REMOVE_ITEM:
            OrderService.removeProduct(action.params);
            break;
    }
});

export default OrderService;
