<?php
namespace com\ddocc\cms\service;

use com\ddocc\base\utility\Connect;
use com\ddocc\base\utility\InfoBox;
class CmsPageService
{
    public static function GetPageByName($page_name)
    {
        $sql = "SELECT p.page_id, p.page_name, p.page_title, p.template_id, ";
        $sql .= "p.article_id,p.last_updated,t.template_name, a.article_content ";
        $sql .= "FROM ez_pages p INNER JOIN ez_templates t ";
        $sql .= "ON p.template_id = t.template_id ";
        $sql .= "INNER JOIN ez_articles a ";
        $sql .= "ON p.article_id = a.article_id ";
        $sql .= "where p.page_name = :page_name";
        $cn = new Connect();
        $cn->SetSQL($sql);
        $cn->AddParam(':page_name', $page_name);
        return $cn->SelectObject();
    }

    public static function AllPages() {
        $sql = "SELECT p.page_id, p.page_name, p.page_title, p.template_id, ";
        $sql .= "p.article_id,p.last_updated,t.template_name, a.article_name ";
        $sql .= "FROM ez_pages p INNER JOIN ez_templates t ";
        $sql .= "ON p.template_id = t.template_id ";
        $sql .= "INNER JOIN ez_articles a ";
        $sql .= "ON p.article_id = a.article_id ";
        $sql .=  " order by p.page_id ";
        $cn = new Connect();
        $cn->SetSQL($sql);
        return $cn->SelectObject();
    }

    public static function PostEdit($p)
    {
        //validate
        $msg = '';
        if($p->page_name == '') $msg .= '<li>page name cannot be empty</li>';
        if($p->page_title == '') $msg .= '<li>page title cannot be empty</li>';
        if($p->article_id <= 0) $msg .= '<li>select article</li>';
        if($p->template_id <= 0) $msg .= '<li>select template</li>';

        if($msg != '')
        {
            return new InfoBox(false,'<ul>' .$msg . '</ul>');
        }

        $cnt = $p->Update();
        if($cnt > 0) {
            return new InfoBox(true,'Page has been updated');
        }
        else{
            return new InfoBox(false,'Page could not be updated');
        }
        return new InfoBox('','');
    }

    public static function PostCreate($p)
    {
        $msg = '';
        if($p->page_name == '') $msg .= '<li>page name cannot be empty</li>';
        if($msg != '')
        {
            return new InfoBox(false,'<ul>' .$msg . '</ul>');
        }
        //check if one exist
        $xp = new CmsPage();
        $xp->page_name = $p->page_name;
        $xp->LoadByName();
        if($xp->page_id > 0){
            return new InfoBox(false,'Page name already exists');
        }

        $cnt = $p->Insert();
        if($cnt > 0) {
            return new InfoBox(true,'Page has been created');
        }
        else{
            return new InfoBox(false,'Page could not be created');
        }
        return new InfoBox('','');
    }

}