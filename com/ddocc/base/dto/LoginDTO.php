<?php
namespace com\ddocc\base\dto;
use com\ddocc\base\entity\EntityBase;
class LoginDTO  extends EntityBase {
    var $email; 
    var $pwd;    
    var $labels = array(
            'email' => 'Email Address',
            'pwd' => 'Password',
        );   
    
    function Set($dr) {
        $this->email = $dr['email'];
        $this->pwd = $dr['pwd'];
    }
    
    function Rules() {
        $rules = array(
            'required' => array(
                'email' => 'yes',
                'pwd' => 'yes',
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