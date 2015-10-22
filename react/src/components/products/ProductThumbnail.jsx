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
        var image = product.images.length > 0 ? product.images[0].image: product.image;

        return (<div className="grid_element">
                        <div className="product_photo">
                            <a href='#'>
                            <img className='product-image img-responsive' src="http://placehold.it/270x300" onerror="if (this.src != 'error.jpg') this.src ='http://placehold.it/270x300';"/>
                            </a>
                            <div className="quicklook">
                            <a onClick={this.handleClick.bind(this, product)} href='#'><span>QUICK LOOK</span></a>
                            </div>
                        </div>  
                        <div className="element_info">
                            <div className="prod_name_grid">
                                <a className="name pointer" href="#">{product.description}</a>
                                <div className="prizes">
                                <span className="range">{product.price}&nbsp;€&nbsp;</span>
                                </div>
                            </div>
                        </div> 
                    </div>);
    }
}

export default ProductThumbnail;
