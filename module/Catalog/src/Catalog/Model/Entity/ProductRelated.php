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

    public function getArrayCopy() {
        return get_object_vars($this);
    }
}