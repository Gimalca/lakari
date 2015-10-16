'use strict';

import React from 'react';
import OverlayStore from '../../stores/OverlayStore';
import {actions} from '../../actions/cart';

class Overlay extends React.Component {

    constructor(props) {
        super(props);
        
        this.state = {
            visible: OverlayStore.isVisible()
        };

        this.shadowClick = (e) => {
            actions.toggleOverlay(false);
        };

        this.onChange = (e) => {
            this.setState({
                visible: OverlayStore.isVisible()
            });
        };
    }

    componentDidMount() {
        OverlayStore.addChangeListener(this.onChange);
    }

    componentDidUnmount() {
        OverlayStore.removeChangeListener(this.onChange);
    }

    render() {
        var shadowLayer = 'shadow-layer' + (this.state.visible ? ' is-visible':'');
        return <div onClick={this.shadowClick} className={shadowLayer}></div>
    }
}

export default Overlay;
