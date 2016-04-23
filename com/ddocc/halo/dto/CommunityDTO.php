<?php

namespace com\ddocc\halo\dto;

use com\ddocc\base\entity\EntityBase;

class CommunityDTO extends EntityBase {
    
    var $id;
    var $community_name;
    var $parent_id;
    var $ancestor_id;
    var $community_slug;
    var $community_type_id;
    var $community_type_name;
    var $statusflag;
    var $last_updated;
    
    var $parent_name;
    var $ancestor_name;
    var $members;
    var $admin_users;
    var $non_admin_users;
    var $active_users;
    var $inactive_users;    
    var $request_users;
    var $blocked_users;
    
    var $labels = array(
        'id' => 'Community ID',
        'community_name' => 'Community',
        'community_slug' => 'Short URL',
        'community_type_id' => 'Community Type ID',
        'community_type_name' => 'Community Type Name',
        'statusflag' => 'Community Status',
        'last_updated' => 'Last Updated',
        'parent_id' => 'Parent Community',
        'parent_name' => 'Parent Community',
        'ancestor_id' => 'Ancestor Community',
        'ancestor_name' => 'Ancestor Community',
        'members' => 'All Members',
        'admin_users' => 'Admins',
        'non_admin_users' => 'Non-Admins',
        'active_users' => 'Active',
        'inactive_users' => 'Inactive',
        'request_users' => 'Join Requests',
        'blocked_users' => 'Blocked',
    );

    function Set($dr) {
        $this->id = $dr['id'];
        $this->community_name = $dr['community_name'];
        $this->parent_id = $dr['parent_id'];
        $this->ancestor_id = $dr['ancestor_id'];
        $this->community_slug = $dr['community_slug'];
        $this->community_type_id = $dr['community_type_id'];
        $this->community_type_name = $dr['community_type_name'];
        $this->statusflag = $dr['statusflag'];
        $this->last_updated = $dr['last_updated'];     
        $this->parent_name = $dr['parent_name'];   
        $this->ancestor_name = $dr['ancestor_name'];
        $this->members = $dr['members'];
        $this->admin_users = $dr['admin_users'];
        $this->non_admin_users = $dr['non_admin_users'];
        $this->active_users = $dr['active_users'];
        $this->inactive_users = $dr['inactive_users'];
        $this->request_users = $dr['request_users'];
        $this->blocked_users = $dr['blocked_users'];
    }

    function Rules() {
        $rules = array(
            'required' => array(
                'community_name' => 'yes',
                'parent_id' => 'yes',
                'community_slug' => 'yes',
            ),
            'length' => array(
                'community_name' => '64',
                'community_slug' => '64',
            ),
            'numeric' => array(
                'parent_id' => 'yes',
                'ancestor_id' => 'yes',
            ),
        );
        return $rules;
    }
    
    function Display() {
        $txt = '<div class="panel panel-default">
  <div class="panel-body">'.$this->community_name.'
  </div>
  <a href="'. UrlID('community.detail', $this->id) .'">
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
