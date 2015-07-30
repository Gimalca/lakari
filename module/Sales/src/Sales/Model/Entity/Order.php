<?php

/*
 * To change this license header choose License Headers in Project Properties.
 * To change this template file choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Customer
 *
 * @author Pedro
 */

namespace Sales\Model\Entity;

class Order
{

    public $order_id;
    public $customer_id;
  

    //put your code here
   
    public function exchangeArray($data = null)
    {
        $this->order_id = (isset($data['order_id'])) ? $data['order_id'] : null;
        $this->customer_id = (isset($data['customer_id'])) ? $data['customer_id'] : null;
     
    }

    public function getArrayCopy()
    {
        return get_object_vars($this);
    }

}
