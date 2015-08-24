'use strict';
import React from 'react';

class UserFilter extends React.Component {

    constructor(props) {
        super(props);

        this.onSelectOption = (e) => {
            let id = e.target.value;
            this.props.onSelectOption.call(this, id);
        }
    }

    componentDidMount() {
        let filter = React.findDOMNode(this.refs.filter);
        $(filter).select2({ placeholder: "Seleccione un Cliente", allowClear: true });
        $(filter).on('change', this.onSelectOption);
    }

    render() {

        let options = this.props.options.map( (opt, i) => {
            return <option key={i} value={opt.id}>
            {opt.name} {opt.lastname} | {opt.email}
            </option>
        });

        return (<div className='col-xs-12'>
                <span style={{textAlign:'right'}} className="col-xs-2 col-sm-3">
                <span className="hidden-xs">Busqueda</span>
                <span style={{margin:'0 5px'}} className='glyphicon glyphicon-search'>
                </span>
                </span>
                <div className='col-xs-10 col-sm-9'>
                <select defaultValue='' style={{width:"100%"}} ref='filter' className='select-user form-control gui-input' onChange={this.onSelectOption} >
                    {options}
                </select>
                </div>
            </div>
        );
    }
}

export default UserFilter;
