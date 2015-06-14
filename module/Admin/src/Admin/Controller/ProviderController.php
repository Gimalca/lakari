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


class ProviderController extends AbstractActionController
{

   

    public function indexAction()
    {
        return $this->forward()->dispatch('Admin\Controller\Provider', array('action' => 'list'));
    }
    
    public function listAction()
    {
        $providerForm = New ProviderForm();
        //print_r($providerForm);die;
        
        $view['providerForm'] = $providerForm; 
        
        return new ViewModel($view );    
       
    }

    
}
