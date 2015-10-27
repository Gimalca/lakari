'use strict';

import ProductStore from '../../stores/ProductStore';
import ProductThumbnail from './ProductThumbnail';
import OwlCarousel from '../common/OwlCarousel';
import ProductDetail from './ProductDetail';
import ProductService from '../../services/products';
import {actions} from '../../actions/cart';
import colors from '../common/colors';
import React from 'react';

class TopProducts extends React.Component {

    constructor(props) {
        super(props);

        this.state = {
            selected: ProductStore.getSelected()
        };

        this.handleSelectProduct = (product) => {
            actions.expandProduct(product);
        };

        this.handleProductChange = (e) => {

            this.setState({
                selected: ProductStore.getSelected()
            });

            React.findDOMNode(this.refs.expander).show();
        };
    }

    componentDidMount() {
        ProductStore.addChangeListener(this.handleProductChange);
    }

    componentWillUnmount() {
        ProductStore.removeListener(this.handleProductChange);
    }

    getCarouselOptions() {

        var leftNavigation = '<a class="left carousel-control" role="button"> <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span> <span class="sr-only">Previous</span></a>';

        var rightNavigation = '<a class="right carousel-control" role="button"><span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span><span class="sr-only">Next</span></a>';

        let carouselOptions = {    
            items : 4,
            navigation : true,
            slideSpeed : 900,
            pagination: false,
            paginationSpeed : 800,
            navigationText: [leftNavigation, rightNavigation],
            lazyLoad: true,
            autoPlay: 12000,
            stopOnHover: true,
            singleItem: false,
            itemsScaleUp: true
        };

        return carouselOptions;
    }

   handleExpanderShow($expander) {

        $expander.show();
        $expander.animate({
            opacity: '1',
            height: "640px"
        }, {
            duration: 300,
            complete: function () {
                $('html, body').animate({
                    scrollTop: $expander.offset().top - 200 
                }, 300);
            }
        });
    }

     handleExpanderClose($expander) {

        $expander.animate({
            opacity: '0',
            left: "+=50",
            height: "0"
        }, 500, function() {
            // Animation complete.
        });

    }

    render() {

        var topSeller = this.thumbnail(this.props.best);
        var topNew = this.thumbnail(this.props.news);

        let carouselOptions = this.getCarouselOptions(); 
        let selected = this.state.selected;

        return (<div>
                    <div className='row'>
                        <h3 className='main-title'> Los mas Vendidos </h3>
                        <div className='col-md-12' >
                        <OwlCarousel update={false} options={carouselOptions}>{topSeller}</OwlCarousel>
                        </div>
                    </div>
                    <div className='row hidden-xs'>
                        <ProductDetail 
                        ref='expander'
                        onClose={this.handleExpanderClose} 
                        onShow={this.handleExpanderShow}
                        product={selected} />
                    </div>
                    <div className='row'>
                        <h3 className='main-title'> Los mas Nuevos </h3>
                        <div className='col-md-12' >
                        <OwlCarousel update={false} options={carouselOptions}>{topNew}</OwlCarousel>
                        </div>
                    </div>
                </div>);
    }

    randomColor() {
        var random = Math.floor(Math.random() * colors.length); 
        return colors[random];
    }

    thumbnail(products) {

        return products.map((item, i) => {
            var style = {backgroundColor: this.randomColor()}; 
            return <ProductThumbnail onSelect={this.handleSelectProduct} key={i} product={item} imageStyle={style} />
        });
    }
}

export default TopProducts;
