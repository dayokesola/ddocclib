<?php
namespace com\ddocc\cms\entity;
use com\ddocc\base\utility\Connect;
Class CmsForm
{
    var $form_id;
    var $form_name;
    var $form_html;
    var $form_display;
    var $last_updated;

    function Set($row)
    {
        $this->form_id = $row['form_id'];
        $this->form_name = $row['form_name'];
        $this->form_html = $row['form_html'];
        $this->form_display = str_replace('<text','<textarea',$this->form_html);
        $this->form_display = str_replace('</text>','</textarea>',$this->form_display);
        $this->last_updated = $row['last_updated'];
    }
    function Load()
    {
        $sql = "SELECT form_id, form_name, last_updated, form_html FROM ez_forms WHERE form_id = :form_id";
        $cn = new Connect();
        $cn->SetSQL($sql);
        $cn->AddParam(':form_id', $this->form_id);

        $ds = $cn->Select();
        $this->form_id = 0;
        if($cn->num_rows > 0)
        {
            $this->Set($ds[0]);
        }
    }

    function Insert()
    {
        $sql = "INSERT INTO ez_forms (form_name, last_updated, form_html)  VALUES ( :form_name, :last_updated, :form_html) ";
        $cn = new Connect();
        $cn->SetSQL($sql);
        $cn->AddParam(':form_name', $this->form_name);
        $cn->AddParam(':last_updated', $this->last_updated);
        $cn->AddParam(':form_html', $this->form_html);

        $this->form_id = $cn->Insert();
        return $this->form_id;
    }

    function Update()
    {
        $sql = "UPDATE ez_forms SET form_name = :form_name, last_updated = :last_updated, form_html = :form_html WHERE form_id = :form_id";
        $cn = new Connect();
        $cn->SetSQL($sql);
        $cn->AddParam(':form_name', $this->form_name);
        $cn->AddParam(':last_updated', $this->last_updated);
        $cn->AddParam(':form_html', $this->form_html);
        $cn->AddParam(':form_id', $this->form_id);

        return $cn->Update();
    }

    function Delete()
    {
        $sql = "DELETE FROM ez_forms WHERE form_id = :form_id";
        $cn = new Connect();
        $cn->SetSQL($sql);
        $cn->AddParam(':form_id', $this->form_id);

        return $cn->Delete();
    }
}
