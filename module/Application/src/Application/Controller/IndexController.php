<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2015 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Application\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Zend\Json\Json;

use Catalog\Model\Dao\ProductDao;
use Catalog\Model\Entity\Product;


class IndexController extends AbstractActionController {
    
     private $productTable;

    public function indexAction() {
       
        $productDao = $this->getDao('Admin\Model\Dao\ProductDao');
        $columns = array('product_id', 'model', 'image', 'description', 'price');

        $sm = $this->getServiceLocator();
        $basePath = $sm->get('viewhelpermanager')->get('basePath');
        $path = $basePath('assets/images/products/catalog/');

        /* TODO Consulta Para los productos
         * mas vendidos
         */
        $imageC = '';
        $bestSeller = $productDao->products($columns)
            ->limit(10, 16)
            ->fetch(function ($product) use ($path) {
                $product['id'] = $product['product_id'];
                return $product;
            })
            ->withImages($imageC, function ($images) use ($path) {
                return array_map(function ($image) use ($path) {
                    $image->setBasePath($path);
                    return $image;
                }, $images->getArrayCopy());
            })
            ->getJSON();

        //print_r($bestSeller);die;

        /* TODO Consulta Para los productos
         * mas nuevos
         */

        $newProducts = $productDao->products($columns)
            ->limit(10, 25)
            ->fetch(function ($product) use ($path) {
                $product['id'] = $product['product_id'];
                return $product;
            })
            ->withImages($imageC, function ($images) use ($path) {
                return array_map(function ($image) use ($path) {
                    $image->setBasePath($path);
                    return $image;
                }, $images->getArrayCopy());
            })
            ->getJSON();

        //print_r($newProducts);die;

        return new ViewModel(array(
            'bestSeller' => $bestSeller,
            'latest' => $newProducts
        ));
    }

    public function provedoresAction() {
        echo 'ver'; die;
        return new ViewModel();
    }

    public function expanderAction() {

        $request = $this->getRequest();
        if ($request->isXmlHttpRequest()) {

            $id = $request->getQuery('id', 0);
            if ($id != 0) {
                $productDao = $this->getDao('Admin\Model\Dao\ProductDao');

                $columns = array('product_id', 'model', 'image', 'description', 'price');
                $imageC = array('product_image_id','image', 'sort_order');
                $descriptionC = array('description', 'name');

                $sm = $this->getServiceLocator();
                $basePath = $sm->get('viewhelpermanager')->get('basePath');
                $path = $basePath('assets/images/products/catalog/');

                $product = $productDao->products($columns)
                    ->descriptions($descriptionC)
                    ->where($id)
                    ->fetch()
                    ->withDescriptions()
                    ->withImages($imageC, function ($images) use ($path) {
                        return array_map(function ($image) use ($path) {
                            $image->setBasePath($path);
                            return $image;
                        }, $images->getArrayCopy());
                    })
                    ->getJSON();

                $response = $this->getResponse();
                $response->setStatusCode(200);
                $response->setContent($product);
                return $response;
            }

            $response = $this->getResponse();
            $response->setStatusCode(404);
            $response->setContent(Json::encode(array('error' => 'Product Not Found')));
            return $response;
        }
    }

    public function getDao($service) {

        if (!$this->productTable) {
            $sm = $this->getServiceLocator();
            $this->productTable = $sm->get($service);
        }
        return $this->productTable;
    }
}
