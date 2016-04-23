<?php
namespace com\ddocc\cms\entity;
use com\ddocc\base\utility\Connect;
class CmsFormItem
{
    var $column_id;
    var $column_name;
    var $form_id;
    var $data_type_id;
    var $last_updated;
    var $column_null;
    var $default_data;

    var $data_type_name;

    function Load()
    {
        $sql = "SELECT column_id, column_name, form_id, data_type_id, last_updated, column_null, default_data FROM ez_form_columns WHERE column_id = :column_id";
        $cn = new Connect();
        $cn->SetSQL($sql);
        $cn->AddParam(':column_id', $this->column_id);

        $ds = $cn->Select();
        $this->column_id = 0;
        if($cn->num_rows > 0)
        {
            $this->Set($ds[0]);
        }
    }

    function Set($dr)
    {
        $this->column_id = $dr['column_id'];
        $this->column_name = $dr['column_name'];
        $this->column_null = $dr['column_null'];
        $this->form_id = $dr['form_id'];
        $this->data_type_id = $dr['data_type_id'];
        $this->last_updated = $dr['last_updated'];
        $this->default_data = $dr['default_data'];
    }

    function Insert()
    {
        $sql = "INSERT INTO ez_form_columns (column_name, form_id, data_type_id, last_updated, column_null, default_data)  VALUES ( :column_name, :form_id, :data_type_id, :last_updated, :column_null, :default_data) ";
        $cn = new Connect();
        $cn->SetSQL($sql);
        $cn->AddParam(':column_name', $this->column_name);
        $cn->AddParam(':form_id', $this->form_id);
        $cn->AddParam(':data_type_id', $this->data_type_id);
        $cn->AddParam(':last_updated', $this->last_updated);
        $cn->AddParam(':column_null', $this->column_null);
        $cn->AddParam(':default_data', $this->default_data);
        $cn->AddParam(':column_id', $this->column_id);

        $this->column_id = $cn->Insert();
        return $this->column_id;
    }

    function Update()
    {
        $sql = "UPDATE ez_form_columns SET column_name = :column_name, form_id = :form_id, data_type_id = :data_type_id, last_updated = :last_updated, column_null = :column_null, default_data = :default_data WHERE column_id = :column_id";
        $cn = new Connect();
        $cn->SetSQL($sql);
        $cn->AddParam(':column_name', $this->column_name);
        $cn->AddParam(':form_id', $this->form_id);
        $cn->AddParam(':data_type_id', $this->data_type_id);
        $cn->AddParam(':last_updated', $this->last_updated);
        $cn->AddParam(':column_null', $this->column_null);
        $cn->AddParam(':default_data', $this->default_data);
        $cn->AddParam(':column_id', $this->column_id);

        return $cn->Update();
    }

    function Delete()
    {
        $sql = "DELETE FROM ez_form_columns WHERE column_id = :column_id";
        $cn = new Connect();
        $cn->SetSQL($sql);
        $cn->AddParam(':column_id', $this->column_id);

        return $cn->Delete();
    }
}
