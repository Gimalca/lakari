<?php

/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonModule for the canonical source repository
 * @copyright Copyright (c) 2005-2015 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Catalog\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class IndexController extends AbstractActionController
{

    protected $productTable;
    protected $urlAliasTable;
    
    

    public function indexAction()
    {
        //$params = $this->params()->fromRoute();
        //var_dump($params); 
        
        $images = $this->getProductDao()->getImages();
        //var_dump($image);die;
        return new ViewModel(array(
            'products' => $this->getProductDao()->getAll(),
            'products2' => $this->getProductDao()->getAll(),
            'images' => $images,
        ));
    }

    public function detailAction()
    {
        $url = $this->params()->fromRoute('product');
        $id = $this->getUrlAliasDao()->getKeywordId($url);
       
        $product = $this->getProductDao()->getProductById($id->id);
         
        return new ViewModel(array(
            'product' => $product,
        ));
    }

    public function getProductDao()
    {
        if (!$this->productTable) {
            $sm = $this->getServiceLocator();
            $this->productTable = $sm->get('Catalog\Model\Dao\ProductDao');
        }
        return $this->productTable;
    }
    public function getUrlAliasDao()
    {
        if (!$this->urlAliasTable) {
            $sm = $this->getServiceLocator();
            $this->urlAliasTable = $sm->get('Catalog\Model\Dao\UrlAliasDao');
        }
        return $this->urlAliasTable;
    }

}
