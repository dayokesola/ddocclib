<?php
namespace com\ddocc\cms\service;

use com\ddocc\base\utility\Connect;
use com\ddocc\base\utility\InfoBox;

Class CmsArticleService
{
    public static function AllArticles()
    {
        $sql = 'SELECT * FROM ez_articles';
        $cn = new Connect();
        $cn->SetSQL($sql);
        return $cn->SelectObject();
    }

    public static function GetArticleTypes()
    {
        $sql = "SELECT * FROM ez_article_types order by article_type_name";
        $cn = new Connect();
        $cn->SetSQL($sql);
        return $cn->Select();
    }

    public static function GetArticlesByType($article_type_id)
    {
        $sql = "SELECT * FROM ez_articles ";
        $sql .= "where article_type_id = :article_type_id order by article_name   ";
        $cn = new Connect();
        $cn->SetSQL($sql);
        $cn->AddParam(':article_type_id', $article_type_id);
        return $cn->SelectObject();
    }


    public static function PostCreate($p)
    {
        $msg = '';
        if($p->article_name == '') $msg .= '<li>Article name cannot be empty</li>';
        if($msg != '')
        {
            return new InfoBox(false,'<ul>' .$msg . '</ul>');
        }
        //check if one exist
        $xp = new CmsArticle();
        $xp->article_name = $p->article_name;
        $xp->LoadByName();
        if($xp->article_id > 0){
            return new InfoBox(false,'Article name already exists');
        }

        $cnt = $p->Insert();
        if($cnt > 0) {
            return new InfoBox(true,'Article has been created');
        }
        else{
            return new InfoBox(false,'Article could not be created');
        }
        return new InfoBox('','');
    }

    public static function PostEdit($p)
    {
        //validate
        $msg = '';
        if($p->article_name == '') $msg .= '<li>Article name cannot be empty</li>';
        if($p->article_content == '') $msg .= '<li>Article content cannot be empty</li>';
        if($p->article_tags == '') $msg .= '<li>Article tags cannot be empty</li>';

        if($msg != '')
        {
            return new InfoBox(false,'<ul>' .$msg . '</ul>');
        }

        $cnt = $p->Update();
        if($cnt > 0) {
            return new InfoBox(true,'Article has been updated');
        }
        else{
            return new InfoBox(false,'Article could not be updated');
        }
        return new InfoBox('','');
    }
}