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
            'name' => 'productId',
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
       
      
       $this->add(array(
           'name' => 'productImage',
           'attributes' => array(
               'type' => 'file',
               'id' => 'fileupload',
               
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
       $this->add(array(
            'name' => 'productQuantity',
            'attributes' => array(
                'type' => 'text',
                'id' => 'productQuantity',
                'maxlength' => 6,
                'class' => 'form-control gui-input',
                'placeholder' => 'Product quantity in stock',
                'required' => false,
                      
            ),
        ));
       $this->add(array(
            'name' => 'productMinimun',
            'attributes' => array(
                'type' => 'text',
                'id' => 'productMinimun',
                'maxlength' => 6,
                'class' => 'form-control gui-input',
                'placeholder' => 'minimum shop',
                'required' => false,
                      
            ),
        ));
       
       $this->add(array(
            'name' => 'productStock',
            'type' => 'select',
            'attributes' => array(
                'id' => 'productStock',
                'class' => 'form-control gui-input',
                'required' => true,
              
            ),
            'options' => array(
                'empty_option' => 'Please choose',
                'value_options' => array(                    
                    '1' => 'Panama',
                    '2' => 'Colombia',
                    '3' => 'Venezuela',
                    '4' => 'Miami',
                )
            )
        ));
       
       $this->add(array(
           'name' => 'productStockStatus',
           'type' => 'select',
           'attributes' => array(
               'id' => 'productStockStatus',
               'class' => 'form-control gui-input',
               'required' => true,
       
           ),
           'options' => array(
               'empty_option' => 'Please choose',
               'value_options' => array(
                   '1' => 'Available',
                   '2' => 'Unavailable',
                   '3' => 'Discontinued',
                   '4' => 'Out of Stock',
               )
           )
       ));
       
       $this->add(array(
            'name' => 'productStore',
            'type' => 'select',
            'attributes' => array(
                'id' => 'productStore',
                'class' => 'form-control gui-input',
                'required' => true,
              
            ),
            'options' => array(
                'empty_option' => 'Please choose',
                'value_options' => array(                    
                    '1' => 'Panama',
                    '2' => 'Colombia',
                    '3' => 'Venezuela',
                    '4' => 'Miami',
                )
            )
        ));
       
       
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
            'name' => 'productCategories',
            'type' => 'select',
            'attributes' => array(
                'id' => 'multiselect3',
                'class' => 'form-control gui-input',
                'style' => 'width: 100%',
                'multiple' => true,
                'required' => true,
                //'value' => 0
            ),
            'options' => array(
                
                'value_options' => array(
                    //'' => 'Please choose Product Categories',
                    'type' => array(
                        'label' => 'Tipo de Producto',
                        'options' => array(
                            '1' => 'Muebles',
                            '2' => 'Griferías',
                            '3' => 'Iluminación',
                            '4' => 'Utensilios',
                        )
                    ),
                    'ambiente' => array(
                        'label' => 'Ambiente',
                        'options' => array(
                            '5' => 'Sala',
                            '6' => 'Dormitorio',
                            '7' => 'Baño'
                        )
                    )
                )
            )
            
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

