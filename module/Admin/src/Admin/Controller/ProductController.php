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
use Admin\Form;
use Admin\Form\ProductValidator;

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
            
            $this->productForm->setInputFilter(new ProductValidator());
            $this->productForm->setData($postData);
            
            if($this->productForm->isValid()){
                $productData = $this->productForm->getData();
                print_r($productData);die;
                
            }else {
               $messages = $this->productForm->getMessages();
               //print_r($messages);die;
            }               
            
        }
        
        
        return new ViewModel(array(
            'productForm' => $this->productForm,
        ));
    }
    
    private function getProductFormData(){
        
    }

}
