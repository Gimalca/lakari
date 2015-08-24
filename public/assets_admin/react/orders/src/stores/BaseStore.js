'use strict';
import EventEmitter from 'events';
import KartConstants from '../constants/actions';

class BaseStore extends EventEmitter {

  emitChange() {
    this.emit(KartConstants.events.CHANGE);
  }

  addChangeListener(callback) {
      this.on(KartConstants.events.CHANGE, callback);
  }

  removeChangeListener(callback) {
    this.removeListener(KartConstants.events.CHANGE, callback);
  }
}

BaseStore.dispatchToken = null;

export default BaseStore;
