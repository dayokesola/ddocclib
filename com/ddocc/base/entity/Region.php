<?php

namespace com\ddocc\base\entity;

class Region {

    var $region_id;
    var $region_name;
    var $region_code;
    var $country_id;
    var $country_name;
    var $country_code;

    function Set($dr, $entity = '') {
        $this->region_id = $dr[$entity . 'region_id'];
        $this->region_name = $dr[$entity . 'region_name'];
        $this->country_id = $dr[$entity . 'country_id'];
        $this->region_code = $dr[$entity . 'region_code'];
        $this->country_name = $dr[$entity . 'country_name'];
        $this->country_code = $dr[$entity . 'country_code'];
    }
}
