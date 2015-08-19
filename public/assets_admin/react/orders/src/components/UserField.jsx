'use strict';
import React from 'react';

class UserField extends React.Component {
    render() {
        return (
            <div className="col-xs-12 col-sm-4 col-md-4"> 
                <label className="col-xs-3 col-sm-3 col-md-3 control-label">{this.props.label}
                    <span className="text-danger">*</span>
                </label>
                <div className="col-xs-9 col-sm-9 col-md-9">
                    <label className="field prepend-icon">
                        <input readOnly type="text" className="form-control gui-input" value={this.props.val}/>
                        <label className="field-icon">
                            <i className="fa fa-user"/>
                        </label>
                    </label>
                    <div className="help-block"> </div>
                </div>
            </div>
        );
    }
}

export default UserField;
