<?php

namespace Admin\Form;

/**
 * Description of CustomerForm
 *
 * @author eluque
 */
use Zend\Form\Form;

class Category extends Form
{
    public function __construct($name = null) {
        
        parent::__construct($name);
        
        $this->setAttribute('action', 'admin/category/add');
        $this->setAttribute('method', 'post');
        
        
        $this->add(array(
            'name' => 'category_id',
            'attributes' => array(     
                'id' => 'category_id',
                'type' => 'hidden',
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
            'name' => 'parent_id',
            'attributes' => array(
                'id' => 'parent_id',
                'type' => 'hidden',
            )
        ));
        
        $this->add(array(
            'name' => 'top',
            'type' => 'Zend\Form\Element\Checkbox',
            'options' => array(
            ),
            'attributes' => array(
                'value' => 'yes'
            )
        ));
        
        $this->add(array(
            'name' => 'sort_order',
            'attributes' => array(
                'type' => 'number', 
                'id' => 'sort_order',
                'require' => 'true',
                'class' => 'gui-input',
                'min' => '1',
                'max' => '5',
                'value' => '1',
            ),
        ));
        
        $this->add(array(
            'name' => 'name',
            'attributes' => array(
                'type' => 'text',
                'id' => 'name',
                'class' => 'form-control gui-input',
                'placeholder' => 'Enter category name',
                'required' => true,              
            ),
        ));
        
        $this->add(array(
            'name' => 'description',
            'type' => 'Zend\Form\Element\Textarea',
            'attributes' => array(
                'id' => 'description',
                'class' => 'form-control',
                'placeholder' => 'Enter category description',
                'required' => true,              
            ),
        ));
        
//        $this->add(array(
//            'name' => 'column',
//            'type' => 'select',
//            'attributes' => array(
//                'id' => 'column',
//                'class' => 'form-control gui-input',
//            ),
//            'options' => array(
//                'value_options' => array(
//                    '0' => 'Arriba',
//                    '1' => 'Abajo',
//                )
//            )
//        ));
        
        $this->add(array(
            'name' => 'status',
            'type' => 'select',
            'attributes' => array(
                'id' => 'status',
                'class' => 'form-control gui-input',
            ),
            'options' => array(
        
                'value_options' => array(
                    '0' => 'Desactivo',
                    '1' => 'Activo',
                    '2' => 'Archivado',
                )
            )
        ));
    }
}