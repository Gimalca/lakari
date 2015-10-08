'use strict';

import React from 'react';
import {actions} from '../../actions/cart';

class ProductThumbnail extends React.Component {

    constructor(props) {
        super(props);

        this.onBuy = (e) => {
            e.preventDefault();
            var product = this.props.product;
            actions.addProduct(product); 
        };

        this.onShare = (e) => {
            e.preventDefault();
        };

        this.onLike = (e) => {
            e.preventDefault();
        };

        this.handleClick = (product, e) => {
            e.preventDefault();
            this.props.onSelect(product);
        };
    }

    render() {

        var product = this.props.product;
        var image = product.images[0].image;

        return (<div className='product thumbnail product-thumbnail'> 
            <div className='caption'>
                <div className='row'>
                    <div className='product-info col-md-12'>
                        <h3 className='name'>{product.description}</h3>
                    </div>
                </div>
                <div className='row product-info'>
                    <div className='col-xs-8 col-md-8'>
                    <div className="cart clearfix animate-effect">
                        <div className="action">
                            <ul className="list-unstyled">
                                <li className="add-cart-button btn-group">
                                    <button onClick={this.onBuy} className="btn btn-primary icon" data-toggle="dropdown" type="button">
                                        <i className="fa fa-shopping-cart"></i>                                                 
                                    </button>
                                    <button className="btn btn-primary" type="button">Comprar</button>
                                </li>
                            </ul>
                        </div>
                    </div>
                    </div>
                    <div className='col-md-4 col-xs-4 product-price'>
                        <span className='price' >{product.price + '$'}</span>
                    </div>
                </div>
            </div>
            <div style={this.props.imageStyle} className='product-image'>
                <div className='image'>
                    <a onClick={this.handleClick.bind(this, product)} href="#">
                        <img src={image} className="img-responsive" />
                    </a>
                    <span className="lnk media-buttons">
                        <ul className="list-inline">
                            <li className="likes-btn" href="#" title="Wishlist">
                                <i className="icon fa fa-heart fa-reverse"></i>
                            </li>
                            <li className="tweets-btn" href="#" title="Compare">
                                <i className="fa fa-retweet"></i>
                            </li>
                        </ul>
                    </span>
                </div>
            </div>
        </div>);
    }
}

export default ProductThumbnail;
