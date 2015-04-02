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
use Admin\Form\Product as ProductForm;

class ProductController extends AbstractActionController
{
    private $productForm;
    

    public function indexAction()
    {
        //return $this->forward()->dispatch('Admin\Controller\Login', array('action' => 'index'));
        return array();
    }

    public function listAction()
    {
        // This shows the :controller and :action parameters in default route
        // are working when you browse to /module-specific-root/skeleton/foo
        return array();
    }
    public function addAction()
    {
        $this->productForm = new ProductForm;
        
        if ($this->getRequest()->isPost()) {
            
            $postData = $this->request->getPost();
            
        }
        
        
        return new ViewModel(array(
            'productForm' => $this->productForm,
        ));
    }

}
