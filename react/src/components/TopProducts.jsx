'use strict';
import React from 'react';
import ProductThumbnail from './ProductThumbnail';
import Slider from './Slider';

class TopProducts extends React.Component {

    constructor(props) {
        super(props);
    }

    shouldComponentUpdate() {
        return false;
    }

    render() {

        var topSeller = this.thumbNail(this.props.best);
        var topNew = this.thumbNail(this.props.news);

        return (<div>
                    <h1> Los mas Vendidos </h1>
                    <Slider autoPlay={12}>{topSeller}</Slider>
                    <hr />
                    <h1> Los mas Nuevos </h1>
                    <Slider autoPlay={10}>{topNew}</Slider>
                </div>);
    }

    thumbNail(products) {
        return products.map((item, i) => {
            return <ProductThumbnail key={i} product={item} />
        });
    }

}

export default TopProducts;
