'use strict';
import EventEmitter from 'events';
import Constants from '../constants/actions';

class BaseStore extends EventEmitter {

  emitChange() {
    this.emit(Constants.events.CHANGE);
  }

  addChangeListener(callback) {
      this.on(Constants.events.CHANGE, callback);
  }

  removeChangeListener(callback) {
    this.removeListener(Constants.events.CHANGE, callback);
  }

}

BaseStore.dispatchToken = null;

export default BaseStore;
