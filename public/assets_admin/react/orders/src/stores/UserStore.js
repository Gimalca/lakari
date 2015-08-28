'use strict';
import BaseStore from './BaseStore';
import KartDispatcher from '../dispatchers/KartDispatcher';
import KartConstants from '../constants/actions';

var _user = {};
var _isConfirmed = false;

function _selectUser(id) {
 //   console.log(id);
    _isConfirmed = false;
}

function _setUser(user) {
    _user = user;
}

function _editUser(update) {
    _user[update.prop] = update.value;
    _isConfirmed = false;
}

function _validateUser(user) {
//    console.log(user);
    _user = user;
    _isConfirmed = true;
}

function _invalidUser(user) {
    console.log(user);
}

function _orderSelected(order) {
    _isConfirmed = true;
}

class UserStore extends BaseStore {

    getUser() { return _user; }

    isConfirmed() { return _isConfirmed; }
}

var userStore = new UserStore;

userStore.dispatchToken = KartDispatcher.register( payload => {
    let actions = KartConstants.actions;

    switch(payload.action.actionType) {

        case actions.SELECT_USER:
            _selectUser(payload.action.id);
            break;
        case actions.EDIT_USER:
            _editUser(payload.action.change);
            break;
        case actions.FETCH_USER:
            _setUser(payload.action.user);
            break;
        case actions.USER_CONFIRM:
            _validateUser(payload.action.user);
            break;
        case actions.USER_INVALID:
            _invalidUser(payload.action.user);
            break;
        case actions.ORDER_VALID:
            _orderSelected(payload.action.order);
        break;
    }

    userStore.emitChange();
    return true;
});

export default userStore;
