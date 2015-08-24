<?php

namespace Admin\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

use Catalog\Model\Dao\CategoryDao;
use Catalog\Model\Entity\Category;

use Admin\Form\Validator;
//use Admin\Model\Entity\Category;
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
         
        return new ViewModel(array(
            'category' => $categories,
            'categoryForm' => $categoryForm,
        ));
    }
    
    public function addAction()
    {
        $request = $this->getRequest();

        if ($request->isPost()) {
            $postData = $request->getPost();
            $categoryForm = New CategoryForm;
            $categoryForm->setInputFilter(new CategoryValidator());
            // print_r($postData); die;
            $categoryForm->setData($postData);
            //var_dump($categoryForm); die;
            
            if ($categoryForm->isValid()) {
                $categoryData = $categoryForm->getData();
                $categoryPrepareData = $this->prepareCategoryData($categoryData);
                

                $categoryEntity = new Category();
                $categoryEntity->exchangeArray($categoryPrepareData);
                $categoryDataArray = $categoryEntity->getArrayCopy();
                //var_dump($categoryDataArray);die;
                $categoryTableGateway = $this->getService('CategoryTableGateway');
                $categoryDao = new CategoryDao($categoryTableGateway);
                //print_r($categoryDao);die;
               
                $saved = $categoryDao->saveCategory($categoryDataArray);

                if ($saved) {
                    //echo "Guardo";
                    return $this->forward()->dispatch('Admin\Controller\Category', array(
                                'action' => 'list',
                                'add' => 1,
                    ));
                } else {
                    throw new \Exception("Not Save Row");
               }
            } else {
                $messages = $categoryForm->getMessages();
                print_r($messages);die;               
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
   
   
    

    private function prepareCategoryData($categoryData)
    {
        $categoryData['column'] = null; 
        $categoryData['parent_id'] = null;
        //$categoryData['top'] = 1;
        $categoryData['date_added'] = date("Y-m-d H:i:s");
        
        return $categoryData;
    }
    
    public function getService($serviceName)
    {
        $sm = $this->getServiceLocator();
        $service = $sm->get($serviceName);
        
        return $service;
    }
}
