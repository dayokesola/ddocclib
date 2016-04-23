<?php
namespace com\ddocc\base\entity;
use com\ddocc\base\utility\Connect;
use com\ddocc\base\utility\Gizmo;
class SiteRole extends EntityBase
{
    var $role_id;
    var $role_name;
    var $role_text;
    var $last_updated;

    var $fxns;

    function GetMenu()
    {
        $d = "<li class='dropdown'><a href='#' class='dropdown-toggle' data-toggle='dropdown' role='button' aria-haspopup='true' aria-expanded='false'>";
        $e = "<span class='caret'></span></a><ul class='dropdown-menu'>";
        $f = "</ul></li>";
        $g = "<li><a href='";
        $h = "'>";
        $i = "</a></li>";

        $str = Gizmo::SafeHTMLDecode($this->role_text);
        $str = Gizmo::Replace("~d",$d, $str);
        $str = Gizmo::Replace("~e",$e, $str);
        $str = Gizmo::Replace("~f",$f, $str);
        $str = Gizmo::Replace("~g",$g, $str);
        $str = Gizmo::Replace("~h",$h, $str);
        $str = Gizmo::Replace("~i",$i, $str);
        return $str;
    }


    function Load()
    {
        $sql = "SELECT role_id, role_name, role_text, last_updated FROM __DB__roles WHERE role_id = :role_id";
        $cn = new Connect();
        $cn->SetSQL($sql);
        $cn->AddParam(':role_id', $this->role_id);

        $ds = $cn->Select();
        $this->role_id = 0;
        if($cn->num_rows > 0)
        {
            $this->Set($ds[0]);
        }
    }

    function LoadByName()
    {
        $sql = "SELECT role_id, role_name, role_text, last_updated FROM __DB__roles WHERE role_name = :role_name";
        $cn = new Connect();
        $cn->SetSQL($sql);
        $cn->AddParam(':role_name', $this->role_name);

        $ds = $cn->Select();
        $this->role_id = 0;
        if($cn->num_rows > 0)
        {
            $this->Set($ds[0]);
        }
    }

    function Set($dr)
    {
        $this->role_id = $dr['role_id'];
        $this->role_name = $dr['role_name'];
        $this->role_text = $dr['role_text'];
        $this->last_updated = $dr['last_updated'];
    }

    function Insert()
    {
        $sql = "INSERT INTO __DB__roles (role_name, role_text, last_updated)  VALUES ( :role_name, :role_text, :last_updated) ";
        $cn = new Connect();
        $cn->SetSQL($sql);
        $cn->AddParam(':role_name', $this->role_name);
        $cn->AddParam(':role_text', $this->role_text);
        $cn->AddParam(':last_updated', $this->last_updated);
        $this->role_id = $cn->Insert();
        return $this->role_id;
    }

    function Update()
    {
        $sql = "UPDATE __DB__roles SET role_name = :role_name, role_text = :role_text,
         last_updated = :last_updated WHERE role_id = :role_id";
        $cn = new Connect();
        $cn->SetSQL($sql);
        $cn->AddParam(':role_name', $this->role_name);
        $cn->AddParam(':role_text', $this->role_text);
        $cn->AddParam(':last_updated', $this->last_updated);
        $cn->AddParam(':role_id', $this->role_id);
        return $cn->Update();
    }

    function Delete()
    {
        $sql = "DELETE FROM __DB__roles WHERE role_id = :role_id";
        $cn = new Connect();
        $cn->SetSQL($sql);
        $cn->AddParam(':role_id', $this->role_id);
        return $cn->Delete();
    }

}
