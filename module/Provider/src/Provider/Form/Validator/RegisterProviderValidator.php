<?php

/**
 * Description of LoginValidator
 *
 * @author Pedro
 */
namespace Provider\Form\Validator;

use Zend\Validator\StringLength;
use Zend\Validator\NotEmpty;
use Zend\Validator\Identical;
use Zend\Validator\EmailAddress;
use Zend\InputFilter\InputFilter;
use Zend\InputFilter\Input;
use Zend\I18n\Validator\Alnum;
use Zend\Validator\AbstractValidator;
use Zend\Mvc\I18n\Translator;
use Zend\Validator\File\Size;
use Zend\Validator\File\MimeType;
use Zend\Filter\File\RenameUpload;
use Zend\InputFilter\FileInput;
use Zend\Filter\File\LowerCase;
use Zend\Validator\Digits;
use Zend\I18n\Validator\Int;
use Zend\InputFilter\EmptyContextInterface;
use Zend\Form\Annotation\Required;

class RegisterProviderValidator extends InputFilter
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
    protected $opcionesAlpha2 = array(
        'allowWhiteSpace' => false,
        'messages' => array(
            'notAlpha' => "Solo numeros, letras y sin espacio "
        )
    );
    
    protected $filterGeneric = array(
                array(
                    'name' => 'StripTags'
                ),
                array(
                    'name' => 'StringTrim'
                )
            );
    

    public function __construct($sm)
    {      
      
        $this->add(array(
            'name' => 'company',
            'required' => true,
            'validators' => array(
                array(
                    'name' => 'Alnum',
                    'options' => $this->opcionesAlnum
                )
            ),
            'filters' => $this->filterGeneric
        ));
        $this->add(array(
            'name' => 'company_id',
            'required' => true,
            'validators' => array(
                array(
                    'name' => 'Alnum',
                    'options' => $this->opcionesAlnum
                )
            ),
            'filters' => $this->filterGeneric
            )
        );
        $this->add(array(
            'name' => 'firstname',
            'required' => true,
            'validators' => array(
                array(
                    'name' => 'Alnum',
                    'options' => $this->opcionesAlnum
                )
            ),
            'filters' => $this->filterGeneric
        ));
        $this->add(array(
            'name' => 'lastname',
            'required' => true,
            'validators' => array(
                array(
                    'name' => 'Alnum',
                    'options' => $this->opcionesAlnum
                )
            ),
            'filters' => $this->filterGeneric
        ));
        $this->add(array(
            'name' => 'email',
            'required' => true,
            'filters' => $this->filterGeneric,
            'validators' => array(
                array(
                    'name' => 'EmailAddress',
                    'options' => array(
                        'messages' => array(
                            'emailAddressInvalidFormat' => 'Email address format is not invalid'
                        )
                    )
                ),
                array(
                    'name' => 'NotEmpty',
                    'options' => array(
                        'messages' => array(
                            'isEmpty' => 'Email address is required'
                        )
                    )
                ),
                array(
                    'name' => 'Zend\Validator\Db\NoRecordExists',
                    'options' => array(
                        'table' => 'lk_provider',
                        'field' => 'email',
                        'adapter' => $sm->get('Zend\Db\Adapter\Adapter'),
                         'messages' => array(
                            'recordFound' => 'Email registrado'
                        )
                    ),
                ),
            )
        ));
        $this->add(array(
            'name' => 'confirmEmail',
            'required' => true,
            'filters' => $this->filterGeneric,
            'validators' => array(
                array(
                    'name' => 'EmailAddress',
                    'options' => array(
                        'messages' => array(
                            'emailAddressInvalidFormat' => 'Email address format is not invalid'
                        )
                    )
                ),
                array(
                    'name' => 'NotEmpty',
                    'options' => array(
                        'messages' => array(
                            'isEmpty' => 'Email address is required'
                        )
                    )
                ),
                array(
                    'name' => 'identical',
                    'options' => array(
                        'token' => 'email',
                        'messages' => array(
                            'notSame' => "Los email no coinciden",
                        )
                    )
                )
            )
        ));
        $this->add(array(
            'name' => 'password',
            'required' => true,
            'filters' => $this->filterGeneric,
            'validators' => array(
                array(
                    'name' => 'NotEmpty',
                    'options' => array(
                        'messages' => array(
                            'isEmpty' => 'Password is required'
                        )
                    )
                )
            )
        ));
        $this->add(array(
            'name' => 'confirmarPassword',
            'required' => true,
            'filters' => $this->filterGeneric,
            'validators' => array(
                array(
                    'name' => 'identical',
                    'options' => array(
                        'token' => 'password',
                        'messages' => array(
                            'notSame' => "Las contraseñas no coinciden",
                        )
                    )
                )
            )
        )
        );
        
        
        
     
    }
}
