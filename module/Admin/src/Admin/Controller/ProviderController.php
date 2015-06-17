<?php

/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/Admin for the canonical source repository
 * @copyright Copyright (c) 2005-2015 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Admin\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Admin\Form\Provider as ProviderForm;
use Admin\Model\Dao\CategoryDao;
use Admin\Form\Validator\ProviderValidator;
use Admin\Model\Entity\Provider;


class ProviderController extends AbstractActionController
{

   

    public function indexAction()
    {
        return $this->forward()->dispatch('Admin\Controller\Provider', array('action' => 'list'));
    }
    
    public function listAction()
    {
        $request = $this->getRequest();
        
        $providerDao = $this->getServiceDao('Model\Dao\ProviderDao');
        
        if ($request->isPost()) {
        
            $postData = array_merge_recursive(
                $request->getPost()->toArray(),
                $request->getFiles()->toArray()
            );
            //print_r($postData);die;
            $providerForm = New ProviderForm();
            $providerForm->setInputFilter(New ProviderValidator());
            $providerForm->setData($postData);
        
            if ($providerForm->isValid()) {
        
                $providerData = $providerForm->getData();
                //print_r($providerData);die;
                $providerEntity = New Provider();
                $providerEntity->exchangeArray($providerData);
        
                
                $saved = $providerDao->saveProvider($providerEntity->getArrayCopy());
        
                if ($saved) {
                    $view['save'] = 1;
                    return $this->redirect()->toRoute('admin', array('controller' => 'provider', 'action' => 'list'));
                }else {
                    throw new \Exception("Not Save Row");
                }
        
            }else {
                $messages = $providerForm->getMessages();
                //print_r($messages);die;
                $providerForm->populateValues($postData);
            }
        }
        
        
        
        $cat = $this->getCategorySelect();
        $cat[0] = 'Todas';
        $providerForm = New ProviderForm();
        $providerForm->get('categories')->setValueOptions($cat);
        $providerForm->get('categories')->setValue(0);
        
        $view['providers'] = $providerDao->getAll();
        //print_r($provider);die;
        $view['providerForm'] = $providerForm; 
        
        return new ViewModel($view );    
       
    }   
    
    public function getCategorySelect() {
    
        $tableGateway = $this->getServiceDao('CategoryTableGateway');
        $categoryDao = new CategoryDao($tableGateway);
        $results = $categoryDao->getAll();
        
        $result = array();
        foreach ($results as $cat) {
            //$result[] = $row->getArrayCopy();
            $result[$cat->category_id] = $cat->name;
        }
    
        return $result;
    
    }    

    public function getServiceDao($service)
    {
       
            $sm = $this->getServiceLocator();
            $tableGateway = $sm->get($service);
      
        return $tableGateway;
    }

    
}
