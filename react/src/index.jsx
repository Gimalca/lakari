'use strict';

import React from 'react';
import TopProducts from './components/products/TopProducts';
import ShoppingCart from './components/cart/ShoppingCart';
import CartTrigger from './components/cart/CartTrigger';

// Añadir a las vistas que interactuan 
// con el carrito de compra mientras se arma 
// un template con react router
var shoppingCart = document.getElementById('cd-cart');
var cartTrigger  = document.getElementById('cd-cart-trigger');
// Particular para el index
var topProducts  = document.getElementById('slider-products');


React.render(<CartTrigger />, cartTrigger);
React.render(<ShoppingCart />, shoppingCart);

var bestSeller = JSON.parse(document.getElementById('bestSellerJSON').textContent);
var topNew = JSON.parse(document.getElementById('latestJSON').textContent)

React.render(<TopProducts best={bestSeller} news={topNew} />, topProducts);
