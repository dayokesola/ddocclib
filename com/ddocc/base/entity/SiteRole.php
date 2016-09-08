<?php

namespace com\ddocc\base\entity;


use com\ddocc\base\utility\Gizmo;

class SiteRole extends EntityBase {

    var $role_id;
    var $role_name;
    var $role_text;
    var $last_updated;

    function Set($dr, $entity = '')
    {
        $this->role_id = $dr[$entity . 'role_id'];
        $this->role_name = $dr[$entity . 'role_name'];
        $this->role_text = $dr[$entity . 'role_text'];
        $this->last_updated = $dr[$entity . 'last_updated'];              
    }
    
        function GetMenu() {
        $d = "<li class='dropdown'><a href='#' class='dropdown-toggle' data-toggle='dropdown' role='button' aria-haspopup='true' aria-expanded='false'>";
        $e = "<span class='caret'></span></a><ul class='dropdown-menu'>";
        $f = "</ul></li>";
        $g = "<li><a href='";
        $h = "'>";
        $i = "</a></li>";

        $str = Gizmo::SafeHTMLDecode($this->role_text);
        $str = Gizmo::Replace("~d", $d, $str);
        $str = Gizmo::Replace("~e", $e, $str);
        $str = Gizmo::Replace("~f", $f, $str);
        $str = Gizmo::Replace("~g", $g, $str);
        $str = Gizmo::Replace("~h", $h, $str);
        $str = Gizmo::Replace("~i", $i, $str);
        return $str;
    }
}
