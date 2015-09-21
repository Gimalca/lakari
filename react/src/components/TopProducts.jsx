'use strict';
import React from 'react';
import ProductThumbnail from './ProductThumbnail';
import ProductExpander from './ProductExpander';
import Slider from './Slider';

class TopProducts extends React.Component {

    constructor(props) {
        super(props);

        this.state = {
            selected: 1
        };
    }

    shouldComponentUpdate() {
        return false;
    }

    render() {

        var topSeller = this.thumbNail(this.props.best);
        var topNew = this.thumbNail(this.props.news);
        let selected = this.props.best[this.state.selected];

        return (<div>
                    <div className='row'>
                        <h3 className='main-title'> Los mas Vendidos </h3>
                        <Slider autoPlay={12}>{topSeller}</Slider>
                    </div>
                    <hr />
                    <div className='row'>
                        <ProductExpander product={selected} />
                    </div>
                    <hr />
                    <div className='row'>
                        <h3 className='main-title'> Los mas Nuevos </h3>
                        <Slider autoPlay={10}>{topNew}</Slider>
                    </div>
                </div>);
    }

    thumbNail(products) {
        return products.map((item, i) => {
            return <ProductThumbnail key={i} product={item} />
        });
    }

}

export default TopProducts;
