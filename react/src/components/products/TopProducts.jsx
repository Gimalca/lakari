'use strict';

import React from 'react';
import ProductThumbnail from './ProductThumbnail';
import ProductExpander from './ProductExpander';
import OwlCarousel from '../common/OwlCarousel';

import ProductStore from '../../stores/ProductStore';

class TopProducts extends React.Component {

    constructor(props) {
        super(props);

        this.state = {
            selected: ProductStore.getSelected()
        };

        this.handleProductChange = (e) => {

            var $expander = $(React.findDOMNode(this.refs.expander));

            $expander.show();
            $expander.animate({
                opacity: '0.9',
                height: "640px"
            }, {
                duration: 300,
                complete: function () {
                    $('html, body').animate({
                        scrollTop: $expander.offset().top - 200 
                    }, 300);
                }
            });

            this.setState({
                selected: ProductStore.getSelected()
            });

        };
    }

    componentDidMount() {
        ProductStore.addChangeListener(this.handleProductChange);
    }

    componentDidUnmount() {
        ProductStore.removeListener(this.handleProductChange);
    }

    render() {

        var topSeller = this.thumbNail(this.props.best);
        var topNew = this.thumbNail(this.props.news);

        var selected = this.state.selected;

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
        
        return (<div>
                    <div className='row'>
                        <h3 className='main-title'> Los mas Vendidos </h3>
                        <div className='col-md-12' >
                        <OwlCarousel options={carouselOptions}>{topSeller}</OwlCarousel>
                        </div>
                    </div>
                    <hr />
                    <div className='row hidden-xs'>
                        <ProductExpander ref='expander' product={selected} />
                    </div>
                    {selected?<hr />:''}
                    <div className='row'>
                        <h3 className='main-title'> Los mas Nuevos </h3>
                        <div className='col-md-12' >
                        <OwlCarousel options={carouselOptions}>{topNew}</OwlCarousel>
                        </div>
                    </div>
                </div>);
    }


    thumbNail(products) {
        return products.map((item, i) => {
            return <ProductThumbnail key={i} product={item}  />
        });
    }

}

export default TopProducts;
