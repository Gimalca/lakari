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

class Order {

    public $order_id;
    public $customer_id;
    public $invoice_no;
    public $invoice_prefix;
    public $firstname;
    public $lastname;
    public $email;
    public $telephone;
    public $fax;
    public $comment;
    public $total;
    public $order_status_id;
    public $currency_id;
    public $currency_code;
    public $currency_value;
    public $ip;
    public $forwarded_ip;
    public $user_agent;
    public $date_added;
    public $date_modified;

    //put your code here

    public function exchangeArray($data = null)
    {
        $this->order_id = (isset($data['order_id'])) ? $data['order_id'] : null;
        $this->customer_id = (isset($data['customer_id'])) ? $data['customer_id'] : null;
        $this->invoice_no = (isset($data['invoice_no'])) ? $data['invoice_no'] : null;
        $this->invoice_prefix = (isset($data['invoice_prefix'])) ? $data['invoice_prefix'] : null;
        $this->customer_id = (isset($data['customer_id'])) ? $data['customer_id'] : null;
        $this->firstname = (isset($data['firstname'])) ? $data['firstname'] : null;
        $this->lastname = (isset($data['lastname'])) ? $data['lastname'] : null;
        $this->email = (isset($data['email'])) ? $data['email'] : null;
        $this->telephone = (isset($data['telephone'])) ? $data['telephone'] : null;
        $this->fax = (isset($data['fax'])) ? $data['fax'] : null;
        $this->comment = (isset($data['comment'])) ? $data['comment'] : null;
        $this->total = (isset($data['total'])) ? $data['total'] : null;
        $this->order_status_id = (isset($data['order_status_id'])) ? $data['order_status_id'] : null;
        $this->currency_id = (isset($data['currency_id'])) ? $data['currency_id'] : null;
        $this->currency_code = (isset($data['currency_code'])) ? $data['currency_code'] : null;
        $this->currency_value = (isset($data['currency_value'])) ? $data['currency_value'] : null;
        $this->ip = (isset($data['ip'])) ? $data['ip'] : null;
        $this->forwarded_ip = (isset($data['forwarded_ip'])) ? $data['forwarded_ip'] : null;
        $this->user_agent = (isset($data['user_agent'])) ? $data['user_agent'] : null;
        $this->date_added = (isset($data['date_added'])) ? $data['date_added'] : null;
        $this->date_modified = (isset($data['date_modified'])) ? $data['date_modified'] : null;
    }

    public function getArrayCopy()
    {
        return get_object_vars($this);
    }

}
