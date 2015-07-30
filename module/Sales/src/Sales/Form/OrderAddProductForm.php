<?php

namespace Sales\Form;

/**
 * Description of CustomerForm
 *
 * @author Pedro
 */
use Zend\Form\Form;

class OrderAddProductForm extends Form
{

    public function __construct($name = NULL)
    {
         parent::__construct($name);

        $this->setAttribute('action', 'admin/order/addProduct');
        $this->setAttribute('method', 'post');


        $this->add(array(
            'name' => 'order_id',
            'type' => 'hidden',
            'attributes' => array(     
                'id' => 'order_id',
                'value' =>0
            ),
        ));
        $this->add(array(
            'name' => 'customer_id',
            'type' => 'hidden',
            'attributes' => array(     
                'id' => 'order_id',
                'value' =>0
            ),
        ));

         $this->add(array(
            'name' => 'product_id',
            'type' => 'select',
             'options' => array(
                'disable_inarray_validator' => true,
            ),
            'attributes' => array(
                'id' => 'multiselect',
                'class' => 'form-control gui-input',
                'style' => 'width: 100%',     
                'required' => true,
                
            ),
           
        ));
          $this->add(array(
            'name' => 'quantity',
            'attributes' => array(
                'type' => 'text',
                'id' => 'quantity',
                'value' =>1,
                'class' => 'form-control gui-input',
                'placeholder' => 'quantity',
                'required' => true,       
            ),
        ));
    }

    //put your code here
}
