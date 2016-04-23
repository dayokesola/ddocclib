<?php
namespace com\ddocc\cms\entity;
use com\ddocc\base\utility\Connect;
class CmsTemplate
{
    var $template_id;
    var $template_name;
    var $template_html;
    var $last_updated;


    function Load()
    {
        $sql = "SELECT template_id, template_name, template_html, last_updated FROM ez_templates WHERE template_id = :template_id";
        $cn = new Connect();
        $cn->SetSQL($sql);
        $cn->AddParam(':template_id', $this->template_id);

        $ds = $cn->Select();
        $this->template_id = 0;
        if($cn->num_rows > 0)
        {
            $this->Set($ds[0]);
        }
    }


    function LoadByName()
    {
        $sql = "SELECT template_id, template_name, template_html, last_updated FROM ez_templates WHERE template_name = :template_name";
        $cn = new Connect();
        $cn->SetSQL($sql);
        $cn->AddParam(':template_name', $this->template_name);

        $ds = $cn->Select();
        $this->template_id = 0;
        if($cn->num_rows > 0)
        {
            $this->Set($ds[0]);
        }
    }

    function Set($dr)
    {
        $this->template_id = $dr['template_id'];
        $this->template_name = $dr['template_name'];
        $this->template_html = $dr['template_html'];
        $this->last_updated = $dr['last_updated'];
    }

    function Insert()
    {
        $sql = "INSERT INTO ez_templates (template_name, template_html, last_updated)
        VALUES ( :template_name, :template_html, :last_updated) ";
        $cn = new Connect();
        $cn->SetSQL($sql);
        $cn->AddParam(':template_name', $this->template_name);
        $cn->AddParam(':template_html', $this->template_html);
        $cn->AddParam(':last_updated', $this->last_updated);

        $this->template_id = $cn->Insert();
        return $this->template_id;
    }

    function Update()
    {
        $sql = "UPDATE ez_templates SET template_name = :template_name, template_html = :template_html, last_updated = :last_updated WHERE template_id = :template_id";
        $cn = new Connect();
        $cn->SetSQL($sql);
        $cn->AddParam(':template_name', $this->template_name);
        $cn->AddParam(':template_html', $this->template_html);
        $cn->AddParam(':last_updated', $this->last_updated);
        $cn->AddParam(':template_id', $this->template_id);

        return $cn->Update();
    }

    function Delete()
    {
        $sql = "DELETE FROM ez_templates WHERE template_id = :template_id";
        $cn = new Connect();
        $cn->SetSQL($sql);
        $cn->AddParam(':template_id', $this->template_id);

        return $cn->Delete();
    }
}
