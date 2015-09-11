'use strict';
import React from 'react';
import ProductThumbnail from './ProductThumbnail';
import Slider from './Slider';

function thumbNailer(products) {
    return products.map(function (item, i) {
        return <ProductThumbnail key={i} product={item} />
    });
}

class TopProducts extends React.Component {

    constructor(props) {
        super(props);
    }

    shouldComponentUpdate() {
        return false;
    }

    render() {

        var topSeller = thumbNailer(this.props.best);
        var topNew = thumbNailer(this.props.news);

        return (<div>
                    <h1> Los mas Vendidos </h1>
                    <Slider items={topSeller} />
                    <hr />
                    <h1> Los mas Nuevos </h1>
                    <Slider items={topNew} />
                </div>);
    }
}

export default TopProducts;
