<?php

namespace com\ddocc\base\entity;

use com\ddocc\base\utility\Connect;

/**
 * Description of SiteUser
 *
 * @author Dayo Okesola - YumYum
 */
Class SiteUser extends EntityBase {

    var $user_id;
    var $auth_email;
    var $auth_phrase;
    var $auth_spice;
    var $role_id;
    var $statusflag;
    var $date_added;
    var $last_updated;
    var $last_reset;
    var $fname;
    var $lname;
    var $auth_code;
    var $mobile;
  
    
    
    function Set($dr) {
        $this->user_id = $dr['user_id'];
        $this->auth_email = $dr['auth_email'];
        $this->auth_phrase = $dr['auth_phrase'];
        $this->auth_spice = $dr['auth_spice'];
        $this->role_id = $dr['role_id'];
        $this->statusflag = $dr['statusflag'];
        $this->date_added = $dr['date_added'];
        $this->last_updated = $dr['last_updated'];
        $this->last_reset = $dr['last_reset'];
        $this->fname = $dr['fname'];
        $this->lname = $dr['lname'];
        $this->auth_code = $dr['auth_code'];
        $this->mobile = $dr['mobile'];
    }
    
    
    function HideAuth() {
        $this->auth_spice = "mickey";
        $this->auth_phrase = "mouse";
    }

    function Fullname() {
        return $this->fname . ' ' . $this->lname;
    }

    function Load() {
        $sql = "SELECT user_id, auth_email, auth_phrase, auth_spice, role_id, statusflag, "
                . "date_added, last_updated, last_reset,fname, lname, auth_code "
                . "FROM __DB__users WHERE user_id = :user_id";
        $cn = new Connect();
        $cn->SetSQL($sql);
        $cn->AddParam(':user_id', $this->user_id);

        $ds = $cn->Select();
        $this->user_id = 0;
        if ($cn->num_rows > 0) {
            $this->Set($ds[0]);
        }
    }

    function LoadByUsername() {
        $sql = "SELECT user_id, auth_email, auth_phrase, auth_spice, role_id, statusflag, 
            date_added, last_updated, last_reset,fname, lname, auth_code
        FROM __DB__users WHERE auth_email = :auth_email";
        $cn = new Connect();
        $cn->SetSQL($sql);
        $cn->AddParam(':auth_email', $this->auth_email);

        $ds = $cn->Select();
        $this->user_id = 0;
        if ($cn->num_rows > 0) {
            $this->Set($ds[0]);
        }
    }

    function Insert() {
        $sql = "INSERT INTO __DB__users (auth_email, auth_phrase, auth_spice, role_id, statusflag, date_added, last_updated, last_reset)
          VALUES ( :auth_email, :auth_phrase, :auth_spice, :role_id, :statusflag, :date_added, :last_updated, :last_reset) ";
        $cn = new Connect();
        $cn->SetSQL($sql);
        $cn->AddParam(':auth_email', $this->auth_email);
        $cn->AddParam(':auth_phrase', $this->auth_phrase);
        $cn->AddParam(':auth_spice', $this->auth_spice);
        $cn->AddParam(':role_id', $this->role_id);
        $cn->AddParam(':statusflag', $this->statusflag);
        $cn->AddParam(':date_added', $this->date_added);
        $cn->AddParam(':last_updated', $this->last_updated);
        $cn->AddParam(':last_reset', $this->last_reset);
        $this->user_id = $cn->Insert();
        return $this->user_id;
    }

    function Update() {
        $sql = "UPDATE __DB__users SET auth_email = :auth_email, auth_phrase = :auth_phrase, auth_spice = :auth_spice, role_id = :role_id, statusflag = :statusflag, date_added = :date_added, last_updated = :last_updated, last_reset = :last_reset WHERE user_id = :user_id";
        $cn = new Connect();
        $cn->SetSQL($sql);
        $cn->AddParam(':auth_email', $this->auth_email);
        $cn->AddParam(':auth_phrase', $this->auth_phrase);
        $cn->AddParam(':auth_spice', $this->auth_spice);
        $cn->AddParam(':role_id', $this->role_id);
        $cn->AddParam(':statusflag', $this->statusflag);
        $cn->AddParam(':date_added', $this->date_added);
        $cn->AddParam(':last_updated', $this->last_updated);
        $cn->AddParam(':last_reset', $this->last_reset);
        $cn->AddParam(':user_id', $this->user_id);

        return $cn->Update();
    }

    function Delete() {
        $sql = "DELETE FROM __DB__users WHERE user_id = :user_id";
        $cn = new Connect();
        $cn->SetSQL($sql);
        $cn->AddParam(':user_id', $this->user_id);

        return $cn->Delete();
    }

    function InsertProfileInfo() {
        $sql = "insert into __DB__profiles (user_id, profile_type_id) " .
                " select :id, tab_ent from __DB__text where tab_id = 15 " .
                " and tab_ent not in (select profile_type_id from __DB__profiles where user_id = :id)";
        $cn = new Connect();
        $cn->SetSQL($sql);
        $cn->AddParam('id', $this->user_id);
        $cn->Update();
    }

    function GetProfileInfo($filter = '') {
        $this->InsertProfileInfo();
        $this->ProfileVal = array();
        $this->ProfileKey = array();
        $cn = new Connect();
        $sql = "select   t15.tab_ent as pID,t15.tab_text as pkey, p.profile_type_value as pval from " .
                " __DB__text t15 left join __DB__profiles p on t15.tab_id = 15 and t15.tab_ent = p.profile_type_id " .
                " where  p.user_id = :id ";
        if ($filter != "") {
            $sql .= " and t15.var2 = :fil";
        }
        $cn->SetSQL($sql);
        $cn->AddParam('id', $this->user_id);
        if ($filter != '') {
            $cn->AddParam('fil', $filter);
        }
        $ds = $cn->Select();
        foreach ($ds as $dr) {
            $this->ProfileVal[$dr["pkey"]] = $dr["pval"];
            $this->ProfileKey[$dr["pkey"]] = $dr["pID"];
        }
    }

    function SetProfileInfo() {
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

    function Avatar() {
        return MEDIAURL . 'avatar/' . $this->ProfileVal["AVATAR"];
    }

    function JoinDate() {
        $dtm = strtotime($this->DateAdded);
        return date('M Y');
    }

}
