'use strict';
import React from 'react';
import ShoppingCart from './components/ShoppingCart';
import CartTrigger from './components/CartTrigger';
import ProductThumbnail from './components/ProductThumbnail';

// Añadir a las vistas que interactuan 
// con el carrito de compra mientras se arma 
// un template con react router
var shoppingCart = document.getElementById('cd-cart');
var cartTrigger  = document.getElementById('cd-cart-trigger');

React.render(<CartTrigger />, cartTrigger);
React.render(<ShoppingCart />, shoppingCart);

var item =  { 
        id: '1',
        price: '649.99', 
        title: 'Jarra joven', 
        image: BASE_URL + 'yes_thumbs_vase-443x500-430x480.jpg'
};

React.render(<ProductThumbnail product={item} />, document.getElementById('product'));
