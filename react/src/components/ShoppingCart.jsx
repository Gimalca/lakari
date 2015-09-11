'use strict';

import React from 'react';

class ShoppingCart extends React.Component {
    constructor(props) {
        super(props);
    }

    render() {
        return (<div>
            <h2>Cart</h2>
            <ul className="cd-cart-items">
                <li>
                    <span className="cd-qty">1x</span> Product Name
                    <div className="cd-price">$9.99</div>
                    <a href="#0" className="cd-item-remove cd-img-replace">Remove</a>
                </li>

                <li>
                    <span className="cd-qty">2x</span> Product Name
                    <div className="cd-price">$19.98</div>
                    <a href="#0" className="cd-item-remove cd-img-replace">Remove</a>
                </li>

                <li>
                    <span className="cd-qty">1x</span> Product Name
                    <div className="cd-price">$9.99</div>
                    <a href="#0" className="cd-item-remove cd-img-replace">Remove</a>
                </li>
            </ul> 
            <div className="cd-cart-total">
                <p>Total <span>$39.96</span></p>
            </div> 
            <a href="#0" className="checkout-btn">Checkout</a>
            <p className="cd-go-to-cart"><a href="#0">Go to cart page</a></p>
            </div>);
    }
}

export default ShoppingCart;
