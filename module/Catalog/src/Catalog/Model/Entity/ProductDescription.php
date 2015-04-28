<?php

/**
 * Description of Product
 *
 * @author Pedro
 */

namespace Catalog\Model\Entity;

class ProductDescription
{

    private $product_id;
    private $language_id;
    private $name;
    private $description;
    private $meta_description;
    private $meta_keyword;
    private $meta_tittle;
    private $tag;

    public function exchangeArray($data)
    {
        $this->product_id = (isset($data['product_id'])) ? $data['product_id'] : null;
        $this->language_id = (isset($data['language_id'])) ? $data['language_id'] : null;
        $this->name = (isset($data['name'])) ? $data['name'] : null;
        $this->description = (isset($data['description'])) ? $data['description'] : null;
        $this->meta_description = (isset($data['meta_description'])) ? $data['meta_description'] : null;
        $this->meta_keyword = (isset($data['meta_keyword'])) ? $data['meta_keyword'] : null;
        $this->tag = (isset($data['tag'])) ? $data['tag'] : null;
        $this->meta_tittle = (isset($data['meta_tittle'])) ? $data['meta_tittle'] : null;
    }

    function getProduct_id()
    {
        return $this->product_id;
    }

    function getLanguage_id()
    {
        return $this->language_id;
    }

    function getName()
    {
        return $this->name;
    }

    function getDescription()
    {
        return $this->description;
    }

    function getMeta_description()
    {
        return $this->meta_description;
    }

    function getMeta_keyword()
    {
        return $this->meta_keyword;
    }

    function getTag()
    {
        return $this->tag;
    }

    function setProduct_id($product_id)
    {
        $this->product_id = $product_id;
    }

    function setLanguage_id($language_id)
    {
        $this->language_id = $language_id;
    }

    function setName($name)
    {
        $this->name = $name;
    }

    function setDescription($description)
    {
        $this->description = $description;
    }

    function setMeta_description($meta_description)
    {
        $this->meta_description = $meta_description;
    }

    function setMeta_keyword($meta_keyword)
    {
        $this->meta_keyword = $meta_keyword;
    }

    function setTag($tag)
    {
        $this->tag = $tag;
    }
 /**
     * @return the $meta_tittle
     */
    public function getMeta_tittle()
    {
        return $this->meta_tittle;
    }

 /**
     * @param Ambigous <NULL, unknown> $meta_tittle
     */
    public function setMeta_tittle($meta_tittle)
    {
        $this->meta_tittle = $meta_tittle;
    }

    

}
