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
    
    function getProvider_id() {
        return $this->provider_id;
    }

    function getStore_id() {
        return $this->store_id;
    }

    function getCompany() {
        return $this->company;
    }

    function getCompany_id() {
        return $this->company_id;
    }

    function getEmail() {
        return $this->email;
    }

    function getTelephone() {
        return $this->telephone;
    }

    function getFax() {
        return $this->fax;
    }

    function getPassword() {
        return $this->password;
    }

    function getSalt() {
        return $this->salt;
    }

    function getActive() {
        return $this->active;
    }

    function getAddress_id() {
        return $this->address_id;
    }

    function getIp() {
        return $this->ip;
    }

    function getStatus() {
        return $this->status;
    }

    function getApproved() {
        return $this->approved;
    }

    function getToken() {
        return $this->token;
    }

    function getCategories() {
        return $this->categories;
    }

    function getLogo() {
        return $this->logo;
    }

    function getDate_added() {
        return $this->date_added;
    }

    function setProvider_id($provider_id) {
        $this->provider_id = $provider_id;
    }

    function setStore_id($store_id) {
        $this->store_id = $store_id;
    }

    function setCompany($company) {
        $this->company = $company;
    }

    function setCompany_id($company_id) {
        $this->company_id = $company_id;
    }

    function setEmail($email) {
        $this->email = $email;
    }

    function setTelephone($telephone) {
        $this->telephone = $telephone;
    }

    function setFax($fax) {
        $this->fax = $fax;
    }

    function setPassword($password) {
        $this->password = $password;
    }

    function setSalt($salt) {
        $this->salt = $salt;
    }

    function setActive($active) {
        $this->active = $active;
    }

    function setAddress_id($address_id) {
        $this->address_id = $address_id;
    }

    function setIp($ip) {
        $this->ip = $ip;
    }

    function setStatus($status) {
        $this->status = $status;
    }

    function setApproved($approved) {
        $this->approved = $approved;
    }

    function setToken($token) {
        $this->token = $token;
    }

    function setCategories($categories) {
        $this->categories = $categories;
    }

    function setLogo($logo) {
        $this->logo = $logo;
    }

    function setDate_added($date_added) {
        $this->date_added = $date_added;
    }

        
    public function getArrayCopy() {
        return get_object_vars($this);
    }
    
    
    
}