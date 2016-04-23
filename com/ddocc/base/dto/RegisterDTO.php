<?php
namespace com\ddocc\base\dto;

use com\ddocc\base\entity\EntityBase;
class RegisterDTO extends EntityBase {
    //put your code here
    var $fname; 
    var $lname;
    var $email;
    var $pwd1;
    var $pwd2;
    var $mobile;
    
    var $labels = array(
            'fname' => 'First Name',
            'lname' => 'Last Name',
            'email' => 'Email Address',
            'pwd1' => 'Password',
            'pwd2' => 'Confirm Password',
            'mobile' => 'Mobile Number',
        );
    
    
    function Set($dr) {
        $this->fname = $dr['fname'];
        $this->lname = $dr['lname'];
        $this->email = $dr['email'];
        $this->pwd1 = $dr['pwd1'];
        $this->pwd2 = $dr['pwd2'];
        $this->mobile = $dr['mobile'];
    }
    
    function Rules() {
        $rules = array(
            'required' => array(
                'fname' => 'yes',
                'lname' => 'yes',
                'email' => 'yes',
                'pwd1' => 'yes',
                'pwd2' => 'yes',
                'mobile' => 'yes',
            ),
            'length' => array(
                'fname' => '128',
                'lname' => '128',
                'email' => '128',
            ),
            'email' => array(
                'email' => 'yes',                
            ),
            'mobile' => array(
                'mobile' => 'yes',                
            ),
            'similar' => array(
                'pwd1' => 'pwd2',                
            ),
        );
        return $rules;
    }
    
}