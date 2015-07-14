<?php

namespace Admin\Form;

use Zend\Form\Form;
use Zend\Form\Element;
use Zend\InputFilter\InputFilter;
use Zend\Stdlib\Hydrator\ClassMethods as ClassMethodsHydrator;

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
        $this->setHydrator(new ClassMethodsHydrator(false));
        $this->setInputFilter(new InputFilter());
        
//         $this->add(array(
//             'type' => 'Admin\Form\ProductFieldset',
//             'options' => array(
//                 'use_as_base_fieldset' => false,
//             ),
//         ));   

        
        $this->add(array(
            'name' => 'productId',
            'attributes' => array(
                'type' => 'hidden',               
                'id' => 'productId',               
            ),
        ));
        $this->add(array(
            'name' => 'provider_id',
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
                'placeholder' => 'enter product name',
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
       
//        $inputImage = new Element\File();
//        $inputImage->setAttributes(array(
//                'type' => 'file',
//                'id' => 'image',
//                'required' => true, 
//            ));
      
//        $this->add(array(         
//            'type' => 'Zend\Form\Element\Collection',
//            'name' => 'productImage3',
//            'options' => array(
//                'should_create_template' => false,
//                'target_element' =>  $inputImage
//            )
//        ));
       
       $this->add(array(
           'name' => 'productImage',
           'attributes' => array(
               'type' => 'File',
               'id' => 'productImage',   
               'placeholder' => 'Product Image',
               'required' => true,
               'multiple' => true
           ),
       ));
       
       // Data Form
       $this->add(array(
            'name' => 'productModel',
            'attributes' => array(
                'type' => 'text',
                'id' => 'productModel',
                'class' => 'form-control gui-input',
                'placeholder' => 'Product Model',
                'required' => true,       
            ),
        ));
       $this->add(array(
            'name' => 'productSku',
            'attributes' => array(
                'type' => 'text',
                'id' => 'productSku',
                'class' => 'form-control gui-input',
                'placeholder' => 'Product SKU',
                'required' => false, 
                      
            ),
        ));
       $this->add(array(
            'name' => 'productIsbn',
            'attributes' => array(
                'type' => 'text',
                'id' => 'productIsbn',
                'class' => 'form-control gui-input',
                'placeholder' => 'Product ISBN',
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
                'required' => true,       
            ),
        ));
       
       $inputProductQuantity =  new Element\Text();
       $inputProductQuantity->setAttribute('class', 'form-control gui-input');
       
       $this->add(array(
           'type' => 'Zend\Form\Element\Collection',
            'name' => 'productQuantity',
           'options' => array(
               
               'should_create_template' => false,
               'target_element' =>  $inputProductQuantity
           )
          
        ));

     
       $this->add(array(
            'name' => 'productMinimum',
            'attributes' => array(
                'type' => 'text',
                'id' => 'productMinimum',
                'maxlength' => 6,
                'class' => 'form-control gui-input',
                'placeholder' => 'minimum shop',
                'required' => false,
                      
            ),
        ));
   
      
       
       
//        $this->add(array(
//             'name' => 'productStore',
//             'type' => 'select',
//             'attributes' => array(
//               'type' => 'text',
//                 'id' => 'productMinimum',
//                 'maxlength' => 6,
//                 'class' => 'form-control gui-input',
//                 'placeholder' => 'minimum shop',
//                 'required' => false,
//         )
//            )
//        );
       
       
       // Meta-Data form
       $this->add(array(
           'name' => 'productMetaTittle',
           'attributes' => array(
               'type' => 'text',
               'id' => 'productMetaTittle',
               'class' => 'form-control gui-input',
               'placeholder' => 'Meta Tag Tittle',
               'required' => true,
           ),
       ));
       $this->add(array(
           'name' => 'productSeoUrl',
           'attributes' => array(
               'type' => 'text',
               'id' => 'productSeoUrl',
               'class' => 'form-control gui-input',
               'placeholder' => 'Product-Seo-Url',
               'required' => true,

           ),
       ));
       
       $this->add(array(
           'name' => 'productTags',
           'attributes' => array(
               'type' => 'text',
               'id' => 'tagsinput',
               
               'class' => 'form-control gui-input',
               'placeholder' => 'Products Tags (Comma Separated)',
              

           ),
       ));
       
       $this->add(array(
            'name' => 'productStock',
            'type' => 'select',
            'options' => array(
                'disable_inarray_validator' => true,
                'value_options' => array(
                    '1' => 'Panama',
                    '2' => 'Colombia',
                    '3' => 'Venezuela',
                    '4' => 'Miami',
                )
            ),
            'attributes' => array(
                'id' => 'productStock',
                'class' => 'form-control gui-input',
                'style' => 'width: 100%',
               
                'required' => true,
                
            ),
           
        ));
       $this->add(array(
           'name' => 'productStockStatus',
           'type' => 'select',
           'attributes' => array(
               'id' => 'productStockStatus',
               'class' => 'form-control gui-input',
               
           ),
           'options' => array(
               'disable_inarray_validator' => true,
               'value_options' => array(
                   '1' => 'Available',
                   '2' => 'Unavailable',
                   '3' => 'Discontinued',
                   '4' => 'Out of Stock',
               )
           )
       ));
       $this->add(array(
            'name' => 'productCategories',
            'type' => 'select',
            'options' => array(
                'disable_inarray_validator' => true,
            ),
            'attributes' => array(
                'id' => 'multiselect3',
                'class' => 'form-control gui-input',
                'style' => 'width: 100%',
                'multiple' => true,
                'required' => true,
                
            ),
           
        ));
       
       $this->add(array(
           'name' => 'productMetaDescription',
           'attributes' => array(
               'type' => 'textarea',
               'id' => 'productMetaDescription',
               'class' => 'gui-textarea',
               'placeholder' => 'Meta Tag Description',
               
           ),
       ));
       $this->add(array(
           'name' => 'productMetaKeywords',
           'attributes' => array(
               'type' => 'textarea',
               'id' => 'productMetaKeywords',
               'class' => 'gui-textarea',
               'placeholder' => 'Meta Tag Keywords',
               
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

