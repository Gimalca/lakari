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
    protected $opcionesAlpha2 = array(
        'allowWhiteSpace' => false,
        'messages' => array(
            'notAlpha' => "Solo numeros, letras y sin espacio "
        )
    );
    

    public function __construct()
    {
       // echo sprintf("%s/data/uploads/attachment.%s.txt", __DIR__ . '/../../../../..', time());die;
        $productImage = new FileInput('productImage');
        $productImage->setRequired(false)
                     ->setAllowEmpty(false);
        
        $productImage->getValidatorChain()
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
        $productImage->getValidatorChain()->attach($mimeType);

        /** Move File to Uploads/product **/
        $nameFile = sprintf("%simg_%s",'./public/assets/images/products/catalog/', time());
        $rename = new RenameUpload($nameFile);
        //$rename->setTarget($nameFile);
        $rename->setUseUploadExtension(true);
        //$rename->setUseUploadName(true);
        $rename->setRandomize(true);
        $rename->setOverwrite(true);
              
        $productImage->getFilterChain()->attach($rename);       
        $this->add($productImage );
       
        
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
            'name' => 'productDescription',
            'required' => true,
            'validators' => array(
                array(
                   'name' => 'not_empty',      
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
        
//         $productQuantity = new Input('productQuantity');
//         $productQuantity->setAllowEmpty(true);
//         $productQuantity->getValidatorChain()
//             ->attach(new Digits());
        
//         $this->add($productQuantity);
        
        $this->add(array(
            'name' => 'productMinimun',
            'required' => false,
            'validators' => array(
                array(
                    'name' => 'Digits',     
                )
            )
        ));
        

        // Meta-Data Form
        $this->add(array(
            'name' => 'productMetaTittle',
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
            'name' => 'productSeoUrl',
            'required' => true,
            'validators' => array(
                array(
                    'name' => 'not_empty',
                )
            ),
            'filters' => array(
                array(
                    'name' => 'StripTags'
                ),
                array(
                    'name' => 'StringTrim'
                ),
                array(
                    'name' => 'StringToLower'
                ),
                
            )
        ));
        $this->add(array(
            'name' => 'productMetaDescription',
            'continue_if_empty' => true,
            
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
            'name' => 'productMetaKeywords',
            'continue_if_empty' => true,
            
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
