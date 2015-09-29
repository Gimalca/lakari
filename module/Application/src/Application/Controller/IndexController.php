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

    public function indexAction() {

        $productDao = $this->getDao('Admin\Model\Dao\ProductDao');
        $columns = array('product_id', 'model', 'image', 'description', 'price');

        $sm = $this->getServiceLocator();
        $basePath = $sm->get('viewhelpermanager')->get('basePath');
        $path = $basePath('assets/images/products/catalog/');

        /* TODO Consulta Para los productos
         * mas vendidos
         */

        $bestSeller = $productDao->products($columns)
            ->images()
            ->limit(10, 10)
            ->fetch(function ($product) use ($path) {
                $product['id'] = $product['product_id'];
                $product['image'] = $path . $product['image'];
                return $product;
            })
            ->getJSON();

       // print_r($bestSeller);die;

        /* TODO Consulta Para los productos
         * mas nuevos
         */

        $newProducts = $productDao->products($columns)
            ->images()
            ->limit(10, 20)
            ->fetch(function ($product) use ($path) {
                $product['id'] = $product['product_id'];
                $product['image'] = $path . $product['image'];
                return $product;
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
            $response->setStatusCode(400);
            $response->setContent(Json::encode(array('error' => 'Product Not Found')));
            return $response;
        }
    }

    public function getDao($service) {

        if (! $this->productTable) {

            $sm = $this->getServiceLocator();
            $this->productTable = $sm->get($service);
        }

        return $this->productTable;
    }
}

/*
 * formatRowsJSON(Array, String, Array)
 * @param $results Array Results from query
 * @param $pk String name of Primary Key pivot (id)
 * @param $foreign Array FieldName => newKey to Stack into
 * Array
 */

// Rutina para Obtener Filas JSON
function formatRowsJSON($results, $pk, $foreign) {

    $products = [];
    $nested = [];

    foreach($results as $row) {

        $id = $row[$pk];

        foreach($row as $key => $value) {
            // Para Controlar que claves convertiremos en
            // arreglos
            if (array_key_exists($key, $foreign)) {

                // Extraer los atributos del objeto
                // para apilarlos
                if(is_object($value)) {
                    //Obtener valores y las propiedades del objeto
                    $attrs = $value->getArrayCopy();
                    if($attrs && !empty($attrs) && !is_null($attrs)) {
                        $nested[$id][$foreign[$key]] = array_filter($attrs);
                    }
                } else {
                    // Para cambiar el nombre del campo
                    if (isset($value) && !is_null($value) && $value) {
                        $nested[$id][$foreign[$key]][] = $value;
                    }
                }
            } else {
                // Es un campo Normal
                if (isset($value) && !is_null($value) && $value) {
                    $products[$id][$key] = $value;
                }
            }
        }
    }
    // Llevar las propiedades anidadas
    // a su respectivo producto
    foreach($nested as $id => $attributes) {
        foreach($attributes as $field => $values) {
            $products[$id][$field] = $values;
        }
    }
    return $products;
}

/**
 * Recursively removes null values
 * in array
 * @param $array
 *
 */

function cleanArray($array) {

    if (is_array($array)) {

        foreach ($array as $key => $sub_array) {
                $result = cleanArray($sub_array);
            if ($result === false) {
                unset($array[$key]);
            } else {
                $array[$key] = $result;
            }
        }
    } else {
        if (is_object($array)) {
            $array = $array->getArrayCopy();
            cleanArray($array);
        }
    }

    if (empty($array)) {
        return false;
    }

    return $array;
}
