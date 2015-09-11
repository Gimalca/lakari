'use strict';

import React from 'react';
import TopProducts from './components/TopProducts';
import ShoppingCart from './components/ShoppingCart';
import CartTrigger from './components/CartTrigger';

// Añadir a las vistas que interactuan 
// con el carrito de compra mientras se arma 
// un template con react router
var shoppingCart = document.getElementById('cd-cart');
var cartTrigger  = document.getElementById('cd-cart-trigger');
// Particular para el index
var topProducts  = document.getElementById('slider-products');

var bestSeller = [
    { 
        price: '$649.99', 
        title: 'Jarra joven', 
        image: 'yes_thumbs_vase-443x500-430x480.jpg'
    },
    { 
        price: '$649.99', 
        title: 'Despertador Divertido', 
        image: 'yes_thumbs_analog_alarm_clock-430x480.jpg'
    },
    { 
        price: '$649.99', 
        title: 'Plato Precioso', 
        image: 'yes_thumbs_black_bowl-443x500-430x480.jpg '
    },
    { 
        price: '$649.99', 
        title: 'Copa Cruzada', 
        image: 'yes_thumbs_black_cups-443x500-430x480.jpg'
    },
    { 
        price: '$649.99', 
        title: 'Boligrafo Bello', 
        image: 'yes_thumbs_chrome_pen-430x480.jpg '
    },
    { 
        price: '$649.99', 
        title: 'Pajaro Picante', 
        image: 'yes_thumbs_cast_iron_birds-430x480.jpg'
    },
    { 
        price: '$649.99', 
        title: 'Tijeras Torcidas', 
        image: 'yes_thumbs_scissors-430x480.jpg'
    }
];

var topNew = [
    { 
        price: '$649.99', 
        title: 'Rompecabeza Ruidoso', 
        image: 'yes_thumbs_wood_puzzle-430x480.jpg'
    },
    { 
        price: '$649.99', 
        title: 'Libro Loco', 
        image: 'yes_thumbs_helvetica_book-430x480.jpg'
    },
    { 
        price: '$649.99', 
        title: 'Jabonera Jovial', 
        image: 'yes_thumbs_tina_frey_dishes1-430x480.jpg'
    },
    { 
        price: '$649.99', 
        title: 'Jarron Juvenil', 
        image: 'yes_thumbs_sphrical_vase-430x480.jpg'
    },
    { 
        price: '$649.99', 
        title: 'Olla Original', 
        image: 'yes_thumbs_castiron_cassarol_dish-430x480.jpg'
    },
    { 
        price: '$649.99', 
        title: 'Vela Valiente', 
        image: 'yes_thumbs_concretecandle-443x500-430x480.jpg'
    },
    { 
        price: '$649.99', 
        title: 'Revista Responsable', 
        image: 'yes_thumbs_super_normal-430x480.jpg'
    }
];

React.render(<CartTrigger />, cartTrigger);
React.render(<ShoppingCart />, shoppingCart);

React.render(
    <TopProducts best={bestSeller} news={topNew} />, topProducts
);


