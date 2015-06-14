<?php

namespace Admin\Form;

use Zend\Form\Form;
use Zend\Form\Element;


/**
 * Description of Contacto
 *
 * @author Andres
 */
class Provider extends Form {

    public function __construct($name = null) {
        parent::__construct($name);
        
        $this->setAttribute('action', 'admin/provider/add');
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
                'id' => 'name',
                'class' => 'form-control gui-input',
                'placeholder' => 'enter company name',
                'required' => true,
                'autofocus' => true,
                
            ),
        ));     
        $this->add(array(
            'name' => 'company_id',
            'attributes' => array(
                'type' => 'text',
                'id' => 'name',
                'class' => 'form-control gui-input',
                'placeholder' => 'enter number identification',
                'required' => true,
                'autofocus' => true,
                
            ),
        ));
        $this->add(array(
            'type' => 'Zend\Form\Element\Email',
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
                'autofocus' => true,
        
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
                'autofocus' => true,
        
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
                'autofocus' => true,
        
            ),
        ));
        
        // Crear y configurar el elemento confirmarPassword:
        $this->add(array(
            'type' => 'Zend\Form\Element\Password',
            'name' => 'confirmarPassword',
            'attributes' => array(              
                'id' => 'password',
                'class' => 'form-control gui-input',
                'placeholder' => 'confirm password',
                'required' => true,
                'autofocus' => true,
        
            ),
        ));
        
        $this->add(array(
            'name' => 'status',
            'type' => 'select',
            'attributes' => array(
                'id' => 'status',
                'class' => 'form-control gui-input',
        
            ),
            'options' => array(
        
                'value_options' => array(
                    '1' => 'Activo',
                    '2' => 'Aprovacion',
                    '3' => 'Desactivo',
                    '4' => 'Archivado',
                )
            )
        ));
        
        
       
     
    }

}

