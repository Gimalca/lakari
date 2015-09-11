'use strict';
import React from 'react';

class ProductThumbnail extends React.Component {

    constructor(props) {
        super(props);
    }

    render() {

        var directory = 'assets/images/test/';
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
                            <a href="#" className="btn btn-success btn-product">
                                <span className="glyphicon glyphicon-shopping-cart"></span> 
                            </a>
                            <a className="btn btn-primary btn-product">
                                <span className="glyphicon glyphicon-heart"></span>
                            </a>
                            <a href="#" className="btn btn-default btn-product">
                                <span className="glyphicon glyphicon-share"></span> 
                            </a>
                        </div> 
                    </div>
                    <div className='col-md-4 col-xs-4 price'>
                        <label>{product.price}</label>
                    </div>
                </div>
            </div>
            <img src={ directory + product.image} className="img-responsive" />
        </div>);
    }
}

export default ProductThumbnail;

