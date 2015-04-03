<?php

/**
 * Description of LoginValidator
 *
 * @author Pedro
 */
namespace Admin\Form;

use Zend\Validator\StringLength;
use Zend\Validator\NotEmpty;
use Zend\Validator\Identical;
use Zend\Validator\EmailAddress;
use Zend\InputFilter\InputFilter;
use Zend\InputFilter\Input;
use Zend\I18n\Validator\Alnum;
use Zend\Validator\AbstractValidator;
use Zend\Mvc\I18n\Translator;

class ProductValidator extends InputFilter
{

    protected $opcionesAlnum = array(
        'allowWhiteSpace' => true,
        'messages' => array(
            'notAlnum' => "El valor no es alfanumerico"
        )
    );
    
    protected $opcionesAlnum2 = array(
        'allowWhiteSpace' => false,
        'messages' => array(
            'notAlnum' => "Solo numeros, letras y sin espacio "
        )
    );
    

    public function __construct()
    {
        $this->add(array(
            'name' => 'productName',
            'required' => true,
            'validators' => array(
                array(
                    'name' => 'Alnum',
                    'options' => $this->opcionesAlnum
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
            'name' => 'productModel',
            'required' => true,
            'validators' => array(
                array(
                    'name' => 'Alnum',
                    'options' => $this->opcionesAlnum2
                )
            )
        ));
        $this->add(array(
            'name' => 'productPrice',
            'required' => true,
            'validators' => array(
                array(
                    'name' => 'float',
                    'options' => array(
                        'locale' => 'en_US'
                    )
                ),
                array(
                    'name' => 'stringLength',
                    'options' => array(
                        'min' => 1,
                        'max' => 10
                    )
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
