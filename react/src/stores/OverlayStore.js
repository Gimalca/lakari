'use strict';

import BaseStore from './BaseStore';
import ProductStore from './ProductStore';
import {constants} from '../constants/actions';
import {lakariDispatcher as dispatcher} from '../dispatchers/LakariDispatcher';

var _isVisible = false;

$(document).on('EXPAND_PRODUCT', function (evt, product){
    if (ProductStore.isFixed()) {
        _isVisible = true;
        _overlayStore.emitChange();
    }
});

function _toggleOverlay(state) {
    _isVisible = state;
}

class OverlayStore extends BaseStore {

    isVisible() { 
        return _isVisible; 
    }
}

var _overlayStore = new OverlayStore();

_overlayStore.dispatchToken = dispatcher.register(payload => {
    switch (payload.action.actionType) {
        case constants.TOGGLE_OVERLAY:
            _toggleOverlay(payload.action.state);
            _overlayStore.emitChange();
            break;
        default:
    }
    return true;
});

export default _overlayStore;
