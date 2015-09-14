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
        id: '1',
        price: '649.99', 
        title: 'Jarra joven', 
        image: BASE_URL + 'yes_thumbs_vase-443x500-430x480.jpg'
    },
    { 
        id: '2',
        price: '649.99', 
        title: 'Despertador Divertido', 
        image: BASE_URL + 'yes_thumbs_analog_alarm_clock-430x480.jpg'
    },
    { 
        id: '3',
        price: '649.99', 
        title: 'Plato Precioso', 
        image: BASE_URL + 'yes_thumbs_black_bowl-443x500-430x480.jpg '
    },
    { 
        id: '4',
        price: '649.99', 
        title: 'Copa Cruzada', 
        image: BASE_URL + 'yes_thumbs_black_cups-443x500-430x480.jpg'
    },
    { 
        id: '5',
        price: '649.99', 
        title: 'Boligrafo Bello', 
        image: BASE_URL + 'yes_thumbs_chrome_pen-430x480.jpg '
    },
    { 
        id: '6',
        price: '649.99', 
        title: 'Pajaro Picante', 
        image: BASE_URL + 'yes_thumbs_cast_iron_birds-430x480.jpg'
    },
    { 
        id: '7',
        price: '649.99', 
        title: 'Tijeras Torcidas', 
        image: BASE_URL + 'yes_thumbs_scissors-430x480.jpg'
    }
];

var topNew = [
    { 
        id: '8',
        price: '649.99', 
        title: 'Rompecabeza Ruidoso', 
        image: BASE_URL + 'yes_thumbs_wood_puzzle-430x480.jpg'
    },
    { 
        id: '9',
        price: '649.99', 
        title: 'Libro Loco', 
        image: BASE_URL + 'yes_thumbs_helvetica_book-430x480.jpg'
    },
    { 
        id: '1',
        price: '649.99', 
        title: 'Jabonera Jovial', 
        image: BASE_URL + 'yes_thumbs_tina_frey_dishes1-430x480.jpg'
    },
    { 
        id: '9',
        price: '649.99', 
        title: 'Jarron Juvenil', 
        image: BASE_URL + 'yes_thumbs_sphrical_vase-430x480.jpg'
    },
    { 
        id: '15',
        price: '649.99', 
        title: 'Olla Original', 
        image: BASE_URL + 'yes_thumbs_castiron_cassarol_dish-430x480.jpg'
    },
    { 
        id: '12',
        price: '649.99', 
        title: 'Vela Valiente', 
        image: BASE_URL + 'yes_thumbs_concretecandle-443x500-430x480.jpg'
    },
    { 
        id: '19',
        price: '649.99', 
        title: 'Revista Responsable', 
        image: BASE_URL + 'yes_thumbs_super_normal-430x480.jpg'
    }
];

React.render(<CartTrigger />, cartTrigger);
React.render(<ShoppingCart />, shoppingCart);

React.render(
    <TopProducts best={bestSeller} news={topNew} />, topProducts
);


