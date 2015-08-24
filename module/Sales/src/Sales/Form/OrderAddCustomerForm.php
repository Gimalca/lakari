<?php

namespace Sales\Form;

/**
 * Description of CustomerForm
 *
 * @author Pedro
 */
use Zend\Form\Form;

class OrderAddCustomerForm extends Form
{

    public function __construct($name = NULL)
    {
         parent::__construct($name);

        $this->setAttribute('action', 'admin/order/add');
        $this->setAttribute('method', 'post');


        $this->add(array(
            'name' => 'order_id',
            'type' => 'hidden',
            'attributes' => array(
                'id' => 'order_id',
                'value' => 0
            ),
        ));

         $this->add(array(
            'name' => 'customer_id',
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
            'name' => 'firstname',
            'attributes' => array(
                'type' => 'text',
                'id' => 'firstname',
                'class' => 'form-control gui-input',
                'placeholder' => 'enter first name',
                'required' => true,
            ),
        ));

        $this->add(array(
            'name' => 'lastname',
            'attributes' => array(
                'type' => 'text',
                'id' => 'lastname',
                'class' => 'form-control gui-input',
                'placeholder' => 'enter first lastname',
                'required' => true,
            ),
        ));

         $this->add(array(
            'type' => 'email',
            'name' => 'email',
            'attributes' => array(
                'id' => 'email',
                'class' => 'form-control gui-input',
                'placeholder' => 'enter email',
                'required' => true,
                'autofocus' => true,
            ),
        ));

        $this->add(array(
            'name' => 'telephone',
            'attributes' => array(
                'type' => 'text',
                'id' => 'telephone',
                'class' => 'form-control gui-input',
                'placeholder' => 'enter company name',
                'required' => true,
            ),
        ));
        $this->add(array(
            'name' => 'celphone',
            'attributes' => array(
                'type' => 'text',
                'id' => 'movil',
                'class' => 'form-control gui-input',
                'placeholder' => 'enter movil',
                'required' => true,
            ),
        ));

        $this->add(array(
            'name' => 'fax',
            'attributes' => array(
                'type' => 'text',
                'id' => 'fax',
                'class' => 'form-control gui-input',
                'placeholder' => 'enter company name',
                'required' => true,
            ),
        ));
    }

    //put your code here
}
