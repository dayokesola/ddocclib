<?php

namespace com\ddocc\base\service;
  
use com\ddocc\base\dto\SiteUserDTO;   
use com\ddocc\base\utility\Connect; 
use com\ddocc\base\utility\Mailer; 
use com\ddocc\base\entity\Profile;

class SiteUserService {
    public static $base_sql = 'SELECT  siteuser.auth_email AS email, siteuser.auth_email,
        siteuser.auth_phrase, siteuser.auth_code,siteuser.auth_spice,  siteuser.role_id, siteuser.statusflag, 
        siteuser.date_added, siteuser.last_updated, siteuser.last_reset, siteuser.fname, siteuser.lname, siteuser.mobile,
        siterole.role_name, siteusertext.tab_text AS statustext, userparam.*
        FROM __DB__users siteuser LEFT JOIN __DB__roles siterole ON siteuser.role_id = siterole.role_id 
        LEFT JOIN __DB__text siteusertext ON siteusertext.tab_id = 3 AND siteuser.statusflag = siteusertext.tab_ent 
        left join __DB__user_params userparam on siteuser.user_id = userparam.user_id ';
    
    public static function GetUserById($user_id) {
        $sql = SiteUserService::$base_sql . " WHERE siteuser.user_id = :user_id";
        $cn = new Connect();
        $cn->SetSQL($sql);
        $cn->AddParam(':user_id', $user_id);
        $su = new SiteUserDTO();
        $ds = $cn->Select();
        $su->user_id = 0;
        if ($cn->num_rows > 0) {
            $su->Set($ds[0]);
        }
        return $su;
    }
    
    public static function NewUser() {         
        $su = new SiteUserDTO();   
        $su->user_id = 0;
        return $su;
    }

    public static function GetUserByUsername($username) {
        $sql = SiteUserService::$base_sql . " WHERE siteuser.auth_email = :auth_email";
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

    public static function InsertUser($item) {
        $sql = "INSERT INTO __DB__users (auth_email, auth_phrase, auth_spice, role_id, statusflag, date_added, "
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
        
        SiteUserService::InsertUserParam($item);        
        return $item;
    }
    
    public static function InsertUserParam($item) {
        $sql = "INSERT INTO __DB__user_params (user_id ) VALUES ( :user_id) ";
        $cn = new Connect();
        $cn->SetSQL($sql); 
        $cn->AddParam(':user_id', $item->user_id);
        $cn->Update(); 
    }

    public static function UpdateUser($item) {
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
    
    public static function UpdateUserParam($item, $param_field) {
        $sql = "UPDATE __DB__user_params SET $param_field = :param_value  WHERE user_id = :user_id";
        $cn = new Connect();
        $cn->SetSQL($sql);
        $cn->AddParam(':param_value', $item->{$param_field}); 
        $cn->AddParam(':user_id', $item->user_id);
        return $cn->Update();
    }
    
    public static function DeleteUser($id) {
        $sql = "DELETE FROM __DB__users WHERE user_id = :user_id"; 
        $cn = new Connect();
        $cn->SetSQL($sql);
	$cn->AddParam(':user_id', $id);          
        return $cn->Delete();
    }

    public static function InsertProfileInfo($su) {
        $sql = "insert into __DB__profiles (entity_type_name, user_id, profile_type_id) " .
                " select 'user',:id, tab_ent from __DB__text where tab_id = 15 " .
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
                " where entity_type_name ='user' and  p.user_id = :userid ";
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
        $sql = 'update __DB__profiles set profile_type_value = :pval  
                 where user_id = :user_id and profile_type_id = :ptid';
        $cn = new Connect();
        $cn->Persist = true;
        $c = 0;
        foreach ($su->profiles as  $p) {
            $tid = $p->id;
            $val = $p->profile_value; 
            $cn->SetSQL($sql);
            $cn->AddParam(':pval', $val);
            $cn->AddParam(':user_id', $su->user_id);
            $cn->AddParam(':ptid', $tid);
            $c += $cn->Update();  
        }
        $cn->CloseAll();
        return $c;
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
        $sql = SiteUserService::$base_sql;
        $cn = new Connect();
        $cn->SetSQL($sql);
        $ds = $cn->Select();
        $items = array();
        if ($cn->num_rows > 0) {
            foreach ($ds as $dr) {
                $item = new SiteUserDTO();
                $item->Set($dr);
                $items[$item->user_id] = $item;
            }
        }
        return $items;
    }

    public static function AllUsersByRole($role_id) {
        $sql = SiteUserService::$base_sql ." where siteuser.role_id = :role_id";
        $cn = new Connect();
        $cn->SetSQL($sql);
        $cn->AddParam('role_id', $role_id);
         $ds = $cn->Select();
        $items = array();
        if ($cn->num_rows > 0) {
            foreach ($ds as $dr) {
                $item = new SiteUserDTO();
                $item->Set($dr);
                $items[$item->user_id] = $item;
            }
        }
        return $items;
    }
    
    public static function GetUsersByArray($recarray) {
        $sql = SiteUserService::$base_sql ." where siteuser.user_id in ('0'";
        foreach ($recarray as $rec) {
            $sql .= ",'" . $rec . "'"; 
        }
        $sql .= ')';
        $cn = new Connect();
        $cn->SetSQL($sql); 
         $ds = $cn->Select();
        $items = array();
        if ($cn->num_rows > 0) {
            foreach ($ds as $dr) {
                $item = new SiteUserDTO();
                $item->Set($dr);
                $items[$item->user_id] = $item;
            }
        }
        return $items;
    }
     


}
