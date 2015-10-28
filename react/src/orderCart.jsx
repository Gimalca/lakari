'use strict';

import React from 'react';
import UserService from './services/users';
import OrderService from './services/orders';
import App from './components/orders/App';

var app = React.render(
    <App users={JSON.parse(CUSTOMERS)} products={JSON.parse(PRODUCTS)} />,
    document.getElementById('content')
);

export default app;
