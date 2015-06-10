<?php

namespace Admin\Model\Entity;

class ProductImage {

     public $product_image_id;
     public $product_id;
     public $image;
     public $sort_order;
     
     function __construct($product_image_id = null, $product_id = null, $image = null, $sort_order = null)
     {
         $this->product_image_id = $product_image_id;
         $this->product_id = $product_id;
         $this->image = $image;
         $this->sort_order = $sort_order;
     }

      

    public function exchangeArray($data) {
        $this->product_image_id = (isset($data['product_image_id'])) ? $data['product_image_id'] : null;
        $this->product_id = (isset($data['product_id'])) ? $data['product_id'] : null;
        $this->image = (isset($data['image'])) ? $data['image'] : null;
        $this->sort_order = (isset($data['sort_order'])) ? $data['sort_order'] : null;
        
    }

    public function getArrayCopy() {
        return get_object_vars($this);
    }

}

