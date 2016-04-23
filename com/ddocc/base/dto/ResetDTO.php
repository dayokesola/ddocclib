<?php

namespace com\ddocc\base\dto;
use com\ddocc\base\entity\EntityBase;
class ResetDTO extends EntityBase {
    var $email;    
    var $labels = array(
            'email' => 'Email Address',
        );   
    
    function Set($dr) {
        $this->email = $dr['email'];
    }
    
    function Rules() {
        $rules = array(
            'required' => array(
                'email' => 'yes',
            ),
            'length' => array(
                'email' => '128',
            ),
            'email' => array(
                'email' => 'yes',                
            ),
        );
        return $rules;
    }    
}
