'use strict';

import {lakariDispatcher as dispatcher} from '../dispatchers/LakariDispatcher';
import {constants} from '../constants/actions';

export var actions = {

    setUser: (id) => {
        dispatcher.handleViewAction({
            actionType: constants.SELECT_USER,
            id
        });
    },

    fetchUser: (user) => {
        dispatcher.handleServerAction({
            actionType: constants.FETCH_USER,
            user
        });
    },

    invalidUser: (error) => {
        dispatcher.handleServerAction({
            actionType: constants.USER_INVALID,
            error
        });
    },

    editUser: (prop, value) => {
        dispatcher.handleViewAction({
            actionType: constants.EDIT_USER,
            change: {
                prop,
                value
            }
        });
    },

    createOrder: (user) => {

        dispatcher.handleViewAction({
            actionType: constants.USER_CONFIRM,
            user
        });
    },

    orderCreated: (order) => {
        dispatcher.handleServerAction({
            actionType: constants.ORDER_CREATED,
            order
        });
    },

    addItem: (id, orderId) => {

        dispatcher.handleViewAction({
            actionType: constants.ADD_ITEM,
            update: {
                product_id: id,
                order_id: orderId
            }
        }); 
    },

    itemAdded: (item) => {
        dispatcher.handleServerAction({
            actionType: constants.ITEM_ADDED,
            product: item
        });
    },

    invalidItem: (error) => {
        dispatcher.handleServerAction({
            actionType: constants.ITEM_INVALID,
            error
        });
    },

    removeItem: (index, id) => {

        dispatcher.handleViewAction({
            actionType: constants.REMOVE_ITEM,
            params: {
                index,
                id
            }
        });
    },
    productDeleted: (index) => {
        dispatcher.handleViewAction({
            actionType: constants.DELETE_PRODUCT,
            index
        });
    },
    productDeleteError: (error) => {
        dispatcher.handleViewAction({
            actionType: constants.DELETE_PRODUCT_FAIL,
            error
        });
    },

    decreaseItem: (index) => {

        dispatcher.handleViewAction({
            actionType: constants.DECREASE_ITEM,
            index
        });

    },

    increaseItem: (index) => {
        dispatcher.handleViewAction({
            actionType: constants.INCREASE_ITEM,
            index
        });
    },

    emptyKart: () => {

        dispatcher.handleViewAction({
            actionType: constants.EMPTY_KART
        });
    },

    changeQuantity: (index, value) => {

        dispatcher.handleViewAction({
            actionType: constants.CHANGE_ITEM,
            item: { 
                index,
                value
            }
        });
    },

    selectOrder: (id) => {
        dispatcher.handleViewAction({
            actionType: constants.SELECT_ORDER,
            id
        });
    },

    orderValid: (order) => {
        dispatcher.handleServerAction({
            actionType: constants.ORDER_VALID,
            order 
        });
    },

    orderInvalid: (error) => {
        dispatcher.handleServerAction({
            actionType: constants.ORDER_INVALID,
            error
        });
    },

    deleteOrder: (id, index) => {
        dispatcher.handleViewAction({
            actionType: constants.DELETE_ORDER,
            params: {
                id,
                index
            }
        });
    },
    orderDeleted: (params) => {
        dispatcher.handleServerAction({
            actionType: constants.ORDER_DELETED,
            params
        });
    },
    orderDeleteFail: (error) => {
        dispatcher.handleServerAction({
            actionType: constants.ORDER_DELETE_FAIL,
            error
        });
    }
    
}
