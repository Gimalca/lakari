<?php

namespace Admin\Model\Dao;
/**
 * Description of IProductDao
 *
 * @author Pedro
 */
use Admin\Model\Entity\Product;

interface IProductDao
{
     public function getAll();
     public function getById($id);
     public function saveProduct(Product $product);
     public function deleteProduct(Product $product);
     public function getImages($productId);
     
    //put your code here
}
