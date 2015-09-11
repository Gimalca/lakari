'use strict';
 import React from 'react';

 class CartTrigger extends React.Component {
     constructor(props) {
         super(props);
     }

     render() {
            return (<button className="btn btn-success btn-product" type="button"> 
                        <span className="glyphicon glyphicon-shopping-cart"></span>
                        <span className="visible-xs navbar-link "> Carrito de Compras</span>
                    </button>);
    }
 }

 export default CartTrigger;
