<?php

namespace Admin\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

use Catalog\Model\Dao\CategoryDao;
use Catalog\Model\Entity\Category;
use Catalog\Model\Entity\CategoryDescription;

use Admin\Form\Validator;
use Admin\Form\Validator\CategoryValidator;

use Admin\Form\Category as CategoryForm;

class CategoryController extends AbstractActionController {

    public function indexAction() {
        return new ViewModel();
    }

    public function listAction()
    {
        $categoryTableGateway = $this->getService('CategoryTableGateway');
        
        $categoryDao = new CategoryDao($categoryTableGateway);
        $categories =  $categoryDao->getAll();
         
        $categoryForm = New CategoryForm();
         
        $add = $this->params()->fromRoute('add', false);
         
        return new ViewModel(array(
            'category' => $categories,
            'categoryForm' => $categoryForm,
            'add' => $add
        ));
    }
    
    public function addAction()
    {
        $request = $this->getRequest();

        if ($request->isPost()) {
            
            $postData= array_merge_recursive(
                    $request->getPost()->toArray(),
                    $request->getFiles()->toArray()
            );
            $categoryForm = New CategoryForm;
            $categoryForm->setInputFilter(new CategoryValidator());
            //print_r($postData); die;
            $categoryForm->setData($postData);
            
            if ($categoryForm->isValid()) {
                $categoryData = $categoryForm->getData();
                //print_r($categoryData); die;
                $categoryPrepareData = $this->prepareCategoryData($categoryData);
                
                $categoryEntity = new Category();
                $categoryEntity->exchangeArray($categoryPrepareData);
                
                $categoryDescriptionEntity = new CategoryDescription();
                $categoryDescriptionEntity->exchangeArray($categoryPrepareData);
               
                $categoryTableGateway = $this->getService('CategoryTableGateway');
                $categoryDao = new CategoryDao($categoryTableGateway);
                //print_r($categoryDao);die;
               
                $saved = $categoryDao->saveCategory($categoryEntity, $categoryDescriptionEntity);

                if ($saved) {
                    //echo "Guardado!";
                    return $this->forward()->dispatch('Admin\Controller\Category', array(
                                'action' => 'list',
                                'add' => 1,
                    ));
                } else {
                    throw new \Exception("Not Save Row");
               }
            } else {
                $messages = $categoryForm->getMessages();
                //print_r($messages);die;               
                $categoryForm->populateValues($postData);
                //Set View
                return $this->forward()->dispatch('Admin\Controller\Category', array(
                                'action' => 'list',                             
                                'form' => $categoryForm
                    ));
            }
        }

        return $this->redirect()->toRoute('admin', array('controller' => 'category', 'action' => 'list'));
    }
//    }
   
    

    private function prepareCategoryData($categoryData)
    {
        //print_r($categoryData);die;
        if ($categoryData['image']['tmp_name'] != '') {
            $explo = explode('img_', $categoryData['image']['tmp_name']);
            $img = 'img_' . $explo[1];
        }else{
            $img = 'img_';
        }
        
        $categoryData['image'] = ($img== "img_") ?  'no-logo.jpg' : $img;        
        $categoryData['column'] = 0; 
        $categoryData['parent_id'] = 0;
        //$categoryData['top'] = 1;
        $categoryData['date_added'] = date("Y-m-d H:i:s");
        $categoryData['date_modified'] = date("Y-m-d H:i:s");    
        $categoryData['language_id'] = 1;
        $categoryData['meta_description'] = 'pruebaaa';
        $categoryData['meta_keyword'] = 'pruebbaaa';
        
        return $categoryData;
    }
    
    public function getService($serviceName)
    {
        $sm = $this->getServiceLocator();
        $service = $sm->get($serviceName);
        
        return $service;
    }
}
