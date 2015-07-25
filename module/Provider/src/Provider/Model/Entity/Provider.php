<?php

namespace Provider\Model\Entity;

class Provider {
    
    public $provider_id;
    public $store_id;
    public $company;
    public $company_id;
    public $email;
    public $telephone;
    public $fax;
    public $password;
    public $salt;
    public $active;
    public $address_id;
    public $ip;
    public $status;
    public $approved;
    public $token;
    public $categories;
    public $logo;
    public $date_added;
    
    public function exchangeArray($data = Null)
    {
        $this->provider_id = (isset($data['provider_id'])) ? $data['provider_id'] : null;
        $this->store_id = (isset($data['store_id'])) ? $data['store_id'] : null;
        $this->company = (isset($data['company'])) ? $data['company'] : null;
        $this->company_id = (isset($data['company_id'])) ? $data['company_id'] : null;
        $this->email = (isset($data['email'])) ? $data['email'] : null;
        $this->telephone = (isset($data['telephone'])) ? $data['telephone'] : null;
        $this->fax = (isset($data['fax'])) ? $data['fax'] : null;
        $this->password = (isset($data['password'])) ? $data['password'] : null;
        $this->salt = (isset($data['salt'])) ? $data['salt'] : null;
        $this->address_id = (isset($data['address_id'])) ? $data['address_id'] : null;
        $this->ip = (isset($data['ip'])) ? $data['ip'] : null;
        $this->status = (isset($data['status'])) ? $data['status'] : null;
        $this->active = (isset($data['active'])) ? $data['active'] : null;
        $this->approved = (isset($data['approved'])) ? $data['approved'] : null;
        $this->token = (isset($data['token'])) ? $data['token'] : null;
        $this->categories = (isset($data['categories'])) ? $data['categories'] : null;
        $this->date_added = (isset($data['date_added'])) ? $data['date_added'] : null;
        $this->logo = (isset($data['logo'])) ? $data['logo'] : null;
    }
    
    public function getArrayCopy() {
        return get_object_vars($this);
    }
    
    
    
}