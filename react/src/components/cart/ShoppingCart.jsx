'use strict';

import React from 'react';
import CartStore from '../../stores/CartStore';
import {actions} from '../../actions/cart';
import ShoppingCartItem from './ShoppingCartItem';

class ShoppingCart extends React.Component {

    constructor(props) {
        super(props);

        this.state = {
            isShowing: CartStore.isShowing(),
            products: CartStore.getProducts()
        };

        this.handleProductChange = (e) => {
            this.setState({
                isShowing: CartStore.isShowing(),
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

    handleClick(e) {
        actions.toggleCart();
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

        var cartClass   = 'cd-cart' + (this.state.isShowing ? ' speed-in' : '');
        var shadowLayer = 'shadow-layer' + (this.state.isShowing ? ' is-visible':'');

        return (<div>
        <div onClick={this.handleClick} className={shadowLayer}></div>
        <div className={cartClass}>
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
        </div>
    </div>);
    }
}

export default ShoppingCart;
