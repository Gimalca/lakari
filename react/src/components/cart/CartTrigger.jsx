'use strict';

import React from 'react';
import CartStore from '../../stores/CartStore';
import {actions} from '../../actions/cart';

 class CartTrigger extends React.Component {

     constructor(props) {
         super(props);

         this.state = {
             isShowing: CartStore.isShowing(),
             quantity: 0
         }

         this.handleProductChange = (e) => {
             this.setState({
                quantity : CartStore.getProducts().length,
                isShowing: CartStore.isShowing()
             });
         };

         this.handleClick = (e) => {
             actions.toggleCart();
         };
     }

    componentDidMount() {
        CartStore.addChangeListener(this.handleProductChange);
    }

    componentDidUnmount() {
        CartStore.removeListener(this.handleProductChange);
    }

     render() {
         let amount = this.state.quantity;

         let styles = {
            display: amount > 0? 'block': 'none'
         };

         return (<button onClick={this.handleClick} className="btn btn-success btn-product" type="button"> 
                    <span >
                    { this.state.isShowing ? 
                        <i className="fa fa-times"></i> : <i className="fa fa-shopping-cart"></i> }
                    </span>
                    <span className="visible-xs navbar-link "> Carrito de Compras</span>
                    <div style={styles} className="basket-item-count">
                        <span className="count">{amount}</span>
                    </div>
                </button>);
    }

 }

 export default CartTrigger;
