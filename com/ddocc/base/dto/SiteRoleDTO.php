<?php

namespace com\ddocc\base\dto;

use com\ddocc\base\entity\SiteRole;

class SiteRoleDTO extends SiteRole {

    var $fxns;
    var $labels = array(
        'role_id' => 'Role ID',
        'role_name' => 'Role Name',
        'role_text' => 'Menu',
        'last_updated' => 'Last Updated',
    );

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