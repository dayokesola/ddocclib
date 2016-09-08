<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace com\ddocc\base\dto;
use com\ddocc\base\entity\SiteTab;

/**
 * Description of SiteTabDTO
 *
 * @author okesolaa
 */
class SiteTabDTO extends SiteTab {
    //put your code here
     var $labels = array(
        'tab_id' => 'Table Group ID',
        'tab_ent' => 'Table Entry Key',
        'tab_text' => 'Table Entry Value', 
        'var1' => 'Table Entry Value 1', 
        'var2' => 'Table Entry Value 2', 
        'var3' => 'Table Entry Value 3', 
        'var4' => 'Table Entry Value 4', 
        'var5' => 'Table Entry Value 5', 
    );

    function Rules() {
        $rules = array(
            'required' => array(
                'tab_id' => 'yes',
                'tab_ent' => 'yes',
                'tab_text' => 'yes',
            ),
            'length' => array(
                'tab_text' => '200',
                'var1' => '200',
                'var2' => '200',
                'var3' => '200',
                'var4' => '200',
                'var5' => '200', 
            ),
            'numeric' => array(
                'tab_id' => 'yes',
                'tab_ent' => 'yes',
            ),
        );
        return $rules;
    }
}
 