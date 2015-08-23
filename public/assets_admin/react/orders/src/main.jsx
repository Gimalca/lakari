'use strict';
import React from 'react';
import App from './components/App';

var app = React.render(
    <App users={JSON.parse(CUSTOMERS)} products={JSON.parse(PRODUCTS)} />,
    document.getElementById('content')
);

export default app;
