<?php

namespace com\ddocc\base\dto;

use com\ddocc\base\entity\SiteUser;

class SiteUserDTO extends SiteUser {
  
    var $profiles = array();
    var $bank_id; 
    var $region_id;
    var $branch_id;
    var $corporate_id;
    var $business_unit_id;
    var $statustext;
    var $role_name;
    var $overdraw_limit;
    var $sales_officer_id;    
    var $introducer_id;

    var $labels = array(
        'user_id' => 'User ID',
        'auth_email' => 'Email',
        'role_id' => 'Role ID',
        'statusflag' => 'User Status',
        'date_added' => 'Date Profiled',
        'last_updated' => 'Last Updated',
        'last_reset' => 'Last Password Reset',
        'fname' => 'First Name',
        'lname' => 'Surname',
        'mobile' => 'Mobile Number',
        'statustext' => 'Statustext',
        'role_name' => 'Role Name',
    );

    function Set($dr, $entity = '') {
        parent::Set($dr, $entity);
        $this->statustext = $dr[$entity . 'statustext'];
        $this->role_name = $dr[$entity . 'role_name'];          
        $this->bank_id = $dr[$entity . 'bank_id'];  
        $this->region_id = $dr[$entity . 'region_id'];  
        $this->branch_id = $dr[$entity . 'branch_id'];  
        $this->corporate_id = $dr[$entity . 'corporate_id'];  
        $this->business_unit_id = $dr[$entity . 'business_unit_id'];  
        $this->overdraw_limit = $dr[$entity . 'overdraw_limit'];  
        $this->sales_officer_id = $dr[$entity . 'sales_officer_id'];  
        $this->introducer_id = $dr[$entity . 'introducer_id'];  
    }

    function Rules() {
        $rules = array(
            'required' => array(
                'auth_email' => 'yes',
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
