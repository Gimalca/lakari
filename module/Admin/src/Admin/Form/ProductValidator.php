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
        'allowWhiteSpace' => false,
        'messages' => array(
            'notAlnum' => "El valor no es alfanúmerico",
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
                    'options' => $this->opcionesAlnum,
                ),
            ),
                )
        );
        
        $this->add(array(
            'name' => 'productName',
            'required' => true,
            'validators' => array(
                array(
                    'name' => 'Alnum',
                    'options' => $this->opcionesAlnum,
                ),
            ),
                )
        );
    }

}
