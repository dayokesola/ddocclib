<?php
/**
 * Created by PhpStorm.
 * User: okesolaa
 * Date: 2/21/15
 * Time: 7:55 AM
 */

namespace com\ddocc\market\entity;

use com\ddocc\base\utility\Connect;
use com\ddocc\base\utility\Gizmo;



class Category
{
    var $cate_id;
    var $cate_name;
    var $parent_id;
    var $statusflag;
    var $date_added;
    var $last_updated;


    var $cate_logo;

    function CateImage($size = 'm')
    {
        $url = MEDIAURL . 'cate/'. $size . '/';
        $loc = MEDIALOC . 'cate/'. $size . '/';

        $resp = $url . '0.jpg';
        if(Gizmo::FileExists($loc . $this->cate_id . '.jpg'))
        {
            $resp = $url . $this->cate_id . '.jpg?'. Gizmo::Random(10);
        }
        return $resp;
    }



    function LoadByName()
    {
        $sql = "SELECT cate_id, cate_name, parent_id, statusflag, date_added, last_updated FROM tbl_mkt_cates WHERE cate_name = :cate_name";
        $cn = new Connect();
        $cn->SetSQL($sql);
        $cn->AddParam(':cate_name', $this->cate_name);

        $ds = $cn->Select();
        $this->cate_id = 0;
        if($cn->num_rows > 0)
        {
            $this->Set($ds[0]);
        }
    }

    function Load()
    {
        $sql = "SELECT cate_id, cate_name, parent_id, statusflag, date_added, last_updated FROM tbl_mkt_cates WHERE cate_id = :cate_id";
        $cn = new Connect();
        $cn->SetSQL($sql);
        $cn->AddParam(':cate_id', $this->cate_id);

        $ds = $cn->Select();
        $this->cate_id = 0;
        if($cn->num_rows > 0)
        {
            $this->Set($ds[0]);
        }
    }

    function Set($dr)
    {
        $this->cate_id = $dr['cate_id'];
        $this->cate_name = $dr['cate_name'];
        $this->parent_id = $dr['parent_id'];
        $this->statusflag = $dr['statusflag'];
        $this->date_added = $dr['date_added'];
        $this->last_updated = $dr['last_updated'];
    }

    function Insert()
    {
        $sql = "INSERT INTO tbl_mkt_cates (cate_name, parent_id, statusflag, date_added, last_updated)  VALUES ( :cate_name, :parent_id, :statusflag, :date_added, :last_updated) ";
        $cn = new Connect();
        $cn->SetSQL($sql);
        $cn->AddParam(':cate_name', $this->cate_name);
        $cn->AddParam(':parent_id', $this->parent_id);
        $cn->AddParam(':statusflag', $this->statusflag);
        $cn->AddParam(':date_added', $this->date_added);
        $cn->AddParam(':last_updated', $this->last_updated);
        $this->cate_id = $cn->Insert();
    }

    function Update()
    {
        $sql = "UPDATE tbl_mkt_cates SET cate_name = :cate_name, parent_id = :parent_id, statusflag = :statusflag, date_added = :date_added, last_updated = :last_updated WHERE cate_id = :cate_id";
        $cn = new Connect();
        $cn->SetSQL($sql);
        $cn->AddParam(':cate_name', $this->cate_name);
        $cn->AddParam(':parent_id', $this->parent_id);
        $cn->AddParam(':statusflag', $this->statusflag);
        $cn->AddParam(':date_added', $this->date_added);
        $cn->AddParam(':last_updated', $this->last_updated);
        $cn->AddParam(':cate_id', $this->cate_id);

        return $cn->Update();
    }

    function Delete()
    {
        $sql = "DELETE FROM tbl_mkt_cates WHERE cate_id = :cate_id";
        $cn = new Connect();
        $cn->SetSQL($sql);
        $cn->AddParam(':cate_id', $this->cate_id);
        return $cn->Delete();
    }
}
