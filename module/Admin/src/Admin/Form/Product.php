<?php

namespace Admin\Form;

use Zend\Form\Form;
use Zend\Form\Element;


/**
 * Description of Contacto
 *
 * @author Andres
 */
class Product extends Form {

    public function __construct($name = null) {
        parent::__construct($name);
        
        $this->setAttribute('action', 'admin/product/add');
        $this->setAttribute('method', 'post');

        $this->add(array(
            'name' => 'id',
            'attributes' => array(
                'type' => 'hidden',
            ),
        ));

       $this->add(array(
            'name' => 'productName',
            'attributes' => array(
                'type' => 'text',
                'id' => 'productName',
                'class' => 'form-control gui-input',
                'placeholder' => 'Name new product',
                'required' => true,
                'autofocus' => true,
                
            ),
        ));
       $this->add(array(
            'name' => 'productDescription',
            'attributes' => array(
                'type' => 'textarea',
                'id' => 'productDescription',
                'class' => 'form-control gui-textarea',
                'placeholder' => 'Product Description',
                'required' => true,       
            ),
        ));
       $this->add(array(
            'name' => 'productModel',
            'attributes' => array(
                'type' => 'text',
                'id' => 'productModel',
                'class' => 'form-control gui-input',
                'placeholder' => 'Product Model',
                'required' => false,       
            ),
        ));
       
       $this->add(array(
            'name' => 'productPrice',
            'attributes' => array(
                'type' => 'text',
                'id' => 'productPrice',
                'class' => 'form-control gui-input',
                'placeholder' => 'Product Price',
                'required' => false,       
            ),
        ));
      
        $this->add(array(
            'name' => 'send',
            'attributes' => array(
                'type' => 'submit',
                'value' => 'Crear',
            ),
        ));
    }

}

