<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Admin\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Catalog\Model\Dao\CategoryDao;
use Admin\Model\Entity\Category;

class CategoryController extends AbstractActionController {

    public function indexAction() {
        return new ViewModel();
    }

    public function listAction() {
        
        $categoryTableGateway = $this->getService('CategoryTableGateway');
        
         $categoryDao = new CategoryDao($categoryTableGateway);
         $categories =  $categoryDao->getAll();
         
        return new ViewModel(array(
            'category' => $categories,
        ));
    }
    
    public function getService($serviceName)
    {
       
            $sm = $this->getServiceLocator();
            $service = $sm->get($serviceName);
      
        return $service;
    }

   

}
