<?php

namespace com\ddocc\base\entity;

class Locale {

    var $locale_id;
    var $locale_name;
    var $locale_code;
    var $region_id;
    var $region_name;
    var $region_code;
    var $country_id;
    var $country_name;
    var $country_code;

    function Set($dr, $entity = '') {
        $this->locale_id = $dr[$entity . 'locale_id'];
        $this->locale_name = $dr[$entity . 'locale_name'];
        $this->locale_code = $dr[$entity . 'locale_code'];
        $this->region_id = $dr[$entity . 'region_id'];
        $this->region_name = $dr[$entity . 'region_name'];
        $this->region_code = $dr[$entity . 'region_code'];
        $this->country_id = $dr[$entity . 'country_id'];
        $this->country_name = $dr[$entity . 'country_name'];
        $this->country_code = $dr[$entity . 'country_code'];
    }
    
    function GetId()
    {
        return $this->locale_id;
    }
    function GetName()
    {
        return $this->country_name .' ~ '.$this->region_name.' ~ '.$this->locale_name ;
    }

}
