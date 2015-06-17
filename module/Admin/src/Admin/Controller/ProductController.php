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
use Admin\Form\Validator\ProductValidator;
use Admin\Form\Validator\ProductImageValidator;
use Admin\Model\Entity\Product;
use Admin\Model\Dao\CategoryDao;
use Admin\Model\Entity\Category;
use Admin\Model\Entity\ProductImage;
use Zend\Json\Json;
use Zend\File\Transfer\Adapter\Http as FileTransferAdapter;
use ArrayObject;
use Admin\Form\ProductImage as ProductImageForm;
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
           // print_r($postData);die;
           
            $this->productForm->setInputFilter(new ProductValidator());
            $this->productForm->setData($postData);
            
            if ($this->productForm->isValid()) {
                $productData = $this->productForm->getData();
                //print_r($productData);die;         
                $productEntity = new Product();
                $productEntity->exchangeArrayForm($productData);
                //var_dump($productEntity);die;
                $productDao = $this->getProductDao();
                $saved = $productDao->saveProduct($productEntity);
                
                if ($saved) {
                    
                  return $this->redirect()->toRoute('admin', array('controller' => 'product', 'action' => 'list'));
                }
               
                
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
        $request = $this->getRequest();
        $response = $this->getResponse();
        
        $this->productForm = new ProductForm();
        $this->productForm->setAttribute('action', '/admin/product/edit');
        
        $id = (int) $this->params()->fromRoute('id', 0);
        
        if ( $request->isPost()) {
            
            $postData = array_merge_recursive(
               $this->request->getPost()->toArray(),
               $this->request->getFiles()->toArray()
           );
            //print_r($postData); die;
            $this->productForm->setInputFilter(new ProductValidator());
            $this->productForm->setData($postData);
            
            if ($this->productForm->isValid()) {
                $productData = $this->productForm->getData();
                
                $productEntity = new Product();
                $productEntity->exchangeArrayForm($productData);
                //var_dump($productEntity);die;
                $productDao = $this->getProductDao();
                $productId = $productDao->saveProduct($productEntity);
                
                if ($productId) {
                    $view['update'] = 1;
                    $id = $productId;
                }
                
            }else {
                $messages = $this->productForm->getMessages();
                $this->productForm->populateValues($postData);
            }
            
           
        }
         
        
        
        if (!$id) {
            return $this->redirect()->toRoute('admin', array('controller' => 'product', 'action' => 'list'));
        }
        
        
        $productDao = $this->getProductDao();
        $productData = $productDao->getProductById($id);
        
       
        //print_r($productData); die;
        $cat = $this->getCategorySelect();
        $this->productForm->get('productCategories')->setValueOptions($cat);
        
        $productFormData = new ArrayObject;
        $productFormData['productId']           = $productData->getProductId();
        $productFormData['productName']         = $productData->getProductDescription()->getName();
        $productFormData['productDescription']  = $productData->getProductDescription()->getDescription();
        $productFormData['productModel']        = $productData->getModel();
        $productFormData['productSku']          = $productData->getSku();
        $productFormData['productIsbn']         = $productData->getIsbn();
        $productFormData['productPrice']        = $productData->getPrice();
        $productFormData['productMinimum']      = $productData->getMinimum();
        $productFormData['productCategories']   = $productData->getProductCategories();
        $productFormData['productMetaTittle']   = $productData->getProductDescription()->getMeta_tittle();
        $productFormData['productMetaDescription']   = $productData->getProductDescription()->getMeta_Description();
        $productFormData['productMetaKeywords']   = $productData->getProductDescription()->getMeta_Keyword();
        $productFormData['productSeoUrl']       = $productData->getUrlAlias()->keyword;
        
        $productFormData['productQuantity']       = array(50);
        $productFormData['productStock']          = array(1);
        $productFormData['productStockStatus']    = 1;
        
       
        $imageData = $productData->getProductImage();
       
           
        //print_r($imageData); die;
        //$this->productForm->bind($contact);
        $this->productForm->setData($productFormData);
        $view['productForm'] = $this->productForm;
        $view['productImage'] = $imageData;
        $view['productModel'] = $productData->getModel();
        
        return new ViewModel($view);
      
    }
    
    public function deleteAction(){
        
        $request = $this->getRequest();
        $response = $this->getResponse();
        
        $id = $request->getPost('id');
        
        $productDao = $this->getProductDao();
        $delete = $productDao->deleteProduct($id);
        
        if ($delete){
                
            if ($request->isXmlHttpRequest()){
                
                $response->setStatusCode(200);
                $response->setContent(\Zend\Json\Json::encode(array('response' => $delete)));
            }
            
        }else{
            
                $response->setStatusCode(400);
                $response->setContent(\Zend\Json\Json::encode(array('response' => $delete)));
            
            }
        
        return $response;
        
    }
    
    
    public function deleteImageAction() {
        $id = (int) $this->params()->fromRoute('id', 0);
        
        $request = $this->getRequest();
        $response = $this->getResponse();
        
        $productDao = $this->getProductDao();
        $delete = $productDao->deleteProductImage($id);
        
        if ($delete){
          $this->getResponse()->setStatusCode(200);
          $response->setContent(\Zend\Json\Json::encode(array('response' => $id)));
        }else{
            
            $this->getResponse()->setStatusCode(400);
            $response->setContent(\Zend\Json\Json::encode(array('response' => $id)));
            
        }
        
        
        
        return $response;
    }
    
    public function addImageAction() {
    
        $request = $this->getRequest();
        $response = $this->getResponse();
    
        if ( $request->isPost()) {
    
            $postData = array_merge_recursive(
                $this->request->getPost()->toArray(),
                $request->getFiles()->toArray()
            );
            //print_r($postData);die;
            $productImageForm = new ProductImageForm();
            $productImageForm->setInputFilter(new ProductImageValidator());
            $productImageForm->setData($postData);
    
            if ($productImageForm->isValid()) {
    
    
                $data = $productImageForm->getData();
                 
                $images = new \ArrayObject(); $i=0;
                foreach ($data['productImage'] as $image){
                    $explo = explode('img_', $image['tmp_name']);
                    $img = 'img_'. $explo[1];
                    $productImage = new ProductImage();
                    $productImage->image = $img;
                    $productImage->sort_order = $i++;
                    $images->append($productImage);
                }
                $productId = $postData['productId'];
                $productDao = $this->getProductDao();
                $saved = $productDao->saveProductImage($productId, $images);
                 
                if($saved){
                    $response->getHeaders()->addHeaderLine('Content-Type', 'application/json');
                    $response->setStatusCode(200);
                    //echo '{response:true,id:"74"}';die;
                    $response->setContent(\Zend\Json\Json::encode(array(
                        //'response' => true,
                        //'path' => $image['tmp_name'],
                        'id'   => $saved,
                         
                    )));
                }else {
                    $response->setStatusCode(400);
                }
                 
                 
            } else {
                $response->setStatusCode(400);
                $messages = $productImageForm->getMessages();
                $response->setContent(\Zend\Json\Json::encode($messages));
                
                 
            }
    
    
        }
    
    
    
        //         $response->setContent(\Zend\Json\Json::encode(array(
        //             'response' => true,
        //             'url' => 'img_1430604273_554549f1dca6f.jpg'
        //         )));
    
    
        return $response;
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
