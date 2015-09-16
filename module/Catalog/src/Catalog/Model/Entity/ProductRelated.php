<?php

namespace Catalog\Model\Entity;

class ProductRelated
{
    private $product_id;
    private $related_id;
    
    public function exchangeArray($data) {
        
        $this->product_id = (isset($data['product_id'])) ? $data['product_id'] : null;
        $this->related_id = (isset($data['related_id'])) ? $data['related_id'] : null;
    }
    
    function getProduct_id() {
        return $this->product_id;
    }

    function getRelated_id() {
        return $this->related_id;
    }

    function setProduct_id($product_id) {
        $this->product_id = $product_id;
    }

    function setRelated_id($related_id) {
        $this->related_id = $related_id;
    }

    
    public function getArrayCopy() {
        return get_object_vars($this);
    }
}