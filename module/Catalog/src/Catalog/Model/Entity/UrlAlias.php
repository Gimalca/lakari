<?php

namespace Catalog\Model\Entity;

class UrlAlias {

    public $url_alias_id;
    public $id;
    public $type;
    public $keyword;

    function __construct($url_alias_id = null, $id = null, $type = null, $keyword = null)
    {
        $this->url_alias_id = $url_alias_id;
        $this->id = $id;
        $this->type = $type;
        $this->keyword = $keyword;
    }

    public function exchangeArray($data) {
        $this->url_alias_id = (isset($data['url_alias_id'])) ? $data['url_alias_id'] : null;
        $this->id = (isset($data['id'])) ? $data['id'] : null;
        $this->type = (isset($data['type'])) ? $data['type'] : null;
        $this->keyword = (isset($data['keyword'])) ? $data['keyword'] : null;
    }

    public function getArrayCopy() {
        return get_object_vars($this);
    }

}