<?php

/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonModule for the canonical source repository
 * @copyright Copyright (c) 2005-2015 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Provider\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Provider\Form\RegisterProvider;
use Provider\Form\Validator\RegisterProviderValidator;
use Admin\Model\Entity\Provider;

class IndexController extends AbstractActionController
{

    public function indexAction()
    {
      
        return new ViewModel();
    }
    public function registerAction()
    {
        $request = $this->getRequest();
        
        $registerForm = New RegisterProvider();
        
        if ($request->isPost()) {
            $postData = $request->getPost();
            
            $registerForm->setInputFilter(new RegisterProviderValidator());
            $registerForm->setData($postData);
            
            if ($registerForm->isValid()) {
                $providerData = $registerForm->getData();
                $providerEntity = New Provider();
                $providerEntity->exchangeArray($providerData);
                $providerData = $providerEntity->getArrayCopy();
                $providerData['status'] = 3;
                $providerData['categories'] = '0';
                
                $providerDao = $this->getServiceDao('Model\Dao\ProviderDao');
                $saved = $providerDao->saveProvider($providerData);
                
                if($saved){
                    echo 'registrado'; die;
                }else {
                    throw new \Exception("Not Save Row");
                }          
                
            }else {
                $messages = $registerForm->getMessages();
                //print_r($messages);die;
                $registerForm->populateValues($postData);
            }
           
            
        }
        
        
        $view['providerForm'] = $registerForm;
      
        return new ViewModel($view);
    }
    
    public function getServiceDao($service)
    {
         
        $sm = $this->getServiceLocator();
        $tableGateway = $sm->get($service);
    
        return $tableGateway;
    }

}
