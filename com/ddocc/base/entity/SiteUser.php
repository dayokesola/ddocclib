<?php

namespace com\ddocc\base\entity;
use com\ddocc\base\utility\Gizmo;
Class SiteUser extends EntityBase {

    var $user_id;
    var $auth_email;
    var $auth_phrase;
    var $auth_spice;
    var $role_id;
    var $statusflag;
    var $date_added;
    var $last_updated;
    var $last_reset;
    var $fname;
    var $lname;
    var $auth_code;
    var $mobile;

    function Set($dr, $entity = '') {
        $this->user_id = $dr[$entity . 'user_id'];
        $this->auth_email = $dr[$entity . 'auth_email'];
        $this->auth_phrase = $dr[$entity . 'auth_phrase'];
        $this->auth_spice = $dr[$entity . 'auth_spice'];
        $this->role_id = $dr[$entity . 'role_id'];
        $this->statusflag = $dr[$entity . 'statusflag'];
        $this->date_added = $dr[$entity . 'date_added'];
        $this->last_updated = $dr[$entity . 'last_updated'];
        $this->last_reset = $dr[$entity . 'last_reset'];
        $this->fname = $dr[$entity . 'fname'];
        $this->lname = $dr[$entity . 'lname'];
        $this->auth_code = $dr[$entity . 'auth_code'];
        $this->mobile = $dr[$entity . 'mobile'];
    }

    function HideAuth() {
        $this->auth_spice = "mickey";
        $this->auth_phrase = "mouse";
    }

    function Fullname() {
        return $this->fname . ' ' . $this->lname;
    }
    
    function GetName() {
        return $this->fname . ' ' . $this->lname;
    }
    
    function PresetNewUser(){
        $cost = 10;
        $salt = strtr(base64_encode(mcrypt_create_iv(16, MCRYPT_DEV_URANDOM)), '+', '.');
        $this->auth_spice = sprintf("$2a$%02d$", $cost) . $salt;
        $this->auth_phrase = crypt($this->auth_phrase, $this->auth_spice);
        $this->date_added = Gizmo::Now(); 
        $this->last_reset = Gizmo::Now();
        $this->last_updated = Gizmo::Now();  
        $this->auth_code = '0'; 
    }

}
