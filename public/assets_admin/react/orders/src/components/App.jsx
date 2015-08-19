'use strict';
import React from 'react';
import {TabbedArea, TabPane} from 'react-bootstrap';
import Catalog from './Catalog';
import Panel from './Panel';
import Checkout from './Checkout';
import UserFilter from './UserFilter';
import UserStore from '../stores/UserStore';
import UserForm from './UserForm';
import Cart from './Cart';

class App extends React.Component {

    constructor(props) {
        super(props);

        this.state = {
            key: 1,
            users: UserStore.getUsers(),
            user: {}
        };

        this.onChangeTab = (key) => {
            // Validar si puede cambiar la pestaña
            this.setState({
                key
            });
        }

        this.onClientLoad = (id) => {
            let user = UserStore.getById(id);
            this.setState({
                user
            });
        };
    }

    onClientSelected(user) {
        console.log(user);
    }

    render() { 

        let users = this.state.users;

        return (
    <div className='container mw1000 center-block'>
        <TabbedArea activeKey={this.state.key} onSelect={this.onChangeTab}>
            <TabPane eventKey={1} tab='Cliente'>
                <Panel title='El Cliente' 
                    titleContent={<UserFilter options={users} selected={this.state.user.id} onSelectOption={this.onClientLoad} />}
                    panelContent={<UserForm user={this.state.user} />}
                    actionLabel={'Continuar'}
                    onFinish={this.onClientSelected} />
            </TabPane>
            <TabPane eventKey={2} tab='Pedido'>
                <Panel title='Productos'
                    titleContent={<Catalog />}
                    panelContent={<Cart />}
                    actionLabel={'Confirmar Pedido'}
                    onFinish={this.onProductLoad} />
            </TabPane>
            <TabPane eventKey={3} tab='Shipping'>
                <Panel title='Productos'
                    titleContent={'Select Shipping'}
                    panelContent={'Las Direcciones'}
                    actionLabel={'Confirmar Pedido'}
                    onFinish={this.onProductLoad} />
            </TabPane>
            <TabPane eventKey={4} tab='Checkout'>
                <Panel title='Resumen de Compra'
                    titleContent={'Titulo de Compra'}
                    panelContent={'El resumen'}
                    actionLabel={'Confirmar Compra'}
                    onFinish={this.onProductLoad} />
            </TabPane>
        </TabbedArea>
    </div>);
    }
}

export default App;
