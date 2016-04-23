<?php
namespace com\ddocc\cms\service;
use com\ddocc\base\utility\Connect;
use com\ddocc\base\utility\InfoBox;
Class CmsMenuService
{
    public static function AllMenus()
    {
        $sql = "SELECT *  FROM ez_menus order by menu_name ";
        $conn = new Connect();
        $conn->SetSQL($sql);
            return $conn->SelectObject();
    }

    public static function PostItemEdit($p)
    {
        //validate
        $msg = '';
        if($p->menu_item_name == '') $msg .= '<li>menu item name cannot be empty</li>';

        if($msg != '')
        {
            return new InfoBox(false,'<ul>' .$msg . '</ul>');
        }

        $cnt = $p->Update();
        if($cnt > 0) {
            return new InfoBox(true,'menu item has been updated');
        }
        else{
            return new InfoBox(false,'menu item could not be updated');
        }
        return new InfoBox('','');
    }

    public static function PostEdit($p)
    {
        //validate
        $msg = '';
        if($p->menu_name == '') $msg .= '<li>Menu name cannot be empty</li>';

        if($msg != '')
        {
            return new InfoBox(false,'<ul>' .$msg . '</ul>');
        }

        $cnt = $p->Update();
        if($cnt > 0) {
            return new InfoBox(true,'Menu has been updated');
        }
        else{
            return new InfoBox(false,'Menu could not be updated');
        }
        return new InfoBox('','');
    }

    public static function PostItemCreate($p)
    {

        $msg = '';
        if($p->menu_item_name == '') $msg .= '<li>MenuItem name cannot be empty</li>';
        if($msg != '')
        {
            return new InfoBox(false,'<ul>' .$msg . '</ul>');
        }

        $cnt = $p->Insert();
        if($cnt > 0) {
            return new InfoBox(true,'Menu Item has been created');
        }
        else{
            return new InfoBox(false,'Menu Item could not be created');
        }
        return new InfoBox('','');
    }

    public static function PostCreate($p)
    {
        $msg = '';
        if($p->menu_name == '') $msg .= '<li>Menu name cannot be empty</li>';
        if($msg != '')
        {
            return new InfoBox(false,'<ul>' .$msg . '</ul>');
        }
        //check if one exist
        $xp = new CmsMenu();
        $xp->menu_name = Gizmo::RemoveSpaces($p->menu_name);
        $xp->LoadByName();
        if($xp->menu_id > 0){
            return new InfoBox(false,'Menu name already exists');
        }

        $cnt = $p->Insert();
        if($cnt > 0) {
            return new InfoBox(true,'Menu has been created');
        }
        else{
            return new InfoBox(false,'Menu could not be created');
        }
        return new InfoBox('','');
    }

    public static function GetMenuItemsByMenu($menu_id,$parent_id = 0)
    {
        $sql = "SELECT i.menu_item_id, i.menu_item_name, i.target, i.page_id, ";
        $sql .= " i.menu_id, p.page_name, i.menu_item_rank, i.other_url,i.last_updated,i.parent_id, t.template_name ";
        $sql .= " FROM ez_menu_items i left join ez_pages p  ";
        $sql .= " on i.page_id = p.page_id  ";
        $sql .= " left join ez_templates t on p.template_id = t.template_id ";
        $sql .= " where i.menu_id = :menu_id and i.parent_id = :parent_id  order by i.parent_id,  i.menu_item_rank  ";
        $cn = new Connect();
        $cn->SetSQL($sql);
        $cn->AddParam(':menu_id', $menu_id);
        $cn->AddParam(':parent_id', $parent_id);
        return $cn->SelectObject();
    }

    public static function PaintMenu($menu_id, $css='', $parent_id = 0)
    {
        try
        {
            $ms = CmsMenuService::GetMenuItemsByMenu($menu_id, $parent_id);
            if(!$ms) return "";
            $txt = "<ul class='$css'>\n";
            $subtxt = "";

            foreach($ms as $m)
            {
                $txt .= "<li>";
                $txt .= "<a href='";
                if($m->page_id == 0)
                {
                    $txt .= $m->other_url;
                }
                else
                {
                    //$txt .= SITEURL .$m->template_name. ".php?id=".$m->page_name;
                    //$txt .= SITEURL . "index.php?id=".$m->page_name;
                    $txt .= SITEURL . "".$m->page_name;
                }

                $txt .= "' target='$m->target'>";
                $txt .= "$m->menu_item_name";
                $txt .= "</a>";

                $sms = CmsMenuService::GetMenuItemsByMenu($m->menu_id, $m->menu_item_id);
                if($sms)
                {
                    $txt .= CmsMenuService::PaintMenu($m->menu_id, $m->menu_item_id);
                }

                $txt .= "</li>\n";
            }
            $txt .= "</ul>\n";
            return $txt;
        }
        catch(Exception $e)
        { }

    }

}