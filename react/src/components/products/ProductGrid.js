'use strict';

import React from 'react';
import ProductThumbnail from './ProductThumbnail';
import Paginator from '../common/Paginator';
import {actions} from '../../actions/cart';

class ProductGrid extends React.Component {
  
  constructor(props) {
    super(props);

    this.state = {
        max_items: 8,
        pageNumber: 1,
        orderBy: 0,
        search: ''
    };

    this.handleItemMaxChange = (e) => {
        let newMax = React.findDOMNode(this.refs.maxItems).value;
        this.setState({
            max_items: parseInt(newMax, 10)
        });
    };
    
    this.handlePageChange = (number) => {
        let newPage = parseInt(number, 10);
        this.setState({ 
            pageNumber: number 
        });
    };

    this.handleOrderBy = (e) => {
        this.setState({
            orderBy: e.target.value
        });
    };

    this.handleSearch = (e) => {
        
        this.setState({
            search: e.target.value
        });
    };

    this.onThumbClick = (product) => {

        if ($(window).width() < 1200) {
            console.log('small width');
            // location change to href
        } else {
            console.log('expand');
            actions.expandProduct(product);
        }
    };
  }
  
  render() {

    var page      = parseInt(this.state.pageNumber);
    let max_items = this.state.max_items;
    let offset    = (max_items * (page - 1) || 0);
   
    let currentItems = this.props.items.slice(offset, offset + max_items);
   
    let thumbs = currentItems.map((item, i) => {
          return <div className='col-sm-6 col-sm-4 col-md-3'>
              <ProductThumbnail 
                key={i} 
                product={item} 
                onSelect={this.onThumbClick} />
          </div>;
    });
    
    let pageLinks = Math.ceil(this.props.items.length / max_items);
    
    return <div className='row'> 
      <div className='row filters-container'>
        <form className="form-horizontal">
          <div className='col col-xs-6 col-sm-3 col-md-3'> 
            <div className="lbl-cnt">
               <label><span className="lbl">Mostrar por</span></label>
               <div className="fld inline">
                   <div className="dropdown dropdown-small dropdown-med dropdown-white inline">
                    <select value={this.state.orderBy} className='form-control' name='orderBY' onChange={this.handleOrderBy}>
                        <option value="0">Relevancia</option>
                        <option value="1">Menor Precio</option>
                        <option value="2">Mayor Precio</option>
                    </select>
                    </div>
                 </div>
              </div>
          </div>
          <div className="lbl-cnt form-group col-xs-6 col-sm-2 col-md-2">
            <label><span className="lbl">Filas</span></label>
            <div className='fld inline'>
              <select value={this.state.max_items} className="form-control" name='maxItems' ref='maxItems' onChange={this.handleItemMaxChange} >
                <option value="8">2</option>
                <option value="12">3</option>
                <option value="16">4</option>
              </select>
              </div>
          </div>
          <div className='col col-xs-12 col-sm-5 col-md-5 text-center'>
                <div className="input-group">
                    <input onChange={this.handleSearch} value={this.state.search} className="form-control" type="text" placeholder="Busqueda" />
                        <span className="input-group-addon">
                            <i className="fa fa-search fa-fw"></i>
                        </span>
                </div>
          </div>
          <div className="col col-xs-12 col-sm-2 col-md-2 text-right">
            <Paginator url='' items={pageLinks} active={page} onChange={this.handlePageChange} />
        </div>
        </form>
       </div>  
       <div className='row'>{thumbs}</div>
       <div className='row filters-container'> 
            <div className="col col-xs-12 col-sm-2 col-md-2 text-right">
                    <Paginator url='' 
                    items={pageLinks} 
                    active={page} 
                    onChange={this.handlePageChange} />
            </div>
       </div>
     </div>;
  }
}

export default ProductGrid;
