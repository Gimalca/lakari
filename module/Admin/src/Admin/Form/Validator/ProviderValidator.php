<?php

/**
 * Description of LoginValidator
 *
 * @author Pedro
 */
namespace Admin\Form\Validator;

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

class ProviderValidator extends InputFilter
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
    

    public function __construct()
    {      
        $logo = new FileInput('logo');
        $logo->setRequired(false)
                     ->setAllowEmpty(false);
        
        $logo->getValidatorChain()
            ->attach(new Size(array(
            'messageTemplates' => array(
                
                Size::TOO_BIG => 'The file TOO_BIG',
                Size::TOO_SMALL => 'The file TOO_SMALL',
                Size::NOT_FOUND => 'The NOT_FOUND',
                NotEmpty::IS_EMPTY => 'Mail no debe ser vacía.',
            ),
            'options' => array(
                'max' => 40000
                
            )
        )));
        
        // Validator File Type //
        $mimeType = new MimeType();
        $mimeType->setMimeType(array('image/gif', 'image/jpg','image/jpeg','image/png'));
        $logo->getValidatorChain()->attach($mimeType);

        /** Move File to Uploads/product **/
        $nameFile = sprintf("%simg_%s",'./public/assets/images/providers/', time());
        $rename = new RenameUpload($nameFile);
        //$rename->setTarget($nameFile);
        $rename->setUseUploadExtension(true);
        //$rename->setUseUploadName(true);
        $rename->setRandomize(true);
        $rename->setOverwrite(true);
              
        $logo->getFilterChain()->attach($rename);
        $this->add($logo);
        
        $this->add(array(
            'name' => 'company',
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
            'name' => 'company_id',
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
            'name' => 'email',
            'required' => true,
            'filters' => array(
                array(
                    'name' => 'StripTags'
                ),
                array(
                    'name' => 'StringTrim'
                )
            ),
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
                )
            )
        ));
        $this->add(array(
            'name' => 'password',
            'required' => true,
            'filters' => array(
                array(
                    'name' => 'StripTags'
                ),
                array(
                    'name' => 'StringTrim'
                )
            ),
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
            'filters' => array(
                array(
                    'name' => 'StripTags'
                ),
                array(
                    'name' => 'StringTrim'
                )
            ),
            'validators' => array(
                array(
                    'name' => 'identical',
                    'options' => array(
                        'token' => 'password'
                    )
                )
            )
        )
        );
        
        
        
     
    }
}
