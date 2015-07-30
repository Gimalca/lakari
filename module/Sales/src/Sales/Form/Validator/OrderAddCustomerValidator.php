<?php

/**
 * Description of LoginValidator
 *
 * @author Pedro
 */

namespace Sales\Form\Validator;

use Zend\InputFilter\InputFilter;

class OrderAddCustomerValidator extends InputFilter
{


    public function __construct()
    {
        $this->add(array(
            'name' => 'order_id',
            'continue_if_empty' => true,
            'validators' => array(
                array(
                    'name' => 'Int',
                )
            ),
            'filters' => array(
                array(
                    'name' => 'StripTags'
                ),
                array(
                    'name' => 'StringTrim'
                )
            )
        ));
        $this->add(array(
            'name' => 'customer_id',
            'continue_if_empty' => true,
            'validators' => array(
                array(
                    'name' => 'Int',
                )
            ),
            'filters' => array(
                array(
                    'name' => 'StripTags'
                ),
                array(
                    'name' => 'StringTrim'
                )
            )
        ));

       
     
       
    }

}
