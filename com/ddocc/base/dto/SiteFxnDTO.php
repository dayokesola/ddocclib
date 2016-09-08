<?php 

namespace com\ddocc\base\dto;

use com\ddocc\base\entity\SiteFxn;
 
class SiteFxnDTO extends SiteFxn{
    
    var $fxns;
    
    var $fxn_group_name;
    
    function Set($dr, $entity = '') {
        parent::Set($dr, $entity); 
        $this->fxn_group_name = $dr[$entity . 'fxn_group_name'];
    }
    
    var $labels = array(
        'fxn_id' => 'Fxn ID',
        'fxn_name' => 'Fxn Name',
        'fxn_group' => 'Fxn Group ID',
        'fxn_sort' => 'Sort',
        'fxn_url' => 'Fxn URI',
        'fxn_flag' => 'Show In Menu?',
        'fxn_secure' => 'Secured?',
        'fxn_icon' => 'Fxn Icon',
        'last_updated' => 'Last Updated', 
        'fxn_group_name' => 'Fxn Group Name', 
    );

    function Rules() {
        $rules = array(
            'required' => array(
                'fxn_name' => 'yes',
                'fxn_url' => 'yes',                
                'fxn_group' => 'yes',
                'fxn_secure' => 'yes',
                'fxn_flag' => 'yes',
            ),
            'length' => array(
                'fxn_name' => '128',
                'fxn_url' => '128',
            ),
            'numeric' => array(
                'fxn_id' => 'yes',
                'fxn_sort' => 'yes',
                'fxn_group' => 'yes',
                'fxn_flag' => 'yes',
                'fxn_secure' => 'yes',
            ),
        );
        return $rules;
    }
}
