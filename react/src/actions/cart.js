'use strict';

import {lakariDispatcher as dispatcher} from '../dispatchers/LakariDispatcher';
import {constants} from '../constants/actions';

export var actions = {
    addProduct: (product) => {
        dispatcher.handleViewAction({
            actionType: constants.ADD_PRODUCT,
            product
        });
    },
    removeProduct: (product) => {
        dispatcher.handleViewAction({
            actiontype: constants.REMOVE_PRODUCT,
            product
        });
    },
    likeProduct: (product) => {
        dispatcher.handleViewAction({
            actionType: constants.LIKE_PRODUCT,
            product
        });
    },
    shareProduct: (product) => {
        dispatcher.handleViewAction({
            actionType: constants.SHARE_PRODUCT,
            product
        });
    },
    expandProduct: (product) => {
        dispatcher.handleViewAction({
            actionType: constants.EXPAND_PRODUCT,
            product
        });
    },
    expandProductResult: (product) => {
        dispatcher.handleServerAction({
            actionType: constants.EXPAND_PRODUCT_RESPONSE,
            product : product
        });
    },
    expandProductError: (error) => {
        dispatcher.handleServerAction({
            actionType: constants.EXPAND_PRODUCT_ERROR,
            error
        });
    },
    showCart: () => {
        dispatcher.handleViewAction({
            actionType: constants.SHOW_CART,
            null
        });
    },
    hideCart: () => {
        dispatcher.handleViewAction({
            actionType: constants.HIDE_CART,
            null
        });
    },
    toggleOverlay: (state) => {
        dispatcher.handleViewAction({
            actionType: constants.TOGGLE_OVERLAY,
            state
        });
    }
}
