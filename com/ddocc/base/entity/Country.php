<?php
namespace com\ddocc\base\entity;

class Country { 
    var $country_id;
    var $country_name;
    
    function Set($dr, $entity = '') {
        $this->country_id = $dr[$entity . 'country_id'];
        $this->country_name = $dr[$entity . 'country_name']; 
    }
}
