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
use Admin\Model\Entity\Product;
use Admin\Model\Dao\CategoryDao;
use Admin\Model\Entity\Category;
use Zend\Json\Json;
use Zend\File\Transfer\Adapter\Http as FileTransferAdapter;
use ArrayObject;
class ProductController extends AbstractActionController
{
   
    private $productTable;
    private $categoryDao;
    private $productForm;

    public function indexAction()
    {
        // return $this->forward()->dispatch('Admin\Controller\Login', array('action' => 'index'));
        return array();
    }

    public function listAction()
    {
        $productDao = $this->getProductDao();
        
          return new ViewModel(array(
            'products' => $productDao->getAll(),
          
        ));
        // This shows the :controller and :action parameters in default route
        // are working when you browse to /module-specific-root/skeleton/foo
        return array();
    }

    public function addAction()
    {
        $cat = $this->getCategorySelect();
        
        $this->productForm = new ProductForm();
        
        $this->productForm->get('productCategories')->setValueOptions($cat);
        
        if ($this->request->isPost()) {
            
           //$postData = $this->request->getPost();
           $fileData = $this->request->getFiles()->toArray();
           $postData = array_merge_recursive(
               $this->request->getPost()->toArray(),
               $this->request->getFiles()->toArray()
           );
           //print_r($postData);die;
           
            $this->productForm->setInputFilter(new ProductValidator());
            $this->productForm->setData($postData);
            
            if ($this->productForm->isValid()) {
                $productData = $this->productForm->getData();
                //print_r($productData);die;         
                $productEntity = new Product();
                $productEntity->exchangeArrayForm($productData);
                var_dump($productEntity);die;
                $productDao = $this->getProductDao();
                $saved = $productDao->saveProduct($productEntity);
                
                if ($saved) {
                    
                  return $this->redirect()->toRoute('admin', array('controller' => 'product', 'action' => 'list'));
                }
                echo 'Saved';die;
                
            } else {
                $messages = $this->productForm->getMessages();
//                  echo 'error filter';
//                  print_r($messages);die;
                 $this->productForm->populateValues($postData);
            }
        }
        
        return new ViewModel(array(
            'productForm' => $this->productForm
        ));
    }
    
    public function editAction() 
    {
        $id = (int) $this->params()->fromRoute('id', 0);
        if (!$id) {
            return $this->redirect()->toRoute('admin/list'); 
        }
        
        $this->productForm = new ProductForm();
        $productDao = $this->getProductDao();
        $productData = $productDao->getProductById($id);
        
        //print_r($productData); die;
        
        $contact = new ArrayObject;
        $contact['productModel'] = '25';
        $contact['productName'] = 'Type your message here';
        //print_r($productBind); die;
        $this->productForm->bind($contact);
        //$this->productForm->setData($contact);
       
        return new ViewModel(array(
            'productForm' => $this->productForm
        ));;
      
    }
    
    public function getCategorySelect() {
        
        $categoryDao = $this->getCategoryDao();
        $results = $categoryDao->getAll();
        
        $result = array();
        foreach ($results as $cat) {
           //$result[] = $row->getArrayCopy();
           $result[$cat->category_id] = $cat->name;
        }
    
       return $result;
        
    }
    

    public function getProductDao()
    {
        if (! $this->productTable) {
            $sm = $this->getServiceLocator();
            $this->productTable = $sm->get('Admin\Model\Dao\ProductDao');
        }
        return $this->productTable;
    }
    
    public function getCategoryDao()
    {
        if (! $this->categoryDao) {
            $sm = $this->getServiceLocator();       
            $tableGateway = $sm->get('CategoryTableGateway');
            $this->categoryDao = new CategoryDao($tableGateway);                
        }
        return $this->categoryDao;
    }
}
