'use strict';

import React from 'react';
import ShoppingCart from './components/cart/ShoppingCart';
import CartTrigger from './components/cart/CartTrigger';
import Overlay from './components/common/Overlay';
import ProductDetail from './components/products/ProductDetail';
import ProductService from './services/products';

// Añadir a las vistas que interactuan 
// con el carrito de compra mientras no 
// un template con react router

var shoppingCart = document.getElementById('cd-cart');
var cartTrigger  = document.getElementById('cd-cart-trigger');
var overlay      = document.getElementById('cd-overlay');

React.render(<CartTrigger />, cartTrigger);
React.render(<ShoppingCart />, shoppingCart);
React.render(<Overlay />, overlay);

var $expander = $('#product-expander');

function expanderClose(expander, isFixed) {
    console.log(isFixed)
    if (!isFixed) {
        expander.animate({
            opacity: '0',
            left: "+=50",
            height: "0"
        }, 500, function() {
            // Animation complete.
        });
    } else {
        expander.hide();
    }
}

function expanderShow(expander, isFixed) {
    console.log(isFixed) 
    if (!isFixed) {
        expander.show();
        expander.animate({
            opacity: '1',
            height: "640px",
            display: 'block'
        }, {
            duration: 300,
            complete: function () {
                $('html, body').animate({
                    scrollTop: expander.offset().top - 200 
                }, 300);
            }
        });
    } else {
        expander.show();
        $(expander).css('opacity', 1);
        $(expander).height('auto');
    }
}

React.render(<ProductDetail onClose={expanderClose} onShow={expanderShow} />, document.getElementById('product-expander'));
