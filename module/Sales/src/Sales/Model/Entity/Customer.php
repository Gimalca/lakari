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

class Customer {

    public $customer_id;
    public $firstname;
    public $lastname;
    public $email;
    public $telephone;
    public $fax;
    public $password;
    public $salt;
    public $cart;
    public $wishlist;
    public $newsletter;
    public $address_id;
    public $ip;
    public $status;
    public $approved;
    public $token;
    public $date_added;

    //put your code here
    
     public function __construct(Array $data = array())
    {
        $this->exchangeArray($data);
    }

    public function  exchangeArray($data = null)
    {
        $this->customer_id = (isset($data['customer_id'])) ? $data['customer_id'] : null;
        $this->firstname = (isset($data['firstname'])) ? $data['firstname'] : null;
        $this->lastname = (isset($data['lastname'])) ? $data['lastname'] : null;
        $this->email = (isset($data['email'])) ? $data['email'] : null;
        $this->telephone = (isset($data['telephone'])) ? $data['telephone'] : null;
        $this->fax = (isset($data['fax'])) ? $data['fax'] : null;
        $this->password = (isset($data['password'])) ? $data['password'] : null;
        $this->salt = (isset($data['salt'])) ? $data['salt'] : null;
        $this->cart = (isset($data['cart'])) ? $data['cart'] : null;
        $this->wishlist = (isset($data['wishlist'])) ? $data['wishlist'] : null;
        $this->newsletter = (isset($data['newsletter'])) ? $data['newsletter'] : null;
        $this->address_id = (isset($data['address_id'])) ? $data['address_id'] : null;
        $this->ip = (isset($data['ip'])) ? $data['ip'] : null;
        $this->status = (isset($data['status'])) ? $data['status'] : null;
        $this->approved = (isset($data['approved'])) ? $data['approved'] : null;
        $this->token = (isset($data['token'])) ? $data['token'] : null;
        $this->date_added = (isset($data['date_added'])) ? $data['date_added'] : null;
    }

    public function getArrayCopy() {
        return get_object_vars($this);
    }
}
