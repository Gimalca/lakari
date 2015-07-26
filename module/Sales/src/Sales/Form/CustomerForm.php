<?php

namespace Sales\Form;

/**
 * Description of CustomerForm
 *
 * @author Pedro
 */
use Zend\Form\Form;

class CustomerForm extends Form
{

    public function __construct($name = NULL)
    {
         parent::__construct($name);

        $this->setAttribute('action', 'admin/customer/add');
        $this->setAttribute('method', 'post');


        $this->add(array(
            'name' => 'customer_id',
            'type' => 'hidden',
            'attributes' => array(     
                'id' => 'customer_id',
                'value' =>0
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
            'type' => 'email',
            'name' => 'confirmEmail',
            'attributes' => array(           
                'id' => 'confirmEmail',
                'class' => 'form-control gui-input',
                'placeholder' => 'enter confirm email',
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
            'name' => 'movil',
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
        
        $this->add(array(
            'type' => 'Zend\Form\Element\Password',
            'name' => 'password',
           'attributes' => array(              
                'id' => 'password',
                'class' => 'form-control gui-input',
                'placeholder' => 'enter password',
                'required' => true,
            ),
        ));
        
        // Crear y configurar el elemento confirmarPassword:
        $this->add(array(
            'type' => 'Zend\Form\Element\Password',
            'name' => 'confirmPassword',
            'attributes' => array(              
                'id' => 'confirmarPassword',
                'class' => 'form-control gui-input',
                'placeholder' => 'confirm password',
                'required' => true,           
            ),
        ));
        
//         $this->add(array(
//            'name' => 'newsletter',
//             'type' => 'checkbox',
//            'attributes' => array(       
//                'id' => 'newsletter',
//                'checked' => true,
//               
//            ),
//        ));
    }

    //put your code here
}
