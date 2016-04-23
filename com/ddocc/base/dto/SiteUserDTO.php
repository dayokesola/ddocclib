<?php
namespace com\ddocc\base\dto;


use com\ddocc\base\entity\EntityBase;
class SiteUserDTO extends EntityBase  {    
    var $user_id;
    var $email;  
    var $role_id;
    var $statusflag;
    var $date_added;
    var $last_updated;
    var $last_reset;
    var $fname;
    var $lname; 
    var $mobile;

    var $profile;
    
    var $labels = array(
        'user_id' => 'User ID',
        'email' => 'Email', 
        'role_id' => 'Role',
        'statusflag' => 'User Status',
        'date_added' => 'Date Profiled', 
        'last_updated' => 'Last Updated', 
        'last_reset' => 'Last Password Reset',
        'fname' => 'First Name',
        'lname' => 'Surname',
        'mobile' => 'Mobile Number',
    );
    
    
    function Set($dr) {
        $this->user_id = $dr['user_id'];
        $this->email = $dr['email'];  
        $this->role_id = $dr['role_id'];
        $this->statusflag = $dr['statusflag'];
        $this->date_added = $dr['date_added'];
        $this->last_updated = $dr['last_updated'];
        $this->last_reset = $dr['last_reset'];
        $this->fname = $dr['fname'];
        $this->lname = $dr['lname']; 
        $this->mobile = $dr['mobile'];
    }
    function Rules() {
        $rules = array(
            'required' => array(
                'email' => 'yes',
                'fname' => 'yes',
                'lname' => 'yes',
            ),
            'length' => array(
                'auth_email' => '128',
                'fname' => '64',
                'lname' => '64',
                'mobile' => '64',
            ),
            'email' => array(
                'auth_email' => 'yes',                
            ),
        );
        return $rules;
    }
    
}
