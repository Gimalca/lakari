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
             var isShowing = this.state.isShowing;

             if (isShowing) {
                 actions.hideCart();
             } else {
                actions.showCart();
             }
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

         return (<a className='cart-trigger' onClick={this.handleClick}> 
                    <span >
                    { this.state.isShowing ? 
                        <i className="fa fa-times"></i> : <i className="fa fa-shopping-cart"></i> }
                    </span>
                    <div style={styles} className="basket-item-count">
                        <span className="count">{amount}</span>
                    </div>
                </a>);
    }

 }

 export default CartTrigger;
