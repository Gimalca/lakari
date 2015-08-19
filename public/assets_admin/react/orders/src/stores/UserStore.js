'use strict';
import BaseStore from './BaseStore';
import KartDispatcher from '../dispatchers/KartDispatcher';
import KartConstants from '../constants/actions';

class UserStore extends BaseStore {

    getUsers() {
        let customers = JSON.parse(CUSTOMERS);
        return customers;
    }

    getById(id) {
//        return $.get(URL_AJAX + '/users', { search: id });
         return this.getUsers().filter( user => {
            return user.id === id;
        })[0];
    }
}

var userStore = new UserStore;

userStore.dispatchToken = KartDispatcher.register( payload => {
    let actions = KartConstants.actions;
    userStore.emitChange();
    return true;
});

export default userStore;
