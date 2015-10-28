'use strict';

import {lakariDispatcher as dispatcher} from '../dispatchers/LakariDispatcher';
import {constants} from '../constants/actions';
import {actions} from '../actions/orders';

var UserService = {
    fetchUser: (id) => {
        $.get(URL_AJAX + '/userinfo', { id }, null,'json')
            .then(function (user) {
                actions.fetchUser(user);
            })
            .fail(function (error){
                actions.invalidUser(error);
            })
            .done();
    }
}

dispatcher.register((payload) => {
    let action = payload.action;
    switch(action.actionType) {
        case constants.SELECT_USER:
            UserService.fetchUser(action.id);
            break;
    }
});

export default UserService;
