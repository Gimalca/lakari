'use strict';

import React from 'react';

class Paginator extends React.Component {

    constructor(props) {
        super(props);

        this.handleClick = (number, e) => {
            e.preventDefault();
            this.props.onChange(number);
        };
    }

    render() {

        let pageLinks = this.props.items;
        let active = this.props.active;
        let url = this.props.url;

        var links = [];

        for (var i=1; i <= pageLinks; i++) { links.push(i); }

        return <div className="pagination-container">
            <ul className="list-inline list-unstyled">
               <li className="prev">
                  <a onClick={this.handleClick.bind(this, active -1)} href={"/"+ url +"?page="+ (active) || 1}>
                    <i className="fa fa-angle-left"></i>
                  </a>
               </li>
                  {links.map((number, i) => {
                    var classname = (number) == active ? 'active': '';
                    return <li key={i} className={classname}>
                        <a onClick={this.handleClick.bind(this, number)} href={"/"+ url +"?page="+ number}>{number}</a>
                    </li>
                  })}
               <li className="next">
                  <a onClick={this.handleClick.bind(this, active + 1)} href={"/" + url +"?page="+ (active)}>
                    <i className="fa fa-angle-right"></i>
                  </a>
               </li>
            </ul>
           </div>;
    }
}

export default Paginator;
