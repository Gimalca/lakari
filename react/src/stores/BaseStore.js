'use strict';
import EventEmitter from 'events';
import {events} from '../constants/actions';

class BaseStore extends EventEmitter {

  emitChange() {
    this.emit(events.CHANGE);
  }

  addChangeListener(callback) {
      this.on(events.CHANGE, callback);
  }

  removeChangeListener(callback) {
    this.removeListener(events.CHANGE, callback);
  }

}

BaseStore.dispatchToken = null;

export default BaseStore;
