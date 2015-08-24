'use strict';
import Flux from 'flux';

class KartDispatcher extends Flux.Dispatcher {

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

let _kartDispatcher = new KartDispatcher();

export default _kartDispatcher;
