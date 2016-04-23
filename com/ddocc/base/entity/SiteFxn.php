<?php
namespace com\ddocc\base\entity;
use com\ddocc\base\utility\Connect;
class SiteFxn extends EntityBase
{
    var $fxn_id;
    var $fxn_name;
    var $fxn_group;
    var $fxn_sort;
    var $fxn_url;
    var $fxn_flag;
    var $fxn_secure;
    var $fxn_icon;
    var $last_updated;


    function Load()
    {
        $sql = "SELECT fxn_id, fxn_name, fxn_group, fxn_sort, fxn_url, fxn_flag,"
                . " fxn_secure, fxn_icon, last_updated FROM __DB__fxns WHERE fxn_id = :fxn_id";
        $cn = new Connect();
        $cn->SetSQL($sql);
        $cn->AddParam(':fxn_id', $this->fxn_id);

        $ds = $cn->Select();
        $this->fxn_id = 0;
        if($cn->num_rows > 0)
        {
            $this->Set($ds[0]);
        }
    }

    function LoadByUrl()
    {
        $sql = "SELECT fxn_id, fxn_name, fxn_group, fxn_sort, fxn_url, fxn_flag, fxn_secure, fxn_icon, last_updated
        FROM __DB__fxns WHERE fxn_url = :fxn_url";
        $cn = new Connect();
        $cn->SetSQL($sql);
        $cn->AddParam(':fxn_url', $this->fxn_url);
        $ds = $cn->Select();
        $this->fxn_id = 0;
        if($cn->num_rows > 0)
        {
            $this->Set($ds[0]);
        }
    }

    function Set($dr)
    {
        $this->fxn_id = $dr['fxn_id'];
        $this->fxn_name = $dr['fxn_name'];
        $this->fxn_group = $dr['fxn_group'];
        $this->fxn_sort = $dr['fxn_sort'];
        $this->fxn_url = $dr['fxn_url'];
        $this->fxn_flag = $dr['fxn_flag'];
        $this->fxn_secure = $dr['fxn_secure'];
        $this->fxn_icon = $dr['fxn_icon'];
        $this->last_updated = $dr['last_updated'];
    }

    function Insert()
    { 
        $sql = "INSERT INTO __DB__fxns (fxn_name, fxn_group, fxn_sort, fxn_url, fxn_flag, fxn_secure, fxn_icon, last_updated)  VALUES ( :fxn_name, :fxn_group, :fxn_sort, :fxn_url, :fxn_flag, :fxn_secure, :fxn_icon, :last_updated) ";
        $cn = new Connect();
        $cn->SetSQL($sql);
        $cn->AddParam(':fxn_name', $this->fxn_name);
        $cn->AddParam(':fxn_group', $this->fxn_group);
        $cn->AddParam(':fxn_sort', $this->fxn_sort);
        $cn->AddParam(':fxn_url', $this->fxn_url);
        $cn->AddParam(':fxn_flag', $this->fxn_flag);
        $cn->AddParam(':fxn_secure', $this->fxn_secure);
        $cn->AddParam(':fxn_icon', $this->fxn_icon);
        $cn->AddParam(':last_updated', $this->last_updated);

        $this->fxn_id = $cn->Insert();
        return $this->fxn_id;
    }

    function Update()
    {
        $sql = "UPDATE __DB__fxns SET fxn_name = :fxn_name, fxn_group = :fxn_group, fxn_sort = :fxn_sort, fxn_url = :fxn_url, fxn_flag = :fxn_flag, fxn_secure = :fxn_secure, fxn_icon = :fxn_icon, last_updated = :last_updated WHERE fxn_id = :fxn_id";
        $cn = new Connect();
        $cn->SetSQL($sql);
        $cn->AddParam(':fxn_name', $this->fxn_name);
        $cn->AddParam(':fxn_group', $this->fxn_group);
        $cn->AddParam(':fxn_sort', $this->fxn_sort);
        $cn->AddParam(':fxn_url', $this->fxn_url);
        $cn->AddParam(':fxn_flag', $this->fxn_flag);
        $cn->AddParam(':fxn_secure', $this->fxn_secure);
        $cn->AddParam(':fxn_icon', $this->fxn_icon);
        $cn->AddParam(':last_updated', $this->last_updated);
        $cn->AddParam(':fxn_id', $this->fxn_id);

        return $cn->Update();
    }

    function Delete()
    {
        $sql = "DELETE FROM __DB__fxns WHERE fxn_id = :fxn_id";
        $cn = new Connect();
        $cn->SetSQL($sql);
        $cn->AddParam(':fxn_id', $this->fxn_id);

        return $cn->Delete();
    }

    function BelongsTo($rid)
    {
        $sql = "SELECT fxn_id, role_id  "
            . "FROM __DB__role_fxns WHERE fxn_id = :fxn_id and role_id = :role_id";
        $cn = new Connect();
        $cn->SetSQL($sql);
        $cn->AddParam('fxn_id', $this->fxn_id);
        $cn->AddParam('role_id', $rid);
        $cn->Select();
        if($cn->num_rows > 0) return TRUE;
        else            return FALSE;
    }
}
