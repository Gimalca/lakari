'use strict';

import React from 'react';
import ShoppingCart from './components/cart/ShoppingCart';
import CartTrigger from './components/cart/CartTrigger';
import ProductGrid from './components/products/ProductGrid';
import ProductService from './services/products';

// Añadir a las vistas que interactuan 
// con el carrito de compra mientras se arma 
// un template con react router

var shoppingCart = document.getElementById('cd-cart');
var cartTrigger  = document.getElementById('cd-cart-trigger');

React.render(<CartTrigger />, cartTrigger);
React.render(<ShoppingCart />, shoppingCart);

var products = JSON.parse(document.getElementById('productsJSON').textContent);

React.render(<ProductGrid items={products} />, document.getElementById('product'));
