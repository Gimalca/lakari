<?php

namespace Catalog\Model\Entity;

class Category {

    public $category_id;
    public $image;
    public $parent_id;
    public $top;
    public $colum;
    public $sort_order;
    public $status;
    public $date_added;
    public $date_modified;
    public $name;
    
    function __construct($category_id = Null)
    {
        $this->category_id = $category_id;
    }
    
    
    public function exchangeArray($data) {
        
        $this->category_id = (isset($data['category_id'])) ? $data['category_id'] : null;
        $this->image = (isset($data['image'])) ? $data['image'] : null;
        $this->parent_id = (isset($data['parent_id'])) ? $data['parent_id'] : null;
        $this->top =  (isset($data['top'])) ? $data['top'] : null;
        $this->colum =  (isset($data['colum'])) ? $data['colum'] : null;
        $this->sort_order =  (isset($data['sort_order'])) ? $data['sort_order'] : null;
        $this->status =  (isset($data['status'])) ? $data['status'] : null;
        $this->date_added =  (isset($data['date_added'])) ? $data['date_added'] : null;
        $this->date_modified =  (isset($data['date_modified'])) ? $data['date_modified'] : null;
        $this->name =  (isset($data['name'])) ? $data['name'] : null;
    }

    
    public function getArrayCopy() {
        return get_object_vars($this);
    }

}



