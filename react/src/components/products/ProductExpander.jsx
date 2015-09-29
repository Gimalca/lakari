'use strict';
import React from 'react';
import OwlCarousel from '../common/OwlCarousel';
import {actions} from '../../actions/cart';

class ProductExpander extends React.Component {

    constructor(props) {
        super(props);

        this.onClose = () => {

        var $this = $(React.findDOMNode(this));

        $this.animate({
                opacity: '0',
                left: "+=50",
                height: "0"
            }, 500, function() {
                // Animation complete.
            });
        };

        this.handleAdd = (e) => {
            var product = this.props.product;
            actions.addProduct(product); 
        };
    }

    componentDidMount() {
        $(React.findDOMNode(this)).hide();
    }

    render() {

        let product = this.props.product;
        if (product) {

        let images = product.images.map((img, i) => {
            return (<img className='img img-responsive expander-img-product' src={img.image} alt='http://placehold.it/800x600' key={i} />);
        });

        var leftNavigation = '<a class="left carousel-control" role="button"> <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span> <span class="sr-only">Previous</span></a>';

        var rightNavigation = '<a class="right carousel-control" role="button"><span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span><span class="sr-only">Next</span></a>';

        let carouselOptions = {singleItem: true, autoPlay: true,navigation:true, stopOnHover: true, navigationText: [leftNavigation, rightNavigation] };

        let title = product.descriptions.name;
        let description = product.descriptions;
        return (<div>
                 <div className='product-expander flex hidden-xs'>
                    <div className='section section-1 col-xs-3 flex flex-vertical'>
                        <div className='product-resume flex-grow'>
                        <label className='product-title main-title'>{title}</label>
                        <hr />
                        <label className='product-title brand-title'>Marca</label>
                        <div className='product-description'>
                            <p>{product.description}</p>
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
                            <p>{description.description}</p>
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
                    <OwlCarousel options={carouselOptions}>
                        {images}
                    </OwlCarousel>
                    <button onClick={this.onClose} type="button" className="close" aria-hidden="true">
                        &times;
                    </button>
                </div>
            </div>
            </div>);
        } else {
            return null;
        }
    }
}

export default ProductExpander;

