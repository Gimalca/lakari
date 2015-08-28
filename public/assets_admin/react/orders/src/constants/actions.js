'use strict';

let constants = {

    actions: {

        ADD_ITEM : 'ADD_ITEM',
        ITEM_ADDED: 'ITEM_ADDED',
        ITEM_INVALID: 'ITEM_INVALID',
        REMOVE_ITEM : 'REMOVE_ITEM',
        INCREASE_ITEM : 'INCREASE_ITEM',
        DECREASE_ITEM : 'DECREASE_ITEM',
        EMPTY_KART: 'EMPTY_KART',
        CHANGE_ITEM: 'CHANGE_ITEM',

        SELECT_USER: 'SELECT_USER',
        EDIT_USER: 'EDIT_USER',
        FETCH_USER: 'FETCH_USER',
        USER_CONFIRM: 'USER_CONFIRM',
        USER_VALID: 'USER_VALID',
        USER_INVALID: 'USER_INVALID',

        SELECT_ORDER: 'SELECT_ORDER',
        DELETE_ORDER: 'DELETE_ORDER',
        ORDER_CREATED: 'ORDER_CREATED',
        ORDER_DELETED: 'ORDER_DELETED',
        ORDER_VALID: 'ORDER_VALID',
        ORDER_INVALID: 'ORDER_INVALID'
    },
    events: {
        CHANGE: 'CHANGE'
    }
}

export default constants;
