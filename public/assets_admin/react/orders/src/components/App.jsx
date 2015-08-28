'use strict';
import React from 'react';
import {TabbedArea, TabPane} from 'react-bootstrap';
import Catalog from './Catalog';
import Panel from './Panel';
import Checkout from './Checkout';
import UserFilter from './UserFilter';
import OrderTable from './OrderTable';
import UserStore from '../stores/UserStore';
import KartStore from '../stores/KartStore';
import KartActions from '../actions/kart';
import UserForm from './UserForm';
import Cart from './Cart';

class App extends React.Component {

    constructor(props) {
        super(props);

        this.state = {
            key: 1,
            user: UserStore.getUser()
        };

        this.onChangeTab = (key) => {
            // Validar si puede cambiar la pestaña
            this.setState({
                key,
                user: UserStore.getUser()
            });
        }

        this.onClientLoad = (id) => {
            KartActions.setUser(id);
        };

        this.onClientSelected = (e) => {
            KartActions.confirmUser(this.state.user);
        };

        this.onOrderLoad = (e) => {
            this.setState({
                key: 3
            });
        };

        this.onShippingLoad = (e) => {
            this.setState({
                key: 4
            });
        };

        this.onConfirmOrder = (e) => {
            this.setState({
                key: 1
            });
        };

        this.onChangeUser = (e) => {

            let key = UserStore.isConfirmed() ? 2 : 1;

            this.setState({
                key,
                user: UserStore.getUser()
            });
        };

        this.onChangeKart = (e) => {
            this.setState({
                key: 2
            });
        }
    }
    
    componentWillMount() {
        UserStore.addChangeListener(this.onChangeUser);
        KartStore.addChangeListener(this.onChangeKart);
    }

    componentWillUnmount() {
        UserStore.removeChangeListener(this.onChangeUser);
        KartStore.removeChangeListener(this.onChangeKart);
    }

    render() { 

        let users  = this.props.users;
        let products = this.props.products;

        return (
    <div className='container mw1000 center-block'>
        <TabbedArea bsStyle={'pills'} activeKey={this.state.key} onSelect={this.onChangeTab}>
            <TabPane eventKey={1} tab='Cliente'>
                <Panel title='El Cliente' 
                    titleContent={<UserFilter options={users} onSelectOption={this.onClientLoad} />}
                    panelContent={<div><UserForm /><OrderTable orders={this.state.user.orders} /></div>}
                    actionLabel={'Continuar'}
                    onFinish={this.onClientSelected} />
            </TabPane>
            <TabPane eventKey={2} tab='Pedido' disabled={!UserStore.isConfirmed()}>
                <Panel title='Productos'
                    titleContent={<Catalog products={products} />}
                    panelContent={<Cart  />}
                    actionLabel={'Confirmar Pedido'}
                    onFinish={this.onOrderLoad} />
            </TabPane>
            <TabPane eventKey={3} tab='Shipping' disabled >
                <Panel title='Productos'
                    titleContent={'Select Shipping'}
                    panelContent={'Las Direcciones'}
                    actionLabel={'Confirmar Pedido'}
                    onFinish={this.onShippingLoad}  />
            </TabPane>
            <TabPane eventKey={4} tab='Checkout' disabled >
                <Panel title='Resumen de Compra'
                    titleContent={'Titulo de Compra'}
                    panelContent={'El resumen'}
                    actionLabel={'Confirmar Compra'}
                    onFinish={this.onConfirmOrder}  />
            </TabPane>
        </TabbedArea>
    </div>);
    }
}

export default App;
