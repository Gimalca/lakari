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

class Seller
{

    public $seller_id;
    public $firstname;
    public $lastname;
    public $email;
    public $telephone;
    public $movil;
    public $fax;
    public $password;
    public $salt;
    public $ip;
    public $status;
    public $approved;
    public $token;
    public $date_added;

    //put your code here
   
    public function exchangeArray($data = null)
    {
        $this->seller_id = (isset($data['seller_id'])) ? $data['seller_id'] : null;
        $this->firstname = (isset($data['firstname'])) ? $data['firstname'] : null;
        $this->lastname = (isset($data['lastname'])) ? $data['lastname'] : null;
        $this->email = (isset($data['email'])) ? $data['email'] : null;
        $this->telephone = (isset($data['telephone'])) ? $data['telephone'] : null;
        $this->movil = (isset($data['movil'])) ? $data['movil'] : null;
        $this->fax = (isset($data['fax'])) ? $data['fax'] : null;
        $this->password = (isset($data['password'])) ? $data['password'] : null;
        $this->salt = (isset($data['salt'])) ? $data['salt'] : null;
        $this->ip = (isset($data['ip'])) ? $data['ip'] : null;
        $this->status = (isset($data['status'])) ? $data['status'] : null;
        $this->approved = (isset($data['approved'])) ? $data['approved'] : null;
        $this->token = (isset($data['token'])) ? $data['token'] : null;
        $this->date_added = (isset($data['date_added'])) ? $data['date_added'] : null;
    }

    public function getArrayCopy()
    {
        return get_object_vars($this);
    }

}
