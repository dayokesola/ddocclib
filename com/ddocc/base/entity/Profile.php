<?php

namespace com\ddocc\base\entity;
 
class Profile {
    //put your code here
    var $id;
    var $profile_name;
    var $profile_slug;
    var $profile_group;
    var $profile_value;
    var $data_type;
    
    function Set($dr) {
        $this->id = $dr['id'];
        $this->profile_name = $dr['profile_name'];
        $this->profile_slug = $dr['profile_slug'];
        $this->profile_group = $dr['profile_group'];
        $this->profile_value = $dr['profile_value']; 
        $this->data_type = $dr['data_type']; 
    }
}
