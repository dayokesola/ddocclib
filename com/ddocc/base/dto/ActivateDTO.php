<?php
namespace com\ddocc\base\dto;
use com\ddocc\base\entity\EntityBase;

class ActivateDTO  extends EntityBase {
    var $email;
    var $code;
    var $pwd1;
    var $pwd2;
    var $labels = array(
            'email' => 'Email Address',
            'code' => 'Authorization Code',
            'pwd1' => 'Password',
            'pwd2' => 'Confirm Password',
        );   
    
    function Set($dr) {
        $this->email = $dr['email'];
        $this->code = $dr['code'];
        $this->pwd1 = $dr['pwd1'];
        $this->pwd2 = $dr['pwd2'];
    }
    
    function Rules() {
        $rules = array(
            'required' => array(
                'email' => 'yes',
                'code' => 'yes',
                'pwd1' => 'yes',
                'pwd2' => 'yes',
            ),
            'length' => array(
                'email' => '128',
            ),
            'email' => array(
                'email' => 'yes',                
            ),
            'similar' => array(
                'pwd1' => 'pwd2',                
            ),
        );
        return $rules;
    }    
}
