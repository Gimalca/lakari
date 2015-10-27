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
            products: CartStore.getProducts(),
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

    render() {

        var total = 0; 
        let products = this.state.products;
        let items = products.map( (product, i) => {
            total += parseInt(product.price, 10);
            return (<ShoppingCartItem item={product} key={i} />);
        });

        var cartClass   = 'cart' + (this.state.isShowing ? ' open' : '');

        return (<div className={cartClass}>
            <span className='arrow'></span>
            <span className='close'>Close</span>
            { items.length > 0 ? <div className='items'>{items}</div>: 'Empty Bag'}
            <div className='subtotal'>
                <span>Subtotal:</span>
                <span>{total} €</span>
            </div>
            <div className='checkout-buttons'>
                <a href='#' className='confirm'>Confirmar</a>
            </div>
        </div>);

    }
}

export default ShoppingCart;
