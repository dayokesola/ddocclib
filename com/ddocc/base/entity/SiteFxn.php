<?php

namespace com\ddocc\base\entity;

class SiteFxn extends EntityBase {

    var $fxn_id;
    var $fxn_name;
    var $fxn_group;
    var $fxn_sort;
    var $fxn_url;
    var $fxn_flag;
    var $fxn_secure;
    var $fxn_icon;
    var $last_updated;

    function Set($dr, $entity = '') {
        $this->fxn_id = $dr[$entity . 'fxn_id'];
        $this->fxn_name = $dr[$entity . 'fxn_name'];
        $this->fxn_group = $dr[$entity . 'fxn_group'];
        $this->fxn_sort = $dr[$entity . 'fxn_sort'];
        $this->fxn_url = $dr[$entity . 'fxn_url'];
        $this->fxn_flag = $dr[$entity . 'fxn_flag'];
        $this->fxn_secure = $dr[$entity . 'fxn_secure'];
        $this->fxn_icon = $dr[$entity . 'fxn_icon'];
        $this->last_updated = $dr[$entity . 'last_updated'];
    }
}
