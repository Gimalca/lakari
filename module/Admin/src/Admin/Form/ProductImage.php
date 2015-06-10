<?php

/**
 * Description of Login
 *
 * @author Pedro
 */

namespace Admin\Form;

use Zend\Form\Form;
use Zend\Form\Element;


class ProductImage extends Form
{

    public function __construct($name = NULL)
    {
 
        parent::__construct($name);
        
      $this->add(array(
           'name' => 'productImage',
           'attributes' => array(
               'type' => 'File',  
               'multiple' => true
           ),
       ));
    }

}
