<?php

namespace com\ddocc\base\service;

use com\ddocc\base\entity\DiallingCode;
use com\ddocc\base\entity\SiteUser;
use com\ddocc\base\dto\SiteUserDTO;
use com\ddocc\base\entity\SiteUserReg;
use com\ddocc\base\entity\Token;
use com\ddocc\base\utility\ErrorLog;
use com\ddocc\base\utility\Gizmo;
use com\ddocc\base\utility\Connect;
use com\ddocc\base\utility\Session;
use com\ddocc\base\utility\Mailer;
use com\ddocc\ddlite\data\iBase;
use com\ddocc\base\entity\Profile;

class SiteUserService {

    public static function GetUserByUsername($username) {
        $sql = "SELECT user_id, auth_email, auth_phrase, auth_spice, role_id, 
            statusflag, date_added, last_updated, last_reset, fname,lname,auth_code,mobile
        FROM __DB__users WHERE auth_email = :auth_email";
        $cn = new Connect();
        $cn->SetSQL($sql);
        $cn->AddParam(':auth_email', $username);
        $su = new SiteUser();
        $ds = $cn->Select();
        $su->user_id = 0;
        if ($cn->num_rows > 0) {
            $su->Set($ds[0]);
        }
        return $su;
    }
    
    public static function GetUserByUsernameDTO($username) {
        $sql = "SELECT user_id, auth_email as email,   role_id, 
            statusflag, date_added, last_updated, last_reset, fname,lname,mobile
        FROM __DB__users WHERE auth_email = :auth_email";
        $cn = new Connect();
        $cn->SetSQL($sql);
        $cn->AddParam(':auth_email', $username);
        $su = new SiteUserDTO();
        $ds = $cn->Select();
        $su->user_id = 0;
        if ($cn->num_rows > 0) {
            $su->Set($ds[0]);
        }
        return $su;
    }

    public static function Insert($item) {
        $sql = "INSERT INTO halo_users (auth_email, auth_phrase, auth_spice, role_id, statusflag, date_added, "
                . "last_updated, last_reset, fname, lname, auth_code, mobile)  "
                . "VALUES ( :auth_email, :auth_phrase, :auth_spice, :role_id, :statusflag, :date_added, "
                . ":last_updated, :last_reset, :fname, :lname, :auth_code, :mobile) ";
        $cn = new Connect();
        $cn->SetSQL($sql);
        $cn->AddParam(':auth_email', $item->auth_email);
        $cn->AddParam(':auth_phrase', $item->auth_phrase);
        $cn->AddParam(':auth_spice', $item->auth_spice);
        $cn->AddParam(':role_id', $item->role_id);
        $cn->AddParam(':statusflag', $item->statusflag);
        $cn->AddParam(':date_added', $item->date_added);
        $cn->AddParam(':last_updated', $item->last_updated);
        $cn->AddParam(':last_reset', $item->last_reset);
        $cn->AddParam(':fname', $item->fname);
        $cn->AddParam(':lname', $item->lname);
        $cn->AddParam(':auth_code', $item->auth_code);
        $cn->AddParam(':mobile', $item->mobile);
        $item->user_id = $cn->Insert();
        return $item->user_id;
    }

    public static function Update($item) {
        $sql = "UPDATE __DB__users SET auth_email = :auth_email, auth_phrase = :auth_phrase, "
                . "auth_spice = :auth_spice, role_id = :role_id, statusflag = :statusflag, "
                . "date_added = :date_added, last_updated = :last_updated, last_reset = :last_reset, "
                . "fname = :fname, lname = :lname, auth_code = :auth_code,mobile = :mobile WHERE user_id = :user_id";
        $cn = new Connect();
        $cn->SetSQL($sql);
        $cn->AddParam(':auth_email', $item->auth_email);
        $cn->AddParam(':auth_phrase', $item->auth_phrase);
        $cn->AddParam(':auth_spice', $item->auth_spice);
        $cn->AddParam(':role_id', $item->role_id);
        $cn->AddParam(':statusflag', $item->statusflag);
        $cn->AddParam(':date_added', $item->date_added);
        $cn->AddParam(':last_updated', $item->last_updated);
        $cn->AddParam(':last_reset', $item->last_reset);
        $cn->AddParam(':fname', $item->fname);
        $cn->AddParam(':lname', $item->lname);
        $cn->AddParam(':auth_code', $item->auth_code);
        $cn->AddParam(':mobile', $item->mobile);
        $cn->AddParam(':user_id', $item->user_id);
        return $cn->Update();
    }    

    public static function InsertProfileInfo($su) {
        $sql = "insert into __DB__profiles (user_id, profile_type_id) " .
                " select :id, tab_ent from __DB__text where tab_id = 15 " .
                " and tab_ent not in (select profile_type_id from __DB__profiles where user_id = :id)";
        $cn = new Connect();
        $cn->SetSQL($sql);
        $cn->AddParam('id', $su->user_id);
        $cn->Update();
    }

    public static function GetProfileInfo($su, $filter = '') {
        SiteUserService::InsertProfileInfo($su);
        $cn = new Connect();
        $sql = "select   t15.tab_ent as id,t15.tab_text as profile_slug,t15.var1 as profile_group,t15.var3 as data_type,"
                . "t15.var2 as profile_name, p.profile_type_value as profile_value from " .
                " __DB__text t15 left join __DB__profiles p on t15.tab_id = 15 and t15.tab_ent = p.profile_type_id " .
                " where  p.user_id = :userid ";
        if ($filter != "") {
            $sql .= " and t15.var1 = :fil";
        }
        $cn->SetSQL($sql);
        $cn->AddParam('userid', $su->user_id);
        if ($filter != '') {
            $cn->AddParam('fil', $filter);
        }
        $ds = $cn->Select();
        $items = array();
        if ($cn->num_rows > 0) {
            foreach ($ds as $dr) {
                $item = new Profile();
                $item->Set($dr);
                $items[$item->profile_slug] = $item;
            }
        }
        return $items; 
    }

    public static function SetProfileInfo($su) {
        $sql = "update __DB__profiles set profile_type_value = :val " +
                " where user_id = :uid and profile_type_value = :tid";
        $cn = new Connect();
        $cn->Persist = true;
        foreach ($this->ProfileKey as $key => $val) {
            $tid = $this->ProfileKey[$key];
            $val = $this->ProfileVal[$key];

            $cn->SetSQL($sql);
            $cn->AddParam('val', $val);
            $cn->AddParam('uid', $this->user_id);
            $cn->AddParam('tid', $tid);
            $cn->Update();
        }
        $cn->CloseAll();
    }
    
    public static function MailReset($su) {
        $tmp = file_get_contents(SITEDOCS . "mails/template.html");
        $eml = file_get_contents(SITEDOCS . "mails/reset.html");
        $eml = str_replace("%%url%%", SITEURLFULL, $eml);
        $eml = str_replace("%%project%%", PROJECT, $eml);
        $eml = str_replace("%%email%%", $su->auth_email, $eml);
        $prm = array(
            'code' => $su->auth_code,
            'email' => $su->auth_email,
        );
        $eml = str_replace("%%codeurl%%", SITEURLFULL . UrlParams('account.activate', $prm), $eml);
        $eml = str_replace("%%name%%", $su->Fullname(), $eml);
        $tmp = str_replace("%%content%%", $eml, $tmp);
        $m = new Mailer();
        $m->AddTo($su->auth_email);
        $m->Subject = "Reset your account";
        $m->Body = $tmp;
        return $m->Send();
    }

    public static function AllUsers() {
        $sql = "SELECT * FROM __DB__users";
        $cn = new Connect();
        $cn->SetSQL($sql);
        return $cn->Select();
    }

    public static function AllUsersByRole($role_id) {
        $sql = "SELECT * FROM __DB__users where role_id = :role_id";
        $cn = new Connect();
        $cn->SetSQL($sql);
        $cn->AddParam('role_id', $role_id);
        return $cn->Select();
    }

    public static function SearchRoles($k) {
        $sql = "SELECT * FROM __DB__roles where role_name like concat('%',:nme,'%')";
        $cn = new Connect();
        $cn->SetSQL($sql);
        $cn->AddParam('nme', $k);
        return $cn->Select();
    }

    public static function AllRights($role_id) {
        $sql = "SELECT f.fxn_id as mkey, f.fxn_name as label,IFNULL(rf.role_id,0) as mval, f.fxn_url AS url
            FROM __DB__fxns f LEFT JOIN __DB__role_fxns rf ON f.fxn_id = rf.fxn_id
            and f.fxn_secure = 1 AND (rf.role_id = :role_id OR rf.role_id IS NULL)";
        $cn = new Connect();
        $cn->SetSQL($sql);
        $cn->AddParam('role_id', $role_id);
        return $cn->Select();
    }

}
