'use strict';
import BaseStore from './BaseStore';
import {constants} from '../constants/actions';
import {lakariDispatcher as dispatcher} from '../dispatchers/LakariDispatcher';

var _user = {},
    _isConfirmed = false;

function _selectUser(id) {
 //   console.log(id);
    if (id) {
        _isConfirmed = true;
    } else {
        _isConfirmed = false;
    }
}

function _setUser(user) {
    if(user) {
        _user = user;
    } else {
        _isConfirmed = false;
    }
}

function _editUser(update) {
    _user[update.prop] = update.value;
}

function _validateUser(user) {
//    console.log(user);
    _user = user;
}

function _invalidUser(user) {
    console.log(user);
}

function _orderSelected(order) {
}

class UserStore extends BaseStore {

    getUser() { return _user; }

    isConfirmed() { return _isConfirmed; }
}

var userStore = new UserStore;

userStore.dispatchToken = dispatcher.register( payload => {
    let actions = constants;

    switch(payload.action.actionType) {

        case actions.SELECT_USER:
            _selectUser(payload.action.id);
            userStore.emitChange();
            break;
        case actions.EDIT_USER:
            _editUser(payload.action.change);
            userStore.emitChange();
            break;
        case actions.FETCH_USER:
            _setUser(payload.action.user);
            userStore.emitChange();
            break;
        case actions.USER_CONFIRM:
            _validateUser(payload.action.user);
            userStore.emitChange();
            break;
        case actions.USER_INVALID:
            _invalidUser(payload.action.user);
            userStore.emitChange();
            break;
        default:
    }

    return true;
});

export default userStore;
