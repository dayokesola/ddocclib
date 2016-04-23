<?php
/**
 * Created by PhpStorm.
 * User: okesolaa
 * Date: 4/1/15
 * Time: 4:49 PM
 */

namespace com\ddocc\servmon\entity;


use com\ddocc\base\utility\Connect;


class Service
{
    var $service_id;
    var $service_name;
    var $service_code;
    var $service_type_id;
    var $date_added;
    var $last_updated;


    function Load()
    {
        $sql = "SELECT service_id, service_name, service_code, service_type_id, date_added, last_updated FROM tbl_services WHERE service_id = :service_id";
        $cn = new Connect();
        $cn->SetSQL($sql);
        $cn->AddParam(':service_id', $this->service_id);

        $ds = $cn->Select();
        $this->service_id = 0;
        if($cn->num_rows > 0)
        {
            $this->Set($ds[0]);
        }
    }

    function Set($dr)
    {
        $this->service_id = $dr['service_id'];
        $this->service_name = $dr['service_name'];
        $this->service_code = $dr['service_code'];
        $this->service_type_id = $dr['service_type_id'];
        $this->date_added = $dr['date_added'];
        $this->last_updated = $dr['last_updated'];
    }

    function Insert()
    {
        $sql = "INSERT INTO tbl_services (service_name, service_code, service_type_id, date_added, last_updated)  VALUES ( :service_name, :service_code, :service_type_id, :date_added, :last_updated) ";
        $cn = new Connect();
        $cn->SetSQL($sql);
        $cn->AddParam(':service_name', $this->service_name);
        $cn->AddParam(':service_code', $this->service_code);
        $cn->AddParam(':service_type_id', $this->service_type_id);
        $cn->AddParam(':date_added', $this->date_added);
        $cn->AddParam(':last_updated', $this->last_updated);
        $cn->AddParam(':service_id', $this->service_id);

        $this->service_id = $cn->Insert();
    }

    function Update()
    {
        $sql = "UPDATE tbl_services SET service_name = :service_name, service_code = :service_code, service_type_id = :service_type_id, date_added = :date_added, last_updated = :last_updated WHERE service_id = :service_id";
        $cn = new Connect();
        $cn->SetSQL($sql);
        $cn->AddParam(':service_name', $this->service_name);
        $cn->AddParam(':service_code', $this->service_code);
        $cn->AddParam(':service_type_id', $this->service_type_id);
        $cn->AddParam(':date_added', $this->date_added);
        $cn->AddParam(':last_updated', $this->last_updated);
        $cn->AddParam(':service_id', $this->service_id);

        return $cn->Update();
    }

    function Delete()
    {
        $sql = "DELETE FROM tbl_services WHERE service_id = :service_id";
        $cn = new Connect();
        $cn->SetSQL($sql);
        $cn->AddParam(':service_id', $this->service_id);

        return $cn->Delete();
    }
}
