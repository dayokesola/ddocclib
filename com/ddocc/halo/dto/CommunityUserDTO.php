<?php

namespace com\ddocc\halo\dto;
use com\ddocc\base\entity\EntityBase;

class CommunityUserDTO extends EntityBase {
    public function __construct() {
         
    }    
    var $community_id;
    var $email;
    var $fname;
    var $lname;
    var $mobile;
    var $role_id;
    var $user_id;
    var $statusflag;
    var $community_name;
    var $community_slug;
    var $role_name;
    var $statustext;
    var $last_updated;
    
    var $labels = array(
        'community_id' => 'Community ID',
        'user_id' => 'User',
        'email' => 'Email',
        'role_id' => 'Role',
        'role_name' => 'Role',
        'fname' => 'First Name',
        'lname' => 'Last Name',
        'fullname' => 'Full Name',
        'statusflag' => 'User Status',
        'statustext' => 'User Status',
        'community_name' => 'Community',
        'mobile' => 'Mobile Number',  
        'community_slug' => 'Short URL',
        'last_updated' => 'Last Updated',
    );

    function Set($dr) {        
        $this->community_id = $dr['community_id'];
        $this->user_id = $dr['user_id'];
        $this->role_id = $dr['role_id'];
        $this->statusflag = $dr['statusflag'];
        $this->community_name = $dr['community_name'];
        $this->community_slug = $dr['community_slug'];
        $this->email = $dr['email'];
        $this->fname = $dr['fname'];
        $this->lname = $dr['lname'];
        $this->mobile = $dr['mobile'];  
        $this->role_name = $dr['role_name'];
        $this->statustext = $dr['statustext'];  
        $this->last_updated = $dr['last_updated'];
    }
    
    function Rules() {
        $rules = array(
            'required' => array(
                'community_id' => 'yes',
                'email' => 'yes',
                'role_id' => 'yes',
                'statusflag' => 'yes',
            ),
            'numeric' => array(
                'community_id' => 'yes',  
                'role_id' => 'yes',  
                'statusflag' => 'yes',                
            ),
            'email' => array(
                'email' => 'yes',
            ),
        );
        return $rules;
    }
    
     function Display() {
        $txt = '<div class="panel panel-default">
  <div class="panel-body">'.$this->community_name.'
  </div>
  <a href="'. UrlID('community.detail', $this->community_id) .'">
                <div class="panel-footer">
                    <span class="pull-left">View Community</span>
                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                    <div class="clearfix"></div>
                </div>
            </a>
</div>';
        
        echo $txt;
    }
}
