'use strict';
import React from 'react';
import Slider from './Slider';
import {actions} from '../actions/cart';

class ProductExpander extends React.Component {

    constructor(props) {
        super(props);
        this.onClose = () => {
            $('.product-expander').fadeOut('slow');
        };

        this.handleAdd = (e) => {
            var product = this.props.product;
            actions.addProduct(product); 
            $('#cd-cart-trigger').click();
        };
    }

    render() {
        let product = this.props.product;

        return (<div className='product-expander flex hidden-xs'>
                    <div className='section section-1 col-xs-3 flex flex-vertical'>
                        <div className='product-resume flex-grow'>
                        <label className='product-title main-title'>{product.title}</label>
                        <hr />
                        <label className='product-title brand-title'>Marca</label>
                        <div className='product-description'>
                            <p>Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Vestibulum tortor quam</p>
                        </div>
                    </div>
                    <div className='product-details'>
                        <div className='product-prop'>
                            <label>Precio</label>
                            <span>${product.price}</span>
                        </div>
                        <hr />
                        <div className='product-description'>
                            <label>Descripción</label>
                            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
                        </div>
                        <hr />
                        <div className='product-prop'>
                            <label>Año</label>
                            <span>2015</span>
                        </div>
                        <hr />
                        <div className='product-prop'>
                            <label>Dimensiones</label>
                            <span>
                                <select className='select-prop'>
                                    <option>Grande</option>
                                    <option>Mediano</option>
                                    <option>Pequeño</option>
                                </select>
                            </span>
                        </div>
                        <hr />
                        <div className='product-prop'>
                            <label>Materiales</label>
                            <span><p>Tela y Cuero</p></span>
                        </div>
                        <hr />
                        <div className='product-actions'>
                            <div className="btn-group flex" role="group" aria-label="false">
                                <div className="btn-group flex-grow" role="group">
                                    <button type="button" className="btn btn-flat btn-details">Detalles</button>
                                </div>
                                <div className="btn-group" role="group">
                              <button onClick={this.handleAdd} type='button' className='btn btn-buy btn-flat'>
                                <span className="glyphicon glyphicon-shopping-cart"></span>
                              </button>
                            </div>
                            <div className="btn-group" role="group">
                              <button type="button" className="btn btn-flat btn-confirm"> Comprar</button>
                              </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div className='section section-2 col col-xs-9 flex expander-img'>
                    <Slider transition='fade' autoPlay={6} single={true}>
                        <img className='img-responsive' src='http://placehold.it/800x600' />
                        <img className='img-responsive' src='http://placehold.it/800x600?text=placehold.it+2' />
                        <img className='img-responsive' src='http://placehold.it/800x600?text=placehold.it+3' />
                    </Slider> 
                    <span onClick={this.onClose} className="close">X</span>
                </div>
            </div>);
}
}

export default ProductExpander;

