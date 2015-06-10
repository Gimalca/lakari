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

class UsuarioValidator extends InputFilter
{

    public function __construct()
    {

        $this->add(array(
            'name' => 'usuarioNombre',
            'require' => false,
            'validators' => array(
                array(
                    'name' => 'Alnum',
                    'options' => array(
                        'allowWhiteSpace' => false,
                    )
                ),
            ),
        ));

        $this->add(array(
            'name' => 'usuarioApellido',
            'require' => false,
            'validators' => array(
                array(
                    'name' => 'Alnum',
                    'options' => array(
                        'allowWhiteSpace' => false,
                    )
                ),
            ),
        ));
        
        $this->add(array(
            'name' => 'usuarioEmail',
            'require' => true,
            'validators' => array(
                array(
                    'name' => 'EmailAddress',
                    'options' => array(
                        'domain' => false
                    )
                ),
            ),
        ));

        $this->add(array(
            'name' => 'usuarioPassword',
            'require' => true,
            'validators' => array(
                array(
                    'name' => 'StringLength',
                    'options' => array(
                        'min' => 4,
                        'max' => 8,
                        'messages' => array(
                            StringLength::TOO_SHORT => "El campo debe tener tener al menos 4 caracteres",
                            StringLength::TOO_LONG => "El campo debe tener un máximo de 8 caracteres",
                        )
                    )
                ),
                array(
                    'name' => 'Alnum',
                    'options' => array(
                        'allowWhiteSpace' => true
                    )
                ),
            ),
        ));

        $this->add(array(
            'name' => 'usuarioPassword2',
            'require' => true,
            'validators' => array(
                array(
                    'name' => 'Identical',
                    'options' => array(
                        'token' => 'usuarioPassword'
                    )
                ),
            ),
        ));
        
    }

    //put your code here
}
