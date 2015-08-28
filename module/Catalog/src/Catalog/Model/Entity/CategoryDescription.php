<?php

namespace Catalog\Model\Entity;

class CategoryDescription {

    public $category_id;
    public $language_id;
    public $name;
    public $description;
    public $meta_description;
    public $meta_keyword;

    function __construct($category_id = Null) {
        $this->category_id = $category_id;
    }

    public function exchangeArray($data) {

        $this->category_id = (isset($data['category_id'])) ? $data['category_id'] : null;
        $this->language_id = (isset($data['language_id'])) ? $data['language_id'] : null;
        $this->name = (isset($data['name'])) ? $data['name'] : null;
        $this->description = (isset($data['description'])) ? $data['description'] : null;
        $this->meta_description = (isset($data['meta_description'])) ? $data['meta_description'] : null;
        $this->meta_keyword = (isset($data['meta_keyword'])) ? $data['meta_keyword'] : null;
    }

    public function getArrayCopy() {
        return get_object_vars($this);
    }

    
}
