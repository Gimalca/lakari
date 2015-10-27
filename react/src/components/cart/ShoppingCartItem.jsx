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
        let image = item.images[0].image ? item.images[0].image: item.image; 
        let description = item.description;

        return (<div className='item'>
            <div className='item-image'>
                <img height='68px' width='68px' src={image} alt='image' />
            </div>
            <div className='item-description'>
                <div className='description-row'>
                    <span className='name'>{description}</span>
                    <span onClick={this.handleRemove.bind(this, item)} className='times'>
                        <p>&times;</p>
                    </span>
                </div>
                <div className='description-row'>
                <span className='quantity'>
                    <label className='quantity-label'>QTY</label>
                    <input className='input-quantity' type='text' readOnly value='1' />
                    <div className='control-quantity'>
                        <span className='up'>&nbsp;</span>
                        <span className='down'>&nbsp;</span>
                    </div>
                </span>
                <span className='price'>{item.price + '€'}</span>
                </div>
            </div>
        </div>);
    }
}

export default ShoppingCartItem;
