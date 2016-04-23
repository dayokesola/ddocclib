<?php
/**
 * Created by PhpStorm.
 * User: okesolaa
 * Date: 4/28/2015
 * Time: 3:35 PM
 */

namespace com\ddocc\base\entity;

use com\ddocc\base\utility\Connect;


class Token
{
    var $session_id;
    var $token;
    var $expiry;


    function Load()
    {
        $sql = "SELECT session_id, token, expiry FROM tbl_tokens WHERE session_id = :session_id";
        $cn = new Connect();
        $cn->SetSQL($sql);
        $cn->AddParam(':session_id', $this->session_id);
        $ds = $cn->Select();
        $this->session_id = '';
        if($cn->num_rows > 0)
        {
            $this->Set($ds[0]);
        }
    }

    function Set($dr)
    {
        $this->session_id = $dr['session_id'];
        $this->token = $dr['token'];
        $this->expiry = $dr['expiry'];
    }

    function Insert()
    {
        $sql = "INSERT INTO tbl_tokens (session_id, token, expiry)  VALUES ( :session_id, :token, :expiry) ";
        $cn = new Connect();
        $cn->SetSQL($sql);
        $cn->AddParam(':session_id', $this->session_id);
        $cn->AddParam(':token', $this->token);
        $cn->AddParam(':expiry', $this->expiry);
        return $cn->Update();
    }

    function Update()
    {
        $sql = "UPDATE tbl_tokens SET token = :token, expiry = :expiry WHERE  session_id = :session_id ";
        $cn = new Connect();
        $cn->SetSQL($sql);
        $cn->AddParam(':token', $this->token);
        $cn->AddParam(':expiry', $this->expiry);
        $cn->AddParam(':session_id', $this->session_id);

        return $cn->Update();
    }

    function Delete()
    {
        $sql = "DELETE FROM tbl_tokens WHERE  session_id = :session_id  ";
        $cn = new Connect();
        $cn->SetSQL($sql);
        $cn->AddParam(':session_id', $this->session_id);
        return $cn->Delete();
    }
}