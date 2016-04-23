<?php
namespace com\ddocc\base\entity;
use com\ddocc\base\utility\Connect;
/**
 * Created by PhpStorm.
 * User: okesolaa
 * Date: 12/26/14
 * Time: 8:30 PM
 */
class SiteUserReg
{
    var $reg_id;
    var $email;
    var $country_code_id;
    var $mobile;
    var $otp;
    var $location_id;
    var $date_added;
    var $last_updated;
    var $fname;
    var $lname;
    var $pwd;
    var $pwd1;
    var $salt;

    function Load()
    {
        $sql = "SELECT reg_id, email, country_code_id, mobile, otp, location_id, date_added, last_updated, fname, lname, pwd, salt
FROM tbl_users_reg WHERE reg_id = :reg_id";
        $cn = new Connect();
        $cn->SetSQL($sql);
        $cn->AddParam(':reg_id', $this->reg_id);
        $ds = $cn->Select();
        $this->reg_id = 0;
        if($cn->num_rows > 0)
        {
            $this->Set($ds[0]);
        }
    }

    function LoadByCode()
    {
        $sql = "SELECT reg_id, email, country_code_id, mobile, otp, location_id, date_added, last_updated, fname, lname, pwd, salt
        FROM tbl_users_reg WHERE email = :email and otp = :otp";
        $cn = new Connect();
        $cn->SetSQL($sql);
        $cn->AddParam(':email', $this->Email);
        $cn->AddParam(':otp', $this->Otp);
        $ds = $cn->Select();
        $this->RegId = 0;
        if($cn->num_rows > 0)
        {
            $this->Set($ds[0]);
        }
    }

    function Set($dr)
    {
        $this->reg_id = $dr['reg_id'];
        $this->email = $dr['email'];
        $this->country_code_id = $dr['country_code_id'];
        $this->mobile = $dr['mobile'];
        $this->otp = $dr['otp'];
        $this->location_id = $dr['location_id'];
        $this->date_added = $dr['date_added'];
        $this->last_updated = $dr['last_updated'];
        $this->fname = $dr['fname'];
        $this->lname = $dr['lname'];
        $this->pwd = $dr['pwd'];
        $this->salt = $dr['salt'];
    }

    function Insert()
    {
        $sql = "INSERT INTO tbl_users_reg
(email, country_code_id, mobile, otp, location_id, date_added, last_updated, fname, lname, pwd, salt)
VALUES ( :email, :country_code_id, :mobile, :otp, :location_id, :date_added, :last_updated, :fname, :lname, :pwd, :salt) ";
        $cn = new Connect();
        $cn->SetSQL($sql);
        $cn->AddParam(':email', $this->email);
        $cn->AddParam(':country_code_id', $this->country_code_id);
        $cn->AddParam(':mobile', $this->mobile);
        $cn->AddParam(':otp', $this->otp);
        $cn->AddParam(':location_id', $this->location_id);
        $cn->AddParam(':date_added', $this->date_added);
        $cn->AddParam(':last_updated', $this->last_updated);
        $cn->AddParam(':fname', $this->fname);
        $cn->AddParam(':lname', $this->lname);
        $cn->AddParam(':pwd', $this->pwd);
        $cn->AddParam(':salt', $this->salt);
        $this->reg_id = $cn->Insert();
        return $this->reg_id;
    }

    function Update()
    {
        $sql = "UPDATE tbl_users_reg SET email = :email, country_code_id = :country_code_id, mobile = :mobile, otp = :otp,
location_id = :location_id, date_added = :date_added, last_updated = :last_updated, fname = :fname, lname = :lname, pwd= :pwd, salt = :salt
WHERE reg_id = :reg_id";
        $cn = new Connect();
        $cn->SetSQL($sql);
        $cn->AddParam(':email', $this->email);
        $cn->AddParam(':country_code_id', $this->country_code_id);
        $cn->AddParam(':mobile', $this->mobile);
        $cn->AddParam(':otp', $this->otp);
        $cn->AddParam(':location_id', $this->location_id);
        $cn->AddParam(':date_added', $this->date_added);
        $cn->AddParam(':last_updated', $this->last_updated);
        $cn->AddParam(':fname', $this->fname);
        $cn->AddParam(':lname', $this->lname);
        $cn->AddParam(':pwd', $this->pwd);
        $cn->AddParam(':salt', $this->salt);
        $cn->AddParam(':reg_id', $this->reg_id);

        return $cn->Update();
    }

    function Delete()
    {
        $sql = "DELETE FROM tbl_users_reg WHERE reg_id = :reg_id";
        $cn = new Connect();
        $cn->SetSQL($sql);
        $cn->AddParam(':reg_id', $this->reg_id);

        return $cn->Delete();
    }
}
