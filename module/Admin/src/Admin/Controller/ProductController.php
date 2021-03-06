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
use Catalog\Model\Dao\ProductDao;
use Catalog\Model\Entity\Product;
use Catalog\Model\Dao\CategoryDao;
use Caralog\Model\Entity\UrlAlias;
use Catalog\Model\Dao\urlAliasDao;
use Admin\Model\Entity\Category;
use Admin\Model\Entity\ProductImage;
use Zend\ViewModel\JsonModel;
use Provider\Model\Dao\ProviderDao;

use Zend\Json\Json;
use Zend\File\Transfer\Adapter\Http as FileTransferAdapter;
use ArrayObject;
use Admin\Form\ProductImage as ProductImageForm;

class ProductController extends AbstractActionController
{

    private $productTable;
    private $categoryDao;
    private $productForm;
    private $urlAliasDao;

    public function indexAction()
    {
        // return $this->forward()->dispatch('Admin\Controller\Login', array('action' => 'index'));
        return array();
    }

    public function listAction()
    {
        $productDao = $this->getProductDao();
        
        //PAGINATOR   
        // grab the paginator from the AlbumTable
        $productTableGateway = $this->getService('ProductTableGateway');
        $productDao = new ProductDao($productTableGateway);

        $paginator = $productDao->setAll()->getPaginator();
        // set the current page to what has been passed in query string, or to 1 if none set
        $paginator->setCurrentPageNumber((int) $this->params()->fromQuery('page', 1));
        // set the number of items per page to 10
        //print_r($paginator);die;
        $paginator->setItemCountPerPage(10);
        // var_dump($paginator);die;
        
          return new ViewModel(array(
            //'products' => $productDao->getAll(),
            'products' => $paginator
          
        ));
        
    }

    public function addAction()
    {
        $cat = $this->getCategorySelect();
        
        $this->productForm = new ProductForm();
        
        $this->productForm->get('productCategories')->setValueOptions($cat);
        
        $providers = $this->getProvider();
        //print_r($provider);die;
        //array_unshift($providers, null);
        $this->productForm->get('provider')->setValueOptions($providers);
        
        $related = $this->getProductSelect();
//        //print_r($related);die;
        $this->productForm->get('related_id')->setValueOptions($related);
        
      
        //print_r($provider);die;
//        $this->productForm->get('provider_id')->setValueOptions($provider);
        
        if ($this->request->isPost()) {
            
         
           $postData = array_merge_recursive(
               $this->request->getPost()->toArray(),
               $this->request->getFiles()->toArray()
           );
          // print_r($postData);die;
           
            $this->productForm->setInputFilter(new ProductValidator($this->getServiceLocator()));
            $this->productForm->setData($postData);
//            var_dump($this->productForm);die;
            
            if ($this->productForm->isValid()) {
                $productData = $this->productForm->getData();
                //print_r($productData);die;         
                $productEntity = new Product();
                $productEntity->exchangeArrayForm($productData);
               // var_dump($productEntity);die;
                $productDao = $this->getProductDao();
                $saved = $productDao->saveProduct($productEntity);
                
                if($saved){
                   
                  return $this->redirect()->toRoute('admin', array(
                      'controller' => 'provider', 
                      'action' => 'productlist',
                      'id' => $postData['provider']
                  ));
                }
               
                
            } else {
                //$messages = $this->productForm->getMessages();
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
        
        if ($request->isPost()) {
            
            $postData = array_merge_recursive(
               $this->request->getPost()->toArray(),
               $this->request->getFiles()->toArray()
           );
           
            //print_r($postData);
            $productDao = $this->getProductDao();
            $seoUrl = $productDao->getSeoUrlByProduct($postData['productId']);
            
            $productValidator = new ProductValidator($this->getServiceLocator());
            
            if(!$postData['image']['tmp_name']){
               $productValidator->remove('image');
               $postData['image'] = null;
            }  
            
            if($seoUrl->getUrlAlias()->keyword == $postData['productSeoUrl']){  
                $productValidator->remove('productSeoUrl');
            }
           
            $this->productForm->setInputFilter($productValidator);
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
                //print_r($messages);die;
                $this->productForm->populateValues($postData);
            }
            
           
        }
         
        
        
        if (!$id) {
            return $this->redirect()->toRoute('admin', array('controller' => 'product', 'action' => 'list'));
        }
        
        
        $productDao = $this->getProductDao();
        $productData = $productDao->getProductById($id);
        //print_r($productData); die;
         $providers = $this->getProvider();
        //print_r($provider);die;
       //echo array_unshift($providers, null);die;
        $this->productForm->get('provider')->setValueOptions($providers);
        
        $related = $this->getProductSelect();
//        //print_r($related);die;
        $this->productForm->get('related_id')->setValueOptions($related);
        
        $cat = $this->getCategorySelect();
        $this->productForm->get('productCategories')->setValueOptions($cat);
        
        $this->productForm->get('image')->setAttribute('required', false);
        
        $productFormData = new ArrayObject;
        $productFormData['productId']           = $productData->getProductId();
        $productFormData['provider']            = $productData->getProviderid();
        //$productFormData['image']            = $productData->getImage();
        $productFormData['productName']         = $productData->getProductDescription()->getName();
        $productFormData['productModel']        = $productData->getModel();
        $productFormData['productDescription']  = $productData->getProductDescription()->getDescription();
        $productFormData['productSku']          = $productData->getSku();
        $productFormData['productIsbn']         = $productData->getIsbn();
        $productFormData['productPrice']        = $productData->getPrice();
        $productFormData['productMinimum']      = $productData->getMinimum();
        $productFormData['productCategories']   = $productData->getProductCategories();
        $productFormData['productMetaTittle']   = $productData->getProductDescription()->getMeta_tittle();
        $productFormData['productMetaDescription']   = $productData->getProductDescription()->getMeta_Description();
        $productFormData['productMetaKeywords']   = $productData->getProductDescription()->getMeta_Keyword();
        $productFormData['productSeoUrl']       = $productData->getUrlAlias()->keyword;
        $productFormData['related_id']       = $productData->getProductRelated();
        
        //$productFormData['productQuantity']       = array(50);
        $productFormData['productStock']          = 1;
        $productFormData['productStockStatus']    = 1;
        
       
        $imageData = $productData->getProductImage();
       
           
        //print_r($imageData); die;
        //$this->productForm->bind($contact);
        $this->productForm->setData($productFormData);
        $view['productForm'] = $this->productForm;
        $view['image'] = $productData->getImage();
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
        //print_r($delete);die;
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

    public function statusAction(){
        $request = $this->getRequest();
        $response = $this->getResponse();
        
        $status = $request->getPost('status');
        $id = $request->getPost('id');

        $productDao = $this->getProductDao();
        $update = $productDao->updateProductStatus($status,$id);

        switch ($status) {
            case 1:
                $statusName = 'Active';
                break;
            case 0:
                $statusName = 'Inactive';
                break;
            case 2:
                $statusName = 'Archived';
                break;
        }

        if ($update){
                
                           
                $response->setStatusCode(200);
                $response->setContent(\Zend\Json\Json::encode(array(
                    'response' => $update,
                    'status' => $status,
                    'statusName' => $statusName
                    )
                ));
           
        }else{
            
                $response->setStatusCode(400);
                $response->setContent(\Zend\Json\Json::encode(array('response' => $update)));
            
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
        //$ver = $results->toArray();
        //print_r($ver);
        $result = array();
        foreach ($results as $cat) {
           //$result[] = $row->getArrayCopy();
           $result[$cat->category_id] = $cat->name;
        }
        
       return $result;
        
    }
    
    public function seoAction(){
        $request = $this->getRequest();
        $response = $this->getResponse();

        $seo = $request->getQuery('seo');

        $urlDao = $this->getUrlDao();
        $seoExist = $urlDao->getAll($seo);
        $keyword = $seoExist->toArray();

        if (empty($keyword)){   
                
                $response->setStatusCode(200);
                $response->setContent(\Zend\Json\Json::encode('true'));
           
        }else{
                
                $response->setStatusCode(200);
                $response->setContent(\Zend\Json\Json::encode('Este SEO ya existe, por favor seleccione otro'));
            }
        
        return $response;
        
    }

    public function getProductDao()
    {
        if (! $this->productTable) {
            $sm = $this->getServiceLocator();
            $this->productTable = $sm->get('Admin\Model\Dao\ProductDao');
        }
        return $this->productTable;
    }

    public function getUrlDao()
    {
        if (! $this->urlAliasDao) {
            $sm = $this->getServiceLocator();
            $tableGateway = $sm->get('UrlAliasTableGateway');
            $this->urlAliasDao = new UrlAliasDao($tableGateway); 
        }
        return $this->urlAliasDao;
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
    
    public function getProviderDao()
    {
        if (!isset($this->providerDao)) {
            $sm = $this->getServiceLocator();       
            $tableGateway = $sm->get('ProviderTableGateway');
            $this->providerDao = new ProviderDao($tableGateway);                
        }
        return $this->providerDao;
    }

    private function getProductSelect() {

        $productDao = $this->getProductDao();
        $results = $productDao->getAll();

        $result = array();
        foreach ($results as $related) {
           //$result[] = $row->getArrayCopy();
           $result[$related->getProductId()] = $related->getProductDescription()->getName();
        }
        //print_r($result);die;
       return $result;
    }
    
     private function getProvider() 
    {       
        $providerDao = $this->getProviderDao();
        $results = $providerDao->getAll();

         $result = array();
        foreach ($results as $provider) {
           //$result[] = $row->getArrayCopy();
           $result[$provider->provider_id] = $provider->company;
        }
        return $result;
    }
    
    public function getProductRelated()
    {
        $productDao = $this->getProductDao();
        $results = $productDao->getAll();

        $products = array_map(function ($product) {
        $description = $product['productDescription'];

            return array(
                'id' => $product['product_id'],
                'name' => $description->getName(),
            );

        }, $results->toArray());

        return $products;
    }
    
    public function getProductId()
    {
       $productDao = $this->getProductDao();
        $results = $productDao->getAll();

        $products = array_map(function ($product) {
        $description = $product['productDescription'];

            return array(
                'id' => $product['product_id'],
                'name' => $description->getName(),
            );

        }, $results->toArray());

        return $products; 
    }
    
    public function getService($serviceName)
    {
        $sm = $this->getServiceLocator();
        $service = $sm->get($serviceName);
        
        return $service;
    }
}
