<?php
namespace com\ddocc\cms\entity;
use com\ddocc\base\utility\Connect;

class CmsPage
{
    var $page_id;
    var $page_name;
    var $page_title;
    var $template_id;
    var $article_id;
    var $last_updated;


    function Load()
    {
        $sql = "SELECT page_id, page_name, page_title, template_id, article_id, last_updated FROM ez_pages WHERE page_id = :page_id";
        $cn = new Connect();
        $cn->SetSQL($sql);
        $cn->AddParam(':page_id', $this->page_id);

        $ds = $cn->Select();
        $this->page_id = 0;
        if($cn->num_rows > 0)
        {
            $this->Set($ds[0]);
        }
    }

    function LoadByName()
    {
        $sql = "SELECT page_id, page_name, page_title, template_id, article_id, last_updated FROM ez_pages WHERE page_name = :page_name";
        $cn = new Connect();
        $cn->SetSQL($sql);
        $cn->AddParam(':page_name', $this->page_name);

        $ds = $cn->Select();
        $this->page_id = 0;
        if($cn->num_rows > 0)
        {
            $this->Set($ds[0]);
        }
    }

    function Set($dr)
    {
        $this->page_id = $dr['page_id'];
        $this->page_name = $dr['page_name'];
        $this->page_title = $dr['page_title'];
        $this->template_id = $dr['template_id'];
        $this->article_id = $dr['article_id'];
        $this->last_updated = $dr['last_updated'];
    }

    function Insert()
    {
        $sql = "INSERT INTO ez_pages (page_name, page_title, template_id, article_id, last_updated)  VALUES ( :page_name, :page_title, :template_id, :article_id, :last_updated) ";
        $cn = new Connect();
        $cn->SetSQL($sql);
        $cn->AddParam(':page_name', $this->page_name);
        $cn->AddParam(':page_title', $this->page_title);
        $cn->AddParam(':template_id', $this->template_id);
        $cn->AddParam(':article_id', $this->article_id);
        $cn->AddParam(':last_updated', $this->last_updated);

        $this->page_id = $cn->Insert();
        return $this->page_id;
    }

    function Update()
    {
        $sql = "UPDATE ez_pages SET page_name = :page_name, page_title = :page_title, template_id = :template_id, article_id = :article_id, last_updated = :last_updated WHERE page_id = :page_id";
        $cn = new Connect();
        $cn->SetSQL($sql);
        $cn->AddParam(':page_name', $this->page_name);
        $cn->AddParam(':page_title', $this->page_title);
        $cn->AddParam(':template_id', $this->template_id);
        $cn->AddParam(':article_id', $this->article_id);
        $cn->AddParam(':last_updated', $this->last_updated);
        $cn->AddParam(':page_id', $this->page_id);

        return $cn->Update();
    }

    function Delete()
    {
        $sql = "DELETE FROM ez_pages WHERE page_id = :page_id";
        $cn = new Connect();
        $cn->SetSQL($sql);
        $cn->AddParam(':page_id', $this->page_id);

        return $cn->Delete();
    }
}
