<?php
/**
 * Created by PhpStorm.
 * User: okesolaa
 * Date: 12/26/14
 * Time: 8:42 PM
 */

namespace com\ddocc\base\entity;
use com\ddocc\base\utility\Connect;

class DiallingCode
{
    var $DialcodeId;
    var $DialcodeVal;
    var $Statusflag;
    var $DateAdded;
    var $LastUpdated;

    function __construct($id)
    {
        $this->DialcodeId = $id;
        $this->Load();
    }

    function Load()
    {
        $sql = "SELECT dialcode_id, dialcode_val, statusflag, date_added, last_updated FROM tbl_dialcodes WHERE dialcode_id = :dialcode_id";
        $cn = new Connect();
        $cn->SetSQL($sql);
        $cn->AddParam(':dialcode_id', $this->DialcodeId);

        $ds = $cn->Select();
        $this->DialcodeId = 0;
        if($cn->num_rows > 0)
        {
            $this->Set($ds[0]);
        }
    }

    function Set($dr)
    {
        $this->DialcodeId = $dr['dialcode_id'];
        $this->DialcodeVal = $dr['dialcode_val'];
        $this->Statusflag = $dr['statusflag'];
        $this->DateAdded = $dr['date_added'];
        $this->LastUpdated = $dr['last_updated'];
    }

    function Insert()
    {
        $sql = "INSERT INTO tbl_dialcodes (dialcode_val, statusflag, date_added, last_updated)  VALUES ( :dialcode_val, :statusflag, :date_added, :last_updated) ";
        $cn = new Connect();
        $cn->SetSQL($sql);
        $cn->AddParam(':dialcode_val', $this->DialcodeVal);
        $cn->AddParam(':statusflag', $this->Statusflag);
        $cn->AddParam(':date_added', $this->DateAdded);
        $cn->AddParam(':last_updated', $this->LastUpdated);
        $cn->AddParam(':dialcode_id', $this->DialcodeId);

        $this->DialcodeId = $cn->Insert();
    }

    function Update()
    {
        $sql = "UPDATE tbl_dialcodes SET dialcode_val = :dialcode_val, statusflag = :statusflag, date_added = :date_added, last_updated = :last_updated WHERE dialcode_id = :dialcode_id";
        $cn = new Connect();
        $cn->SetSQL($sql);
        $cn->AddParam(':dialcode_val', $this->DialcodeVal);
        $cn->AddParam(':statusflag', $this->Statusflag);
        $cn->AddParam(':date_added', $this->DateAdded);
        $cn->AddParam(':last_updated', $this->LastUpdated);
        $cn->AddParam(':dialcode_id', $this->DialcodeId);

        return $cn->Update();
    }

    function Delete()
    {
        $sql = "DELETE FROM tbl_dialcodes WHERE dialcode_id = :dialcode_id";
        $cn = new Connect();
        $cn->SetSQL($sql);
        $cn->AddParam(':dialcode_id', $this->DialcodeId);

        return $cn->Delete();
    }
}
