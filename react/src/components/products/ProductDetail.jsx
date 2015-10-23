'use strict';

import React from 'react';
import OwlCarousel from '../common/OwlCarousel';
import ProductStore from '../../stores/ProductStore';
import {actions} from '../../actions/cart';

var MIN_DEVICE_WIDTH = 1210;

class ProductDetail extends React.Component {

    constructor(props) {
        super(props);

        this.state = {
            selected: ProductStore.getSelected(),
            isFixed: ProductStore.isFixed()
        };

        this.onClose = (e) => {
            var $this = $(React.findDOMNode(this));
            actions.toggleOverlay(false);
            this.props.onClose($this);
        };

        this.handleAdd = (e) => {
            var product = this.state.selected;
            actions.addProduct(product); 
        };

        this.onChange = () => {

            this.setState({
                selected: ProductStore.getSelected(),
                isFixed: ProductStore.isFixed()
            });
            this.appear();
        };
    }

    getCarouselOptions() {

        var leftNavigation = '<a class="left carousel-control" role="button"> <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span> <span class="sr-only">Previous</span></a>';

        var rightNavigation = '<a class="right carousel-control" role="button"><span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span><span class="sr-only">Next</span></a>';

        let carouselOptions = {
            singleItem: true,
            autoPlay: true,
            navigation:true,
            stopOnHover: true,
            navigationText: [leftNavigation, rightNavigation] 
        };

        return carouselOptions;
    }

    componentDidMount() {
        ProductStore.addChangeListener(this.onChange);
    }

    componentWillUnMount() {
        ProductStore.removeChangeListener(this.onChange); 
    }

    render() {

        let product = this.state.selected;

        if (product) {

        let images = product.images.map((img, i) => {
            return (<img className='img img-responsive expander-img-product' src={img.image} key={i} />);
        });

        let title = product.descriptions.name;
        let description = product.descriptions;
        let carouselOptions = this.getCarouselOptions();
        let expanderClass = 'product-expander flex hidden-xs'  + (this.state.isFixed ? ' expander-fixed' : '');

        return (<div>
                 <div className={expanderClass}>
                    <div className='section section-1 col-xs-3 flex flex-vertical'>
                        <div className='product-resume flex-grow'>
                        <label className='product-title'>{title}</label>
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
                              <button onClick={this.handleAdd} type="button" className="btn btn-flat btn-confirm"> Comprar</button>
                              </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div className='section section-2 col col-xs-9 flex expander-img'>
                    <OwlCarousel update={true} options={carouselOptions}>
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

    appear() {
        var $this = $(React.findDOMNode(this));
        this.props.onShow($this);
    }
}

export default ProductDetail;
