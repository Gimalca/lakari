'use strict';
import React from 'react';

class UserField extends React.Component {

    constructor(props) {
        super(props);

        this.handleInput = (e) => {
            this.props.onEdit(this.props.attr, e.target.value);
        };
    }

    render() {
        let value = this.props.val;
        let icon = 'fa ' + this.props.icon;
        let status = this.props.disabled;

        return (
            <div className="col-xs-12 col-sm-6 col-md-6"> 
                <label className="col-xs-3 col-sm-3 col-md-3 control-label">
                {this.props.label}
                    <span className="text-danger">*</span>
                </label>
                <div className="col-xs-9 col-sm-9 col-md-9">
                    <label htmlFor={this.props.attr} className="field prepend-icon">
                        <input disabled={status} name={this.props.attr} type="text" className="form-control gui-input" value={value} onChange={this.handleInput} />
                        <label htmlFor={this.props.attr} className="field-icon">
                            <i className={icon}/>
                        </label>
                    </label>
                    <div className="help-block"></div>
                </div>
            </div>
        );
    }
}

export default UserField;
