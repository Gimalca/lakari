<?php

/**
 * Description of Product
 *
 * @author Pedro
 */

namespace Admin\Model\Entity;

use Admin\Model\Entity\ProductDescription;
use Admin\Model\Entity\ProductImage;
use Catalog\Model\Entity\UrlAlias;
/**
 * @author Pedro
 *
 */
class Product
{

    private $product_id;
    private $provider_id;
    private $model;
    private $sku;
    private $isbn;
    private $quantity;
    private $image;
    private $price;
    private $date_available;
    private $minimum;
    private $status;
    private $description;
    private $date_added;
    private $date_modified;
    // Add Tables 
    private $productDescription;
    private $productImage;
    private $urlAlias;
    private $productCategories;

   

 function exchangeArray($data = NULL)
    {
        $this->product_id = (isset($data['product_id'])) ? $data['product_id'] : null;
        $this->provider_id = (isset($data['provider_id'])) ? $data['provider_id'] : null;
        $this->model = (isset($data['model'])) ? $data['model'] : null;
        $this->sku = (isset($data['sku'])) ? $data['sku'] : null;
        $this->isbn = (isset($data['isbn'])) ? $data['isbn'] : null;
        $this->quantity = (isset($data['quantity'])) ? $data['quantity'] : null;
        $this->image = (isset($data['image'])) ? $data['image'] : null;
        $this->price = (isset($data['price'])) ? $data['price'] : null;
        $this->minimum = (isset($data['minimum'])) ? $data['minimum'] : null;
        $this->date_available = (isset($data['date_available'])) ? $data['date_available'] : null;
        $this->status = (isset($data['status'])) ? $data['status'] : null;
        $this->description = (isset($data['description'])) ? $data['description'] : null;
        $this->date_added = (isset($data['date_added'])) ? $data['date_added'] : null;
        $this->date_modified = (isset($data['date_modified'])) ? $data['date_modified'] : null;
        
        $this->productCategories = (isset($data['category_id'])) ? $data['category_id'] : null;

        $this->productDescription = new ProductDescription();
        $this->productDescription->setName((isset($data['name'])) ? $data['name'] : null);
        $this->productDescription->setLanguage_id((isset($data['language_id'])) ? $data['language_id'] : null);
        $this->productDescription->setDescription((isset($data['description'])) ? $data['description'] : null);
        $this->productDescription->setMeta_description((isset($data['meta_description'])) ? $data['meta_description'] : null);
        $this->productDescription->setMeta_keyword((isset($data['meta_keyword'])) ? $data['meta_keyword'] : null);
        $this->productDescription->setMeta_tittle((isset($data['meta_tittle'])) ? $data['meta_tittle'] : null);
        

        $this->productImage = (isset($data['image'])) ? $data['image'] : null;

        $this->urlAlias = New UrlAlias;
        $this->urlAlias->keyword = (isset($data['keyword'])) ? $data['keyword'] : null;
    }
    
    function exchangeArrayForm($data = NULL)
    {
        $this->product_id = (isset($data['productId'])) ? $data['productId'] : null;
        $this->provider_id = (isset($data['provider_id'])) ? $data['provider_id'] : null;
        $this->model = (isset($data['productModel'])) ? $data['productModel'] : null;
        $this->sku = (isset($data['productSku'])) ? $data['productSku'] : null;
        $this->isbn = (isset($data['productIsbn'])) ? $data['productIsbn'] : null;
        $this->quantity = (isset($data['quantity'])) ? $data['quantity'] : null;
        $this->image = (isset($data['image'])) ? $data['image'] : null;
        $this->price = (isset($data['productPrice'])) ? $data['productPrice'] : null;
        $this->date_available = (isset($data['date_available'])) ? $data['date_available'] : null;
        $this->minimum = (isset($data['productMinimum'])) ? $data['productMinimum'] : null;
        $this->status = (isset($data['status'])) ? $data['status'] : null;
        $this->description = (isset($data['description'])) ? $data['description'] : null;
        $this->date_added = (isset($data['date_added'])) ? $data['date_added'] : null;
        $this->date_modified = (isset($data['date_modified'])) ? $data['date_modified'] : null;
        $this->productCategories = (isset($data['productCategories'])) ? $data['productCategories'] : null;
        
        $this->productDescription = new ProductDescription();
        $this->productDescription->setName((isset($data['productName'])) ? $data['productName'] : null);
        $this->productDescription->setLanguage_id((isset($data['language_id'])) ? $data['language_id'] : null);
        $this->productDescription->setDescription((isset($data['productDescription'])) ? $data['productDescription'] : null);
        $this->productDescription->setMeta_description((isset($data['productMetaDescription'])) ? $data['productMetaDescription'] : null);
        $this->productDescription->setMeta_keyword((isset($data['productMetaKeywords'])) ? $data['productMetaKeywords'] : null);
        $this->productDescription->setMeta_tittle((isset($data['productMetaTittle'])) ? $data['productMetaTittle'] : null);
        
        if ($data['productImage']){
         $images = new \ArrayObject(); $i=1;
         foreach ($data['productImage'] as $image){
             //list($nameRoot, $nameImage) = explode("\\", $image['tmp_name']);
             //echo $image['tmp_name'].'<br/>';
             $explo = explode('img_', $image['tmp_name']);
             //print_r($explo);
             $img = 'img_'. $explo[1];
             $productImage = new ProductImage();
             $productImage->image = $img;
             $productImage->sort_order = $i++;
             $images->append($productImage);
         }
        } //die;
        $this->productImage = (isset($images)) ? $images : null;
        
       
    
        $this->urlAlias = New UrlAlias;
        $this->urlAlias->keyword = (isset($data['productSeoUrl'])) ? $data['productSeoUrl'] : null;
        $this->urlAlias->type = 'product';
    }
    
    function setProductModel($model)
    {
        $this->productModel = $model;
    }

    function getProductId()
    {
        return $this->product_id;
    }
    function getProvider_id()
    {
        return $this->provider_id;
    }

    function getModel()
    {
        return $this->model;
    }
    function getSku()
    {
        return $this->sku;
    }

    function getIsbn()
    {
        return $this->isbn;
    }

    function getMinimum()
    {
        return $this->minimum;
    }

        function getQuantity()
    {
        return $this->quantity;
    }

    function getImage()
    {
        return $this->image;
    }

    function getPrice()
    {
        return $this->price;
    }

    function getDate_available()
    {
        return $this->date_available;
    }

    function getStatus()
    {
        return $this->status;
    }
   
    public function getProductCategories()
    {
        return $this->productCategories;
    }
    
    public function setProductCategories($productCategories)
    {
        $this->productCategories = $productCategories;
    }

    function getDescription()
    {
        return $this->description;
    }

    function getProductDescription()
    {
        return $this->productDescription;
    }

    function getDate_added()
    {
        return $this->date_added;
    }

    function getDate_modified()
    {
        return $this->date_modified;
    }

    function getUrlAlias()
    {
        return $this->urlAlias;
    }

    function getProductImage()
    {
        return $this->productImage;
    }
    

    function setProductDescription(ProductDescription $productDescription)
    {
        $this->productDescription = $productDescription;
    }

    function setProductImage($productImage)
    {
        $this->productImage = $productImage;
    }

    function setUrlAlias(UrlAlias $urlAlias)
    {
        $this->urlAlias = $urlAlias;
    }
    public function setQuantity($quantity)
    {
        $this->quantity = $quantity;
    }
    public function getArrayCopy() {
        return get_object_vars($this);
    }
    
}
