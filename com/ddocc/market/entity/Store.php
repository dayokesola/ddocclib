<?php
/**
 * Created by PhpStorm.
 * User: okesolaa
 * Date: 2/5/15
 * Time: 7:01 PM
 */

namespace com\ddocc\market\entity;
use com\ddocc\base\utility\Connect;
use com\ddocc\base\utility\Gizmo;
class Store
{
    var $store_id;
    var $store_name;
    var $store_email;
    var $enabled_tech;
    var $enabled_admin;
    var $enabled_owner;
    var $date_added;
    var $store_alias;
    var $store_memo;
    var $store_logo;
    var $statusflag;
    var $last_updated;

    var $dept_ids;

    function Load()
    {
        $sql = "SELECT store_id, store_name, store_email, enabled_tech, enabled_admin, enabled_owner,
         date_added, store_alias, store_memo, statusflag,last_updated FROM tbl_mkt_stores WHERE store_id = :store_id";
        $cn = new Connect();
        $cn->SetSQL($sql);
        $cn->AddParam(':store_id', $this->store_id);

        $ds = $cn->Select();
        $this->store_id = 0;
        if($cn->num_rows > 0)
        {
            $this->Set($ds[0]);
        }
    }

    function LoadByName()
{
    $sql = "SELECT store_id, store_name, store_email, enabled_tech, enabled_admin,
        enabled_owner, date_added, store_alias, store_memo, statusflag,last_updated FROM tbl_mkt_stores WHERE store_name = :store_name";
    $cn = new Connect();
    $cn->SetSQL($sql);
    $cn->AddParam(':store_name', $this->store_name);

    $ds = $cn->Select();
    $this->store_id = 0;
    if($cn->num_rows > 0)
    {
        $this->Set($ds[0]);
    }
}

    function LoadByAlias()
    {
        $sql = "SELECT store_id, store_name, store_email, enabled_tech, enabled_admin,
        enabled_owner, date_added, store_alias, store_memo, statusflag,last_updated FROM tbl_mkt_stores WHERE store_alias = :store_alias";
        $cn = new Connect();
        $cn->SetSQL($sql);
        $cn->AddParam(':store_alias', $this->store_alias);

        $ds = $cn->Select();
        $this->store_id = 0;
        if($cn->num_rows > 0)
        {
            $this->Set($ds[0]);
        }
    }

    function Set($dr)
    {
        $this->store_id = $dr['store_id'];
        $this->store_name = $dr['store_name'];
        $this->store_email = $dr['store_email'];
        $this->enabled_tech = $dr['enabled_tech'];
        $this->enabled_admin = $dr['enabled_admin'];
        $this->enabled_owner = $dr['enabled_owner'];
        $this->date_added = $dr['date_added'];
        $this->store_alias = $dr['store_alias'];
        $this->store_memo = $dr['store_memo'];
        $this->statusflag = $dr['statusflag'];
        $this->last_updated = $dr['last_updated'];
    }

    function Insert()
    {
        $sql = "INSERT INTO tbl_mkt_stores
        (store_name, store_email, enabled_tech, enabled_admin, enabled_owner, date_added, store_alias, store_memo, statusflag,last_updated)
        VALUES ( :store_name, :store_email, :enabled_tech, :enabled_admin, :enabled_owner, :date_added, :store_alias, :store_memo, :statusflag, :last_updated) ";
        $cn = new Connect();
        $cn->SetSQL($sql);
        $cn->AddParam(':store_name', $this->store_name);
        $cn->AddParam(':store_email', $this->store_email);
        $cn->AddParam(':enabled_tech', $this->enabled_tech);
        $cn->AddParam(':enabled_admin', $this->enabled_admin);
        $cn->AddParam(':enabled_owner', $this->enabled_owner);
        $cn->AddParam(':date_added', $this->date_added);
        $cn->AddParam(':store_alias', $this->store_alias);
        $cn->AddParam(':store_memo', $this->store_memo);
        $cn->AddParam(':statusflag', $this->statusflag);
        $cn->AddParam(':last_updated', $this->last_updated);
        $this->store_id = $cn->Insert();

        return $this->store_id;
    }

    function Update()
    {
        $sql = "UPDATE tbl_mkt_stores SET store_name = :store_name, store_email = :store_email,
        enabled_tech = :enabled_tech, enabled_admin = :enabled_admin, enabled_owner = :enabled_owner,
         date_added = :date_added, store_alias = :store_alias, store_memo = :store_memo, statusflag = :statusflag, last_updated =:last_updated
         WHERE store_id = :store_id";
        $cn = new Connect();
        $cn->SetSQL($sql);
        $cn->AddParam(':store_name', $this->store_name);
        $cn->AddParam(':store_email', $this->store_email);
        $cn->AddParam(':enabled_tech', $this->enabled_tech);
        $cn->AddParam(':enabled_admin', $this->enabled_admin);
        $cn->AddParam(':enabled_owner', $this->enabled_owner);
        $cn->AddParam(':date_added', $this->date_added);
        $cn->AddParam(':store_alias', $this->store_alias);
        $cn->AddParam(':store_memo', $this->store_memo);
        $cn->AddParam(':statusflag', $this->statusflag);
        $cn->AddParam(':last_updated', $this->last_updated);
        $cn->AddParam(':store_id', $this->store_id);

        return $cn->Update();
    }

    function Delete()
    {
        $sql = "DELETE FROM tbl_mkt_stores WHERE store_id = :store_id";
        $cn = new Connect();
        $cn->SetSQL($sql);
        $cn->AddParam(':store_id', $this->store_id);

        return $cn->Delete();
    }

    function StoreImage($size = 'm')
    {
        $url = MEDIAURL . 'store/'. $size . '/';
        $loc = MEDIALOC . 'store/'. $size . '/';

        $resp = $url . '0.jpg';
        if(Gizmo::FileExists($loc . $this->store_id . '.jpg'))
        {
            $resp = $url . $this->store_id . '.jpg?'. Gizmo::Random(10);
        }
        return $resp;
    }
}
