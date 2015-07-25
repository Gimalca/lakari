<?php

namespace Provider\Form;

use Zend\Form\Form;
use Zend\Form\Element;


/**
 * Description of Contacto
 *
 * @author Pedro
 */
class Provider extends Form {

    public function __construct($name = null) {
        parent::__construct($name);
        
        $this->setAttribute('action', 'admin/provider/list');
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
                'id' => 'company_id',
                'class' => 'form-control gui-input',
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
                'class' => 'form-control gui-input',
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
                'id' => 'confirmarPassword',
                'class' => 'form-control gui-input',
                'placeholder' => 'confirm password',
                'required' => true,
                'autofocus' => true,
        
            ),
        ));
        
        $this->add(array(
            'name' => 'logo',
            'attributes' => array(
                'type' => 'File',
                'id' => 'logo',
                'placeholder' => 'Logo',               
               
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
                    '2' => 'Sin Aprobar',
                    '3' => 'Desactivo',
                    '4' => 'Archivado',
                )
            )
        ));
        
        $this->add(array(
            'name' => 'categories',
            'type' => 'select',
            'options' => array(
                'disable_inarray_validator' => true,
                'value_options' => array(
                    '0' => 'Todas'
                )
            ),
            'attributes' => array(
                'id' => 'categories',
                'class' => 'form-control gui-input',
                'style' => 'width: 100%',
                'multiple' => true,
                'required' => true
            )
        )
        );
        
        $this->add(array(
            'name' => 'provider_group_id',
            'type' => 'select',
            'attributes' => array(
                'id' => 'grupo',
                'class' => 'form-control gui-input',
        
            ),
            'options' => array(
        
                'value_options' => array(
                    '1' => 'Default',
                   
                )
            )
        ));
        
        $this->add(array(
            'name' => 'store_id',
            'type' => 'select',
            'options' => array(
                'disable_inarray_validator' => true,
                'value_options' => array(
                   '1' => 'Panama',
                   '2' => 'Colombia',
                   '3' => 'Venezuela',
                   '4' => 'Usa',
               )
            ),
            'attributes' => array(
                'id' => 'stock',
                'class' => 'form-control gui-input',
                'style' => 'width: 100%',
                'multiple' => true,
                'required' => true
            )
        )
        );
        
        $this->add(array(
            'name' => 'csrf',
            'type' => 'Zend\Form\Element\Csrf',
        ));
        
       
     
    }

}

