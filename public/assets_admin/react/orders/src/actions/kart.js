'use strict';
import KartDispatcher from '../dispatchers/KartDispatcher';
import KartConstants from '../constants/actions';

let actions = {

    addItem: (id) => {
        KartDispatcher.handleViewAction({
            actionType: KartConstants.actions.ADD_ITEM,
            id
        });
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
    }
}

export default actions;
