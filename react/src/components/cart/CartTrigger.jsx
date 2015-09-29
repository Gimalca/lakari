'use strict';

 import React from 'react';
 import CartStore from '../../stores/CartStore';

 class CartTrigger extends React.Component {

     constructor(props) {
         super(props);

         this.state = {
             quantity: 0
         }

         this.handleProductChange = (e) => {
             this.setState({
                quantity : CartStore.getProducts().length  
             });

             $(React.findDOMNode(this)).click();
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

         return (<button className="btn btn-success btn-product" type="button"> 
                    <span className="glyphicon glyphicon-shopping-cart"></span>
                    <span className="visible-xs navbar-link "> Carrito de Compras</span>
                    <div style={styles} className="basket-item-count">
                        <span className="count">{amount}</span>
                    </div>
                </button>);
    }
 }

 export default CartTrigger;
