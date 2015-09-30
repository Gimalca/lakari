'use strict';

import React from 'react';
import CartStore from '../../stores/CartStore';
import ShoppingCartItem from './ShoppingCartItem';

class ShoppingCart extends React.Component {

    constructor(props) {
        super(props);

        this.state = {
            products: CartStore.getProducts()
        };

        this.handleProductChange = (e) => {
            this.setState({
                products: CartStore.getProducts()
            });
        }
    }

    componentDidMount() {
        CartStore.addChangeListener(this.handleProductChange);
    }

    componentDidUnmount() {
        CartStore.removeListener(this.handleProductChange);
    }

    render() {
        var total = 0; 
        let products = this.state.products;
        let items = products.map( (product, i) => {
            total += parseInt(product.price, 10);
            return (<li key={i}> 
                        <ShoppingCartItem item={product} />
                    </li>);
        });

        return (<div>
            <div className='w-full-height w-horizontal-centered'>
                <div className='scrollable'>
                    <ul className="cd-cart-items dropdown-cart">
                        {items}
                    </ul> 
                </div>
            </div>
            <div className='cd-cart-checkout w-horizontal-centered'>
                <div className="cd-cart-total">
                    <p>{'Total = $' + total}</p>
                </div>
                <a href="#0" className="checkout-btn">Checkout</a>
                <a href="#0" className='go-to-cart-btn'>Go to cart page</a>
            </div>
            </div>);
    }
}

export default ShoppingCart;
