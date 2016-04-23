<?php

namespace com\ddocc\market\entity;
/**
 * Description of Department
 *
 * @author Dayo Okesola - YumYum
 */
use com\ddocc\base\utility\Connect;
use com\ddocc\base\utility\Gizmo;


class Dept
{
    var $dept_id;
    var $dept_name;
    var $statusflag;
    var $date_added;
    var $last_updated;


    var $dept_logo;


    function DeptImage($size = 'm')
    {
        $url = MEDIAURL . 'dept/'. $size . '/';
        $loc = MEDIALOC . 'dept/'. $size . '/';

        $resp = $url . '0.jpg';
        if(Gizmo::FileExists($loc . $this->dept_id . '.jpg'))
        {
            $resp = $url . $this->dept_id . '.jpg?'. Gizmo::Random(10);
        }
        return $resp;
    }

    function __construct($dept_id)
    {
        $this->dept_id = $dept_id;
        $this->Load();
    }

    function Load()
    {
        $sql = "SELECT dept_id, dept_name, statusflag, date_added, last_updated FROM tbl_mkt_depts WHERE dept_id = :dept_id";
        $cn = new Connect();
        $cn->SetSQL($sql);
        $cn->AddParam(':dept_id', $this->dept_id);

        $ds = $cn->Select();
        $this->dept_id = 0;
        if($cn->num_rows > 0)
        {
            $this->Set($ds[0]);
        }
    }



    function LoadByName()
    {
        $sql = "SELECT dept_id, dept_name, statusflag, date_added, last_updated FROM tbl_mkt_depts WHERE dept_name = :dept_name";
        $cn = new Connect();
        $cn->SetSQL($sql);
        $cn->AddParam(':dept_name', $this->dept_name);

        $ds = $cn->Select();
        $this->dept_id = 0;
        if($cn->num_rows > 0)
        {
            $this->Set($ds[0]);
        }
    }

    function Set($dr)
    {
        $this->dept_id = $dr['dept_id'];
        $this->dept_name = $dr['dept_name'];
        $this->statusflag = $dr['statusflag'];
        $this->date_added = $dr['date_added'];
        $this->last_updated = $dr['last_updated'];
    }

    function Insert()
    {
        $sql = "INSERT INTO tbl_mkt_depts (dept_name, statusflag, date_added, last_updated)
        VALUES ( :dept_name, :statusflag, :date_added, :last_updated) ";
        $cn = new Connect();
        $cn->SetSQL($sql);
        $cn->AddParam(':dept_name', $this->dept_name);
        $cn->AddParam(':statusflag', $this->statusflag);
        $cn->AddParam(':date_added', $this->date_added);
        $cn->AddParam(':last_updated', $this->last_updated);

        $this->dept_id = $cn->Insert();
        return $this->dept_id;
    }

    function Update()
    {
        $sql = "UPDATE tbl_mkt_depts SET dept_name = :dept_name, statusflag = :statusflag, date_added = :date_added, last_updated = :last_updated WHERE dept_id = :dept_id";
        $cn = new Connect();
        $cn->SetSQL($sql);
        $cn->AddParam(':dept_name', $this->dept_name);
        $cn->AddParam(':statusflag', $this->statusflag);
        $cn->AddParam(':date_added', $this->date_added);
        $cn->AddParam(':last_updated', $this->last_updated);
        $cn->AddParam(':dept_id', $this->dept_id);

        return $cn->Update();
    }

    function Delete()
    {
        $sql = "DELETE FROM tbl_mkt_depts WHERE dept_id = :dept_id";
        $cn = new Connect();
        $cn->SetSQL($sql);
        $cn->AddParam(':dept_id', $this->dept_id);

        return $cn->Delete();
    }
}
