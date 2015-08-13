<?php

namespace Catalog\Model\Entity;

class InformationPage
{
    private $page_id;
    private $sort_order;
    private $status;
    private $name;
    private $value;
    private $title;
    private $description;
    
            
   
    
    function __construct($page_id = null) 
    {
        $this->page_id = $page_id;
    }
    
    public function exchangeArray($data) 
    {
        $this->page_id = (isset($data['page_id'])) ? $data['page_id'] : null;
        $this->sort_order = (isset($data['sort_order'])) ? $data['sort_order'] : null;
        $this->status = (isset($data['status'])) ? $data['status'] : null;
        $this->name = (isset($data['name'])) ? $data['name'] : null;
        $this->value = (isset($data['value'])) ? $data['value'] : null;
        $this->title = (isset($data['title'])) ? $data['title'] : null;
        $this->description = (isset($data['description'])) ? $data['description'] : null;
    }
    
    function getPageId()
    {
        return $this->page_id;
    }
    
    function getSortOrder()
    {
        return $this->sort_order;
    }
    
    function getStatus()
    {
        return $this->status;
    }
    
    function getName() 
    {
        return $this->name;
    }
    
    function getValue() 
    {
        return $this->value;
    }

    function getTitle() 
    {
        return $this->title;
    }

    function getDescription() 
    {
        return $this->description;
    }

    function setPage_id($page_id) 
    {
        $this->page_id = $page_id;
    }

    function setSort_order($sort_order) 
    {
        $this->sort_order = $sort_order;
    }

    function setStatus($status) 
    {
        $this->status = $status;
    }

    function setName($name) 
    {
        $this->name = $name;
    }
    
    function setValue($value) 
    {
        $this->value = $value;
    }

    function setTitle($title) 
    {
        $this->title = $title;
    }

    function setDescription($description) 
    {
        $this->description = $description;
    }

           
    public function getArrayCopy() {
        return get_object_vars($this);
    }
}
