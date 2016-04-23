<?php
namespace com\ddocc\cms\entity;
use com\ddocc\base\utility\Connect;
class CmsMenuItem
{
    var $menu_item_id;
    var $menu_item_name;
    var $menu_id;
    var $parent_id;
    var $page_id;
    var $target;
    var $menu_item_rank;
    var $last_updated;
    var $other_url;


    function Load()
    {
        $sql = "SELECT menu_item_id, menu_item_name, menu_id, parent_id, page_id, target, menu_item_rank, last_updated, other_url FROM ez_menu_items WHERE menu_item_id = :menu_item_id";
        $cn = new Connect();
        $cn->SetSQL($sql);
        $cn->AddParam(':menu_item_id', $this->menu_item_id);

        $ds = $cn->Select();
        $this->menu_item_id = 0;
        if ($cn->num_rows > 0) {
            $this->Set($ds[0]);
        }
    }



    function Set($dr)
    {
        $this->menu_item_id = $dr['menu_item_id'];
        $this->menu_item_name = $dr['menu_item_name'];
        $this->menu_id = $dr['menu_id'];
        $this->parent_id = $dr['parent_id'];
        $this->page_id = $dr['page_id'];
        $this->target = $dr['target'];
        $this->menu_item_rank = $dr['menu_item_rank'];
        $this->last_updated = $dr['last_updated'];
        $this->other_url = $dr['other_url'];
    }

    function Insert()
    {
        $sql = "INSERT INTO ez_menu_items (menu_item_name, menu_id, parent_id, page_id, target, menu_item_rank, last_updated, other_url)  VALUES ( :menu_item_name, :menu_id, :parent_id, :page_id, :target, :menu_item_rank, :last_updated, :other_url) ";
        $cn = new Connect();
        $cn->SetSQL($sql);
        $cn->AddParam(':menu_item_name', $this->menu_item_name);
        $cn->AddParam(':menu_id', $this->menu_id);
        $cn->AddParam(':parent_id', $this->parent_id);
        $cn->AddParam(':page_id', $this->page_id);
        $cn->AddParam(':target', $this->target);
        $cn->AddParam(':menu_item_rank', $this->menu_item_rank);
        $cn->AddParam(':last_updated', $this->last_updated);
        $cn->AddParam(':other_url', $this->other_url);

        $this->menu_item_id = $cn->Insert();
        return $this->menu_item_id;
    }

    function Update()
    {
        $sql = "UPDATE ez_menu_items SET menu_item_name = :menu_item_name, menu_id = :menu_id, parent_id = :parent_id, page_id = :page_id, target = :target, menu_item_rank = :menu_item_rank, last_updated = :last_updated, other_url = :other_url WHERE menu_item_id = :menu_item_id";
        $cn = new Connect();
        $cn->SetSQL($sql);
        $cn->AddParam(':menu_item_name', $this->menu_item_name);
        $cn->AddParam(':menu_id', $this->menu_id);
        $cn->AddParam(':parent_id', $this->parent_id);
        $cn->AddParam(':page_id', $this->page_id);
        $cn->AddParam(':target', $this->target);
        $cn->AddParam(':menu_item_rank', $this->menu_item_rank);
        $cn->AddParam(':last_updated', $this->last_updated);
        $cn->AddParam(':other_url', $this->other_url);
        $cn->AddParam(':menu_item_id', $this->menu_item_id);

        return $cn->Update();
    }

    function Delete()
    {
        $sql = "DELETE FROM ez_menu_items WHERE menu_item_id = :menu_item_id";
        $cn = new Connect();
        $cn->SetSQL($sql);
        $cn->AddParam(':menu_item_id', $this->menu_item_id);

        return $cn->Delete();
    }
}
