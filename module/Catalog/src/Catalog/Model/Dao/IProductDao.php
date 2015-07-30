<?php

namespace Catalog\Model\Dao;
/**
 * Description of IProductDao
 *
 * @author Pedro
 */
use Catalog\Model\Entity\Product;

interface IProductDao
{
     public function getAll();
     public function getById($id);
     public function saveProduct(Product $product);
     public function deleteProduct($productId);
     public function getImages($productId);
     
    //put your code here
}
