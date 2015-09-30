'use strict';

import React from 'react';
import ProductThumbnail from './ProductThumbnail';
import ProductExpander from './ProductExpander';
import OwlCarousel from '../common/OwlCarousel';


class TopProducts extends React.Component {

    constructor(props) {
        super(props);
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

    render() {

        var topSeller = this.thumbNail(this.props.best);
        var topNew = this.thumbNail(this.props.news);
        let carouselOptions = this.getCarouselOptions(); 
        return (<div>
                    <div className='row'>
                        <h3 className='main-title'> Los mas Vendidos </h3>
                        <div className='col-md-12' >
                        <OwlCarousel options={carouselOptions}>{topSeller}</OwlCarousel>
                        </div>
                    </div>
                    <div className='row hidden-xs'>
                        <ProductExpander  />
                    </div>
                    <div className='row'>
                        <h3 className='main-title'> Los mas Nuevos </h3>
                        <div className='col-md-12' >
                        <OwlCarousel options={carouselOptions}>{topNew}</OwlCarousel>
                        </div>
                    </div>
                </div>);
    }

    getColors() {

        const colors = [
            '#FFEFC1',
            '#DFEABF',
            '#E7B4B0',
            '#A5C1CF',
            '#E6665B',
            '#C5D5D4',
            '#F9EFB3',
            '#AACDDC',
            '#FFBE7B',
            '#C77B8D'
        ];

        return  colors;
    }

    randomColor(colors) {
        var random = Math.floor(Math.random() * colors.length); 
        return colors[random];
    }

    thumbNail(products) {

        let colors = this.getColors();

        return products.map((item, i) => {
            var style = {backgroundColor: this.randomColor(colors)}; 
            return <ProductThumbnail key={i} product={item} imageStyle={style} />
        });
    }
}

export default TopProducts;
