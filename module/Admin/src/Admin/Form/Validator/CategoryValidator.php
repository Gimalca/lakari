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
        
      /*  $this->add(array(
            'name' => 'image',
            'validators' => array(
                array(
                    'name' => 'filesize',
                    'options' => array(
                        'max' => 2097152, // 2 MB
                        ),
                    ),
                array(
                    'name' => 'filemimetype',
                    'options' => array(
                        'mimeType' => 'image/png,image/x-png,image/jpg,image/jpeg,image/gif',
                        )
                ),
                array(
                    'name' => 'fileimagesize',
                    'options' => array(
                        'maxWidth' => 200,
                        'maxHeight' => 200
                        )
                ),
            ),
            
            'filters' => array(
            // the filter below will save the uploaded file under
            // <app-path>/data/images/photos/<tmp_name>_<random-data>
                array(
                    'name' => 'filerenameupload',
                    'options' => array(
                    // Notice: Make sure that the folder below is existing on your system
                    //         otherwise this filter will not pass and you will get strange
                    //         error message reporting that the required field is empty
                        'target' => 'data/image/photos/',
                        'randomize' => true,
                        ),
                 ),
            ),
        ));*/
        
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
        
        
        //Name
       // $name = new Input('name');
        //$name->setRequired(TRUE)
          //      ->getFilterChain()
            //        ->attach(new StringTrim())
              //      ->attach(new StringTags());
        //$name->getValidatorChain()->attach(new NotEmpty());
        //$this->add($name);
        
    }
}

