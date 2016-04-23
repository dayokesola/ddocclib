<?php

namespace com\ddocc\base\dto;

use com\ddocc\base\entity\EntityBase;

class SiteRoleDTO extends EntityBase {

    var $role_id;
    var $role_name;
    var $role_text;
    var $last_updated;
    
    var $labels = array(
        'role_id' => 'Role ID',
        'role_name' => 'Role Name',
        'role_text' => 'Menu',
        'last_updated' => 'Last Updated',
    );

    function Set($dr) {
        $this->role_id = $dr['role_id'];
        $this->role_name = $dr['role_name'];
        $this->role_text = $dr['role_text'];
        $this->last_updated = $dr['last_updated'];
    }

    function Rules() {
        $rules = array(
            'required' => array(
                'role_name' => 'yes',
            ),
            'length' => array(
                'role_name' => '64',
            ),
            'numeric' => array(
                'role_id' => 'no',
            ),
        );
        return $rules;
    }

}
