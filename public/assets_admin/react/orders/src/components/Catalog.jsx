'use strict';
import React from 'react';
import KartActions from '../actions/kart';
import KartStore from '../stores/KartStore';

class Catalog extends React.Component {

    constructor(props) {
        super(props);

        this.addToKart = (e) => {
            e.preventDefault();
            var id = this.refs.product_id.getDOMNode().value;
            if(id) {
                let orderId = KartStore.getOrderId();
                KartActions.addItem(id, orderId);
            }
        };
    }

    componentDidMount() {
        let filter = React.findDOMNode(this.refs.product_id);
        $(filter).select2({ placeholder: "Seleccione un Producto", allowClear: true });
    }

    render() {
        let addLabel = 'Add to Kart';

        let products = this.props.products.map( (product, i) => {
            return (<option key={i} value={product.id}>{product.name}</option>);
        }); 

        return (
        <div className='col-xs-12 col-sm-12 col-md-12'>
            <div className='hidden-xs col-sm-3 col-md-4'></div>
            <div className='col-xs-10 col-sm-6 col-md-6'>
            <select style={{maxWidth:'600px', width:'100%',float:'right'}} className='form-control gui-input' ref='product_id' name='product_id'>
                <option></option>
                {products}
            </select>
            </div>
            <span className='col-xs-2 col-sm-3 col-md-2'>
        <button className='btn btn-primary' onClick={this.addToKart}>
            <span style={{padding:'5px 10px'}} className='hidden-sm hidden-md hidden-lg glyphicon glyphicon-plus'></span>
            <span className='hidden-xs'>Añadir Producto</span>
        </button>
        </span>
        </div>);
    }
}

export default Catalog;
