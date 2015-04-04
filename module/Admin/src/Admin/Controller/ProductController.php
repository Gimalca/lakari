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
use Catalog\Model\Entity\Product;
use Zend\Json\Json;

class ProductController extends AbstractActionController
{

    private $productTable;

    private $productForm;

    public function indexAction()
    {
        // return $this->forward()->dispatch('Admin\Controller\Login', array('action' => 'index'));
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
        $this->productForm = new ProductForm();
        
        if ($this->getRequest()->isPost()) {
            
            $postData = $this->request->getPost();
            print_r($postData);die;
            $this->productForm->setInputFilter(new ProductValidator());
            $this->productForm->setData($postData);
            
            if ($this->productForm->isValid()) {
                $productData = $this->productForm->getData();
                //print_r($productData);die;
                $productEntity = new Product();
                //$productData['productId'] = 9;
                $productEntity->exchangeArrayForm($productData);
                // var_dump($productEntity);die;
                $productDao = $this->getProductDao();
                $saved = $productDao->saveProduct($productEntity);
                
                if ($saved) {
                  return $this->redirect()->toRoute('admin', array('controller' => 'product', 'action' => 'list'));
                }
            } else {
                $messages = $this->productForm->getMessages();
                // print_r($messages);die;
            }
        }
        
        return new ViewModel(array(
            'productForm' => $this->productForm
        ));
    }

    public function getProductDao()
    {
        if (! $this->productTable) {
            $sm = $this->getServiceLocator();
            $this->productTable = $sm->get('Catalog\Model\Dao\ProductDao');
        }
        return $this->productTable;
    }
}
