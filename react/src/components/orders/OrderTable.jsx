import React from 'react';
import UserStore from '../../stores/UserStore';
import {actions} from '../../actions/orders';

class OrderTable extends React.Component {

    constructor(props) {
        super(props);

        this.onChangeOrder = (e) => {
        };

        this.deleteOrder = (id, i) => {
            actions.deleteOrder(id, i);
        };

        this.editOrder = (id) => {
            actions.selectOrder(id);
        };
    }

    componentWillMount() {
    }

    render() {
        let orders = this.props.orders;

        let orderElements = orders.map(function (order, i) {

            return (<tr key={i}>
                        <td>{order.order_id}</td>
                        <td>{order.order_status_id}</td>
                        <td>{order.invoice_no }</td>
                        <td>{order.total || 0}</td>
                        <td>
                            <span onClick={this.editOrder.bind(this, order.order_id)} className='action glyphicon glyphicon-pencil' ></span>
                            <span onClick={this.deleteOrder.bind(this, order.order_id, i)} className='action fa fa-trash-o'></span>
                        </td>
                    </tr>);
        }.bind(this));

        if (this.props.orders.length > 0)
        return <div className="row"> 
            <div className="col-xs-12 text-center" >
            <h2> Ordenes Pendientes </h2>
           <table className="order-table table table-bordered">
            <tbody>
                <tr>
                    <th>N°</th>
                    <th>Status</th>
                    <th>Invoice</th>
                    <th>Total</th>
                    <th>Acciones</th>
                </tr>
                    {orderElements}
                </tbody>
           </table>
        </div>
        </div>
        else 
            return <div></div>
    }
}

export default OrderTable;
