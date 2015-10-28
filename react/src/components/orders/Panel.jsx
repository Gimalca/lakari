'use strict';
import React from 'react';

class Panel extends React.Component {

    constructor(props) {
        super(props);
    }

    render() {

        return (
        <div className="panel mb25 mt5"> 
            <div className="col-xs-12 col-md-12 col-sm-12 panel-heading">
                <span className="col-md-2 col-sm-2 panel-title hidden-xs">{this.props.title}</span>
                <div className="pull-right col-xs-12 col-md-10 col-sm-10 title-content">
                    {this.props.titleContent}
                </div>
            </div>
            <div className="panel-body p20 pb10 form-horizontal">
                <div className="tab-content"> 
                <div className="tab-pane active"> 
                    {this.props.panelContent}
                </div>
            </div>
            </div>
            <div className="panel-footer text-right">
                <button onClick={this.props.onFinish} className="btn btn-primary text-right">{this.props.actionLabel}
                </button>
            </div>
        </div>);
    }
}

export default Panel;
