'use strict';
import KartDispatcher from '../dispatchers/KartDispatcher';
import KartConstants from '../constants/actions';

let actions = {

    setUser: (id) => {

        KartDispatcher.handleViewAction({
            actionType: KartConstants.actions.SELECT_USER,
            id
        });

        $.get(URL_AJAX + '/userinfo', { id }, null,'json')
            .then(function (user) {
                KartDispatcher.handleServerAction({
                    actionType: KartConstants.actions.FETCH_USER,
                    user
                });
            })
            .fail(function (error) {
                KartDispatcher.handleServerAction({
                    actionType: KartConstants.actions.USER_INVALID,
                    user
                });
            })
            .done();
    },

    editUser: (prop, value) => {
        KartDispatcher.handleViewAction({
            actionType: KartConstants.actions.EDIT_USER,
            change: {
                prop,
                value
            }
        });
    },

    confirmUser: (user) => {

        KartDispatcher.handleViewAction({
            actionType: KartConstants.actions.USER_CONFIRM,
            user
        });

        $.post(URL_AJAX + '/add', { user }, null, 'json')
            .then(function (response) {
                KartDispatcher.handleServerAction({
                    actionType: KartConstants.actions.ORDER_CREATED,
                    order: response
                });
            })
            .fail(function (error) {
                KartDispatcher.handleServerAction({
                    actiontype: KartConstants.actions.USER_INVALID,
                    error
                });
            }).done()
    },

    addItem: (id, orderId) => {

        KartDispatcher.handleViewAction({
            actionType: KartConstants.actions.ADD_ITEM,
            update: {
                product_id: id,
                order_id: orderId
            }
        }); 

        $.post(URL_AJAX + '/addProduct', 
               {product_id: id, order_id: orderId },
               null, 'json')
        .then(function (response) {
                KartDispatcher.handleServerAction({
                    actionType: KartConstants.actions.ITEM_ADDED,
                    product: response
                });
        })
        .fail(function (error) {
                KartDispatcher.handleServerAction({
                    actionType: KartConstants.actions.ITEM_INVALID,
                    error
                });
        })
        .done();
    },

    removeItem: (index) => {
        KartDispatcher.handleViewAction({
            actionType: KartConstants.actions.REMOVE_ITEM,
            index
        });
    },

    decreaseItem: (index) => {

        KartDispatcher.handleViewAction({
            actionType: KartConstants.actions.DECREASE_ITEM,
            index
        });

    },

    increaseItem: (index) => {
        KartDispatcher.handleViewAction({
            actionType: KartConstants.actions.INCREASE_ITEM,
            index
        });
    },

    emptyKart: () => {

        KartDispatcher.handleViewAction({
            actionType: KartConstants.actions.EMPTY_KART
        });
    },

    changeQuantity: (index, value) => {

        KartDispatcher.handleViewAction({
            actionType: KartConstants.actions.CHANGE_ITEM,
            item: { 
                index,
                value
            }
        });
    },

    selectOrder: (id) => {

        KartDispatcher.handleViewAction({
            actionType: KartConstants.actions.SELECT_ORDER,
            order: id
        });

        $.get(URL_AJAX, { id }, null, 'json')
            .then(function (response) {
                KartDispatcher.handleServerAction({
                    actionType: KartConstants.actions.ORDER_VALID,
                    order: response 
                });
            })
            .fail(function (error) {
                KartDispatcher.handleServerAction({
                    actionType: KartConstants.actions.ORDER_INVALID,
                    error
                });
            })
            .done();
    },

    deleteOrder: (id) => {

        KartDispatcher.handleViewAction({
            actionType: KartConstants.actions.DELETE_ORDER,
            order: id
        });

        $.post(URL_AJAX + '/delete', { id }, null, 'json')
            .then(function(response) {
                KartDispatcher.handleServerAction({
                    actionType: KartConstants.actions.ORDER_DELETED,
                    order: response 
                });
            })
            .fail(function (error) {
                KartDispatcher.handleServerAction({
                    actionType: KartConstants.actions.ORDER_DELETE_FAIL,
                    order: response 
                });
            })
            .done();
    }
}

export default actions;
