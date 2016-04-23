<?php
namespace com\ddocc\cms\entity;
use com\ddocc\base\utility\Connect;
class CmsMenu
{
    var $menu_id;
    var $menu_name;
    var $last_updated;

    function Load()
    {
        $sql = "SELECT menu_id, menu_name, last_updated FROM ez_menus WHERE menu_id = :menu_id";
        $cn = new Connect();
        $cn->SetSQL($sql);
        $cn->AddParam(':menu_id', $this->menu_id);

        $ds = $cn->Select();
        $this->menu_id = 0;
        if ($cn->num_rows > 0) {
            $this->Set($ds[0]);
        }
    }

    function Set($dr)
    {
        $this->menu_id = $dr['menu_id'];
        $this->menu_name = $dr['menu_name'];
        $this->last_updated = $dr['last_updated'];
    }

    function LoadByName()
    {
        $sql = "SELECT menu_id, menu_name, last_updated FROM ez_menus WHERE menu_name = :menu_name";
        $cn = new Connect();
        $cn->SetSQL($sql);
        $cn->AddParam(':menu_name', $this->menu_name);

        $ds = $cn->Select();
        $this->menu_id = 0;
        if ($cn->num_rows > 0) {
            $this->Set($ds[0]);
        }
    }

    function Insert()
    {
        $sql = "INSERT INTO ez_menus (menu_name, last_updated)  VALUES ( :menu_name, :last_updated) ";
        $cn = new Connect();
        $cn->SetSQL($sql);
        $cn->AddParam(':menu_name', $this->menu_name);
        $cn->AddParam(':last_updated', $this->last_updated);

        $this->menu_id = $cn->Insert();
        return $this->menu_id;
    }

    function Update()
    {
        $sql = "UPDATE ez_menus SET menu_name = :menu_name, last_updated = :last_updated WHERE menu_id = :menu_id";
        $cn = new Connect();
        $cn->SetSQL($sql);
        $cn->AddParam(':menu_name', $this->menu_name);
        $cn->AddParam(':last_updated', $this->last_updated);
        $cn->AddParam(':menu_id', $this->menu_id);

        return $cn->Update();
    }

    function Delete()
    {
        $sql = "DELETE FROM ez_menus WHERE menu_id = :menu_id";
        $cn = new Connect();
        $cn->SetSQL($sql);
        $cn->AddParam(':menu_id', $this->menu_id);

        return $cn->Delete();
    }
}
