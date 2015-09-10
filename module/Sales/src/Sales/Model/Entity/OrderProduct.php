<?php 

namespace Sales\Model\Entity;

class OrderProduct {

    public $order_product_id;
    public $order_id;
    public $product_id;
    public $name;
    public $model;
    public $quantity;
    public $price;
    public $total;
    public $tax;
    public $reward;

    public function __construct(Array $attributes = array()) {
        $this->exchangeArray($attributes);
    }

    public function exchangeArray($data) {

        $attributes = array_keys($this->getArrayCopy());

        foreach($attributes as $attr) {
            if (isset($data[$attr])) {
                $this->{$attr} = $data[$attr];
            }
        }
    }

    public function getArrayCopy() {
        return get_object_vars($this);
    }

}
