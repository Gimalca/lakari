<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
namespace Admin\Form\Validator;

use Zend\InputFilter\InputFilter;
use Zend\InputFilter\Input;
use Zend\InputFilter\FileInput;
use Zend\Filter\StringTrim;
use Zend\Filter\StripTags;
use Zend\Validator\NotEmpty;
use Zend\Validator\File\FilesSize;
use Zend\Validator\File\Size;
use Zend\Validator\File\MimeType;
use Zend\Filter\File\RenameUpload;


class CategoryValidator extends InputFilter
{
    protected $opcionesAlnum = array(
        'allowWhiteSpace' => true,
        'messages' => array(
            'notAlnum' => "El valor no es alfanumerico"
        )
    );
    
    protected $messageRequire = array(
        'message' => array(
            'notEmpty' => "Seleccion Requerida"
        )
    );


    public function __construct() 
    {
        $image = new FileInput('image');
        $image->setRequired(false)
                     ->setAllowEmpty(false);
        
        $image->getValidatorChain()
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
        $image->getValidatorChain()->attach($mimeType);

        /** Move File to Uploads/product **/
        $nameFile = sprintf("%simg_%s",'./public/assets/images/category/', time());
        $rename = new RenameUpload($nameFile);
        //$rename->setTarget($nameFile);
        $rename->setUseUploadExtension(true);
        //$rename->setUseUploadName(true);
        $rename->setRandomize(true);
        $rename->setOverwrite(true);
              
        $image->getFilterChain()->attach($rename);
        $this->add($image   );
        
//        $this->add(array(
//            'name' => 'image',
//            'validators' => array(
//                array(
//                    'name' => 'filesize',
//                    'options' => array(
//                        'max' => 2097152, // 2 MB
//                        ),
//                    ),
//                array(
//                    'name' => 'filemimetype',
//                    'options' => array(
//                        'mimeType' => 'image/png,image/x-png,image/jpg,image/jpeg,image/gif',
//                        )
//                ),
//                array(
//                    'name' => 'fileimagesize',
//                    'options' => array(
//                        'maxWidth' => 200,
//                        'maxHeight' => 200
//                        )
//                ),
//            ),
//            
//            'filters' => array(
//            // the filter below will save the uploaded file under
//            // <app-path>/data/images/photos/<tmp_name>_<random-data>
//                array(
//                    'name' => 'filerenameupload',
//                    'options' => array(
//                    // Notice: Make sure that the folder below is existing on your system
//                    //         otherwise this filter will not pass and you will get strange
//                    //         error message reporting that the required field is empty
//                        'target' => './public/assets/images/category/photos/',
//                        'randomize' => true,
//                        ),
//                 ),
//            ),
//        ));
        
        $this->add(array(
            'name' => 'name',
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

    }
}

