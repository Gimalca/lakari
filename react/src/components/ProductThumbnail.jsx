'use strict';
import React from 'react';
import {actions} from '../actions/cart';

class ProductThumbnail extends React.Component {

    constructor(props) {
        super(props);

        this.onBuy = (e) => {
            e.preventDefault();
            var product = this.props.product;
            actions.addProduct(product); 
            $('#cd-cart-trigger').click();
        };

        this.onShare = (e) => {
            e.preventDefault();
        };

        this.onLike = (e) => {
            e.preventDefault();
        };

        this.handleClick = (e) => {
            e.preventDefault();
            var expander = $('.product-expander');
            expander.animate({
                opacity: '0.9',
                height: "100%"
            }, 500, function() {
                // Animation complete.
                $('html, body').animate({
                    scrollTop: expander.offset().top - 200 
                }, 2000);
            });
        };
    }

    render() {

        var product = this.props.product;

        return (
        <div className='thumbnail'> 
            <div className='caption'>
                <div className='row'>
                    <div className='col-md-12'>
                        <p>{product.title}</p>
                    </div>
                </div>
                <div className='row'>
                    <div className='col-xs-8 col-md-8'>
                        <div className='btn-group'>
                            <a  onClick={this.onBuy} href="#" className="btn btn-success btn-product">
                                <span className="glyphicon glyphicon-shopping-cart"></span> 
                            </a>
                            <a onClick={this.onLike} className="btn btn-primary btn-product">
                                <span className="glyphicon glyphicon-heart"></span>
                            </a>
                            <a onClick={this.onShare} href="#" className="btn btn-default btn-product">
                                <span className="glyphicon glyphicon-share"></span> 
                            </a>
                        </div> 
                    </div>
                    <div className='col-md-4 col-xs-4 price'>
                        <label>{product.price}</label>
                    </div>
                </div>
            </div>
            <a onClick={this.handleClick} hre="#">
                <img src={product.image} className="img-responsive" />
            </a>
        </div>);
    }

}

export default ProductThumbnail;

