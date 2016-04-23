<?php
/**
 * Created by PhpStorm.
 * User: okesolaa
 * Date: 1/1/15
 * Time: 11:45 PM
 */
namespace com\ddocc\ddlite\controller;
use com\ddocc\base\entity\SiteUserReg;
use com\ddocc\base\entity\Token;
use com\ddocc\base\service\SiteUserService;
use com\ddocc\base\utility\Gizmo;
use com\ddocc\base\utility\Session;
use com\ddocc\ddlite\data\iBase;

class User {
    public static function Register($arr)
    {
        $s = new SiteUserReg();
        if(isset($arr["email"])) $s->email = $arr["email"];
        else return new iBase(-10, "Invalid Email");
        $s->country_code_id = 1;
        $s->location_id = 1;
        $s->mobile = "0";
        if(isset($arr["fname"])) $s->fname = $arr["fname"];
        else $s->fname = '';
        if(isset($arr["lname"])) $s->lname = $arr["lname"];
        else $s->lname = '';
        if(isset($arr["pwd"])) $s->pwd = $arr["pwd"];
        else $s->pwd = '';
        $s->salt = Gizmo::Random(15);
        $s->pwd = md5($s->salt . $s->pwd. $s->salt);
        return SiteUserService::PostRegisterUser($s);
    }

    public static function Token($arr)
    {
        $t = new Token();
        $t->session_id = Session::ID();
        return SiteUserService::PostToken($t);
    }
} 