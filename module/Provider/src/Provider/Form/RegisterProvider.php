<?php

namespace Provider\Form;

use Zend\Form\Form;
use Zend\Form\Element;


/**
 * Description of Contacto
 *
 * @author PG
 */
class RegisterProvider extends Form {

    public function __construct($name = null) {
        parent::__construct($name);
        
        $this->setAttribute('action', '/provider/register');
        $this->setAttribute('method', 'post');
      
        
        $this->add(array(
            'name' => 'provider_id',
            'attributes' => array(
                'type' => 'hidden',
                'id' => 'provider_id',
            ),
        ));

        $this->add(array(
            'name' => 'company',
            'attributes' => array(
                'type' => 'text',
                'id' => 'company',
                'class' => 'form-control ',
                'placeholder' => 'enter company name',
                'required' => true,
                'autofocus' => true,
                
            ),
        ));     
        $this->add(array(
            'name' => 'company_id',
            'attributes' => array(
                'type' => 'text',
                'id' => 'company_id',
                'class' => 'form-control ',
                'placeholder' => 'enter number identification',
                'maxlength' => '15',
                'required' => true,
                'autofocus' => true,
                
            ),
        ));
        $this->add(array(
            'type' => 'Zend\Form\Element\Email',
            'name' => 'email',
            'attributes' => array(           
                'id' => 'email',
                'class' => 'form-control ',
                'placeholder' => 'enter email',
                'required' => true,
                'autofocus' => true,
                
            ),
        ));
        $this->add(array(
            'type' => 'Zend\Form\Element\Email',
            'name' => 'confirmEmail',
            'attributes' => array(           
                'id' => 'confirmEmail',
                'class' => 'form-control ',
                'placeholder' => 'enter confirm email',
                'required' => true,
               
                
            ),
        ));
        
        $this->add(array(
            'name' => 'firstname',
            'attributes' => array(
                'type' => 'text',
                'id' => 'firstname',
                'class' => 'form-control ',
                'placeholder' => 'enter firstname',
                'required' => true,
               
        
            ),
        ));
        $this->add(array(
            'name' => 'lastname',
            'attributes' => array(
                'type' => 'text',
                'id' => 'lastname',
                'class' => 'form-control ',
                'placeholder' => 'enter lastname',
                'required' => true,
               
        
            ),
        ));
        $this->add(array(
            'name' => 'telephone',
            'attributes' => array(
                'type' => 'text',
                'id' => 'telephone',
                'class' => 'form-control ',
                'placeholder' => 'enter phone',
                'required' => true,               
        
            ),
        ));
        
        $this->add(array(
            'name' => 'celphone',
            'attributes' => array(
                'type' => 'text',
                'id' => 'mobile',
                'class' => 'form-control ',
                'placeholder' => 'enter celphone',      

            ),
        ));
        $this->add(array(
            'name' => 'fax',
            'attributes' => array(
                'type' => 'text',
                'id' => 'fax',
                'class' => 'form-control ',
                'placeholder' => 'enter company name',
 
            ),
        ));
        
        $this->add(array(
            'type' => 'Zend\Form\Element\Password',
            'name' => 'password',
           'attributes' => array(              
                'id' => 'password',
                'class' => 'form-control ',
                'placeholder' => 'enter password',
                'required' => true,
                'autofocus' => true,
        
            ),
        ));
        
        // Crear y configurar el elemento confirmarPassword:
        $this->add(array(
            'type' => 'Zend\Form\Element\Password',
            'name' => 'confirmarPassword',
            'attributes' => array(              
                'id' => 'confirmarPassword',
                'class' => 'form-control ',
                'placeholder' => 'confirm password',
                'required' => true,
                'autofocus' => true,
        
            ),
        ));    
        
        $this->add(array(
            'name' => 'csrf',
            'type' => 'Zend\Form\Element\Csrf',
        ));
        
       
     
    }

}

