'use strict';

import React from 'react';
import {actions} from '../../actions/cart';

class ShoppingCartItem extends React.Component {

    constructor(props) {
        super(props);

        this.handleRemove = (product) => {
            actions.removeProduct(product);
        }
    }

    render() {
        let item = this.props.item;

        return (<span className="item">
            <span className="item-left">
                <div className='item-img'>
                    <img className='img-responsive' src={item.image} alt="50x50" />
                </div>
                <span className="item-info">
                    <span style={{maxWidth:'50px'}} >{item.title}</span>
                    <span>{item.price + ' $'}</span>
                </span>
            </span>
            <span className="item-right">
                <button onClick={this.handleRemove.bind(this, item)} className="btn btn-xs btn-danger pull-right">x</button>
            </span>
        </span>);
    }
}

export default ShoppingCartItem;
