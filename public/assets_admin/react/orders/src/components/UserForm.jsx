'use strict';
import React from 'react';
import UserField from './UserField';

class UserForm extends React.Component {

    constructor(props) {
        super(props);
    }

    render() {
        let user = this.props.user;

        return (<div className="user-form col-sm-12 col-md-12">
                <div className="section row form-group">
                    <UserField val={user.name} label={'Nombre'} />
                    <UserField val={user.lastname} label={'Apellido'} />
                    <UserField val={user.email} label={'Email'} />
                </div>
                <div className="section row form-group">
                    <UserField val={user.telephone} label={'Telefono'} />
                    <UserField val={user.cellphone} label={'Celular'} />
                    <UserField val={user.fax} label={'Fax'} />
                </div>
            </div>);
    }
}

export default UserForm;
