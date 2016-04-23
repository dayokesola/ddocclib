<?php
namespace com\ddocc\cms\entity;
use com\ddocc\base\utility\Connect;


class CmsComponent
{
    var $component_id;
    var $component_name;
    var $component_method;
    var $last_updated;
    var $component_code;
    var $file;
    var $code;


    function Load()
    {
        $sql = "SELECT component_id, component_name, component_method, last_updated, component_code FROM ez_components WHERE component_id = :component_id";
        $cn = new Connect();
        $cn->SetSQL($sql);
        $cn->AddParam(':component_id', $this->component_id);

        $ds = $cn->Select();
        $this->component_id = 0;
        if($cn->num_rows > 0)
        {
            $this->Set($ds[0]);
        }
    }

    function LoadByName()
    {
        $sql = "SELECT component_id, component_name, component_method, last_updated, component_code FROM ez_components
        WHERE component_name = :component_name";
        $cn = new Connect();
        $cn->SetSQL($sql);
        $cn->AddParam(':component_name', $this->component_name);

        $ds = $cn->Select();
        $this->component_id = 0;
        if($cn->num_rows > 0)
        {
            $this->Set($ds[0]);
        }
    }

    function Set($dr)
    {
        $this->component_id = $dr['component_id'];
        $this->component_name = $dr['component_name'];
        $this->component_method = $dr['component_method'];
        $this->last_updated = $dr['last_updated'];
        $this->component_code = $dr['component_code'];
    }

    function Insert()
    {
        $sql = "INSERT INTO ez_components (component_name, component_method, last_updated, component_code)  VALUES ( :component_name, :component_method, :last_updated, :component_code) ";
        $cn = new Connect();
        $cn->SetSQL($sql);
        $cn->AddParam(':component_name', $this->component_name);
        $cn->AddParam(':component_method', $this->component_method);
        $cn->AddParam(':last_updated', $this->last_updated);
        $cn->AddParam(':component_code', $this->component_code);

        $this->component_id = $cn->Insert();
        return $this->component_id;
    }

    function Update()
    {
        $sql = "UPDATE ez_components SET component_name = :component_name, component_method = :component_method, last_updated = :last_updated, component_code = :component_code WHERE component_id = :component_id";
        $cn = new Connect();
        $cn->SetSQL($sql);
        $cn->AddParam(':component_name', $this->component_name);
        $cn->AddParam(':component_method', $this->component_method);
        $cn->AddParam(':last_updated', $this->last_updated);
        $cn->AddParam(':component_code', $this->component_code);
        $cn->AddParam(':component_id', $this->component_id);

        return $cn->Update();
    }

    function Delete()
    {
        $sql = "DELETE FROM ez_components WHERE component_id = :component_id";
        $cn = new Connect();
        $cn->SetSQL($sql);
        $cn->AddParam(':component_id', $this->component_id);

        return $cn->Delete();
    }
}
