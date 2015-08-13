<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
namespace Admin\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Catalog\Model\Dao\InformationPageDao;

class InformationPageController extends AbstractActionController
{
     public function indexAction() {
        
         return new ViewModel();
    }
    
    public function listAction()
    {
        $informationPageTableGateway = $this->getService('InformationPageTableGateway');
        
        $informationPageDao = new InformationPageDao($informationPageTableGateway);
        $pages = $informationPageDao->getAll();
        
        return new ViewModel(array(
            'page' => $pages,
        ));
        
    }      
    
    public function getService($serviceName)
    {
       
            $sm = $this->getServiceLocator();
            $service = $sm->get($serviceName);
      
        return $service;
    }
}
