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

class ProductImageValidator extends InputFilter
{

    public function __construct()
    {
       // echo sprintf("%s/data/uploads/attachment.%s.txt", __DIR__ . '/../../../../..', time());die;
        $productImage = new FileInput('productImage');
        $productImage->setRequired(true)
                     ->setAllowEmpty(false);
        
        $productImage->getValidatorChain()
            ->attach(new Size(array(
            'messageTemplates' => array(
                Size::TOO_BIG => 'The file TOO_BIG',
                Size::TOO_SMALL => 'The file TOO_SMALL',
                Size::NOT_FOUND => 'The NOT_FOUND'
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
  
    }
}
