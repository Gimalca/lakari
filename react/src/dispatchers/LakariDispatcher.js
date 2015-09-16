'use strict';
import Flux from 'flux';

class LakariDispatcher extends Flux.Dispatcher {

    // Metodo para registrar Eventos
    // desde las vistas/components
    handleViewAction(action) {
        this.dispatch({
            source: 'VIEW_ACTION',
            action
        });
    }

    // Acciones que provienen del servidor
    handleServerAction(action) {
        this.dispatch({
            source: 'SERVER_ACTION',
            action
        });
    }
}

export let lakariDispatcher = new LakariDispatcher();

