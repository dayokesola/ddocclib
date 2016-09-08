<?php

namespace com\ddocc\base\entity;

Class SiteTab extends EntityBase {

    var $tab_id;
    var $tab_ent;
    var $tab_text;
    var $var1;
    var $var2;
    var $var3;
    var $var4;
    var $var5;

    function Set($dr) {
        $this->tab_id = $dr['tab_id'];
        $this->tab_ent = $dr['tab_ent'];
        $this->tab_text = $dr['tab_text'];
        $this->var1 = $dr['var1'];
        $this->var2 = $dr['var2'];
        $this->var3 = $dr['var3'];
        $this->var4 = $dr['var4'];
        $this->var5 = $dr['var5'];
    }
    
    function GetId()
    {
        return $this->tab_ent;
    }
    function GetName()
    {
        return $this->tab_text ;
    }

}
