<?php
/**
 * Created by PhpStorm.
 * User: okesolaa
 * Date: 1/1/15
 * Time: 11:19 PM
 */

namespace com\ddocc\ddlite\service;
use com\ddocc\base\utility\InfoBox;
use com\ddocc\base\utility\ServiceMessage;
use com\ddocc\ddlite\controller\User;
use com\ddocc\ddlite\data\iBase;


class Controller {

    public static $Map = array(
        'signup' => 'com\ddocc\ddlite\controller\User::Register',
        'token' => 'com\ddocc\ddlite\controller\User::Token'
    );
    public static function Parse($arr)
    {
        $b = new iBase(0,'');
        if(! isset($arr["action"]))
        {
            $b->Code = -99;
            $b->Message = "Reflection Exception0";
            return $b->Paint();
        }
        try
        {
            if(! isset(Controller::$Map[$arr["action"]]))
            {
                $b->Code = -98;
                $b->Message = "Reflection Exception1";
                return $b->Paint();
            }
            $bit = explode("::",Controller::$Map[$arr["action"]]);
            $b = $bit[0]::$bit[1]($arr);
            return $b->Paint();
        }
        catch(\Exception $err)
        {
            $b->Code = -97;
            $b->Message = "Reflection Exception2";
            return $b->Paint();
        }

        $b->ErrorCode = -96;
        $b->ErrorMessage = "Reflection Exception3";
        return $b->Paint();
    }





}