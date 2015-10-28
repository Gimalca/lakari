'use strict';

import React from 'react';
import {actions} from '../../actions/orders';
import KartStore from '../../stores/KartStore';

class Cart extends React.Component {

    constructor(props) {
        super(props);

        this.state = {
            cart: []
        };

        this.onChange = (e) => {

            this.setState({
                cart: KartStore.getCart()
            });
        }

        this.removeFromKart = (index, id) => {
            actions.removeItem(index, id);
        }

        this.decreaseItem = (index) => {
            actions.decreaseItem(index);
        }

        this.increaseItem = (index) => {
            actions.increaseItem(index);
        }

        this.handleClear = () => {
            actions.emptyKart();
        }
        
        this.handleChange = (index, e) => {
            let value = e.target.value;
            actions.changeQuantity(index, value);
        };
    }

    componentDidMount() {

    }

    componentWillMount() {
        KartStore.addChangeListener(this.onChange);
    }

    render() {

        var total = 0;
        var products = this.state.cart;

        let items = products.map( (product, i) => {

            let qty = product.quantity || '';

            if (product.quantity <= 0) {
                qty = 1;
            } 

            let subTotal = product.price * qty;
            total+= subTotal;

            return (<tr key={i}>
                     <td className='col-xs-2 romove-item'> 
                    <a onClick={this.removeFromKart.bind(this, i, product.product_id)} title='cancel' className='icon'> 
                        <i className='fa fa-trash-o'> </i>
                    </a>
                     </td> 
                     <td className='col-xs-3'>
                     <a className='entry-thumbnail'>
                        <img className='hidden-xs kart-image mw60 ib mr10 img-responsive img-thumbnail' src={product.image} alt='100x100'/> 
                        </a>
                        <div> {product.name} </div>
                    </td>
                     <td className='col-xs-2 cart-product-sub-total'>
                        <span className='cart-sub-total-price'>{'$ '+product.price}</span>
                    </td> 
                     <td className='col-xs-3 cart-product-quantity'>
                     <div className='quant-input'>
                     <div className="arrows">
                        <div onClick={this.increaseItem.bind(this, i)} className="arrow plus gradient">
                            <span className="ir">
                                <i className="icon fa fa-sort-asc"></i>
                            </span>
                        </div>
                        <div onClick={this.decreaseItem.bind(this, i)} className="arrow minus gradient">
                            <span className="ir">
                            <i className="icon fa fa-sort-desc"></i>
                            </span>
                        </div>
                     </div>
                        <input type='text' onChange={this.handleChange.bind(this, i)} value={qty} />
                    </div>
                    </td>
                    <td className='col-xs-2 cart-product-sub-total'>
                        <span className='cart-sub-total-price' >{'$ ' +subTotal}</span>
                    </td>
                    </tr>);
        });

        return (<div className='shopping-cart'>
                <div className='col-xs-12 col-md-10 col-sm-10'>
                <div className='bodycontainer scrollable shopping-cart-table'>
                <table className='table table-hover table-bordered table-scrollable'>
                <thead> 
                    <tr>
                        <th className="col-xs-2" >
                            <span className='glyphicon glyphicon-remove'></span>
                            <span className='hidden-xs'>Eliminar</span>
                        </th>
                        <th className="col-xs-3" >
                            <span className='glyphicon glyphicon-picture'> </span>
                            <span className='hidden-xs'>Producto</span>
                        </th>
                        <th className="col-xs-2">
                            <span className='glyphicon glyphicon-usd'> </span>
                            <span className='hidden-xs'>Precio</span>
                        </th>
                        <th className="col-xs-3">
                            <span className='glyphicon glyphicon-stats'> </span>
                            <span className='hidden-xs'>Cantidad</span>
                        </th>
                        <th className="col-xs-2">
                            <span className='glyphicon glyphicon-check'></span>
                            <span className='hidden-xs'>Subtotal</span>
                        </th>
                    </tr>
                </thead>
                <tbody>{items}</tbody>
                </table>
            </div>
        </div>

            <div className='col-xs-12 col-sm-2 col-md-2 pull-right cart-shopping-total'>
                <table className='table table-bordered'>
                    <thead>
                        <tr> 
                            <th><span className='cart-grand-total'>Total</span></th>
                            <td><span className='cart-grand-total'>${total}</span></td>
                        </tr>
                    </thead>
                </table>
            </div>

        </div>);
    }
}

export default Cart;
