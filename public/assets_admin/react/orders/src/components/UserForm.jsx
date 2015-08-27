'use strict';
import React from 'react';
import UserField from './UserField';
import UserStore from '../stores/UserStore';
import KartActions from '../actions/kart';

class UserForm extends React.Component {

    constructor(props) {
        super(props);

        this.state = {
            user: UserStore.getUser()
        };

        this.onChange = () => {
            this.setState({
                user: UserStore.getUser()
            });
        }

        this.onEdit = (prop, value) => {
            KartActions.editUser(prop, value);
        }
    }

    componentWillMount() {
        UserStore.addChangeListener(this.onChange);
    }

    render() {
        let user = this.state.user;

        return (<div className="admin-form user-form col-sm-12 col-md-12">
                <div className="section row form-group">
                    <UserField 
                        onEdit={this.onEdit} 
                        attr={'firstname'} 
                        icon={'fa-user'}
                        val={user.firstname} 
                        label={'Nombre'} />
                    <UserField 
                        onEdit={this.onEdit} 
                        attr={'lastname'} 
                        icon={'fa-users'}
                        val={user.lastname} 
                        label={'Apellido'} />
                </div>
                <div className="section row form-group">
                    <UserField 
                        onEdit={this.onEdit} 
                        attr={'email'} 
                        icon={'fa-envelope'}
                        val={user.email} 
                        label={'Email'} />
                    <UserField 
                        onEdit={this.onEdit} 
                        attr={'telephone'} 
                        icon={'fa-phone'}
                        val={user.telephone} 
                        label={'Telefono'} />
                </div>
                <div className="section row form-group">
                    <UserField 
                        onEdit={this.onEdit} 
                        attr={'cellphone'} 
                        icon={'fa-mobile'}
                        val={user.cellphone} 
                        label={'Celular'} />
                    <UserField 
                        onEdit={this.onEdit} 
                        attr={'fax'} 
                        icon={'fa-fax'}
                        val={user.fax} 
                        label={'Fax'} />
                </div>
            </div>);
    }
}

export default UserForm;
