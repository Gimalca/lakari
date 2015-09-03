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

    function getSeller_id() {
        return $this->seller_id;
    }

    function getFirstname() {
        return $this->firstname;
    }

    function getLastname() {
        return $this->lastname;
    }

    function getEmail() {
        return $this->email;
    }

    function getTelephone() {
        return $this->telephone;
    }

    function getMovil() {
        return $this->movil;
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

    function getDate_added() {
        return $this->date_added;
    }

    function setSeller_id($seller_id) {
        $this->seller_id = $seller_id;
    }

    function setFirstname($firstname) {
        $this->firstname = $firstname;
    }

    function setLastname($lastname) {
        $this->lastname = $lastname;
    }

    function setEmail($email) {
        $this->email = $email;
    }

    function setTelephone($telephone) {
        $this->telephone = $telephone;
    }

    function setMovil($movil) {
        $this->movil = $movil;
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

    function setDate_added($date_added) {
        $this->date_added = $date_added;
    }


}
