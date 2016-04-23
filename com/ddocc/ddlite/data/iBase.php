<?php
/**
 * Created by PhpStorm.
 * User: okesolaa
 * Date: 1/1/15
 * Time: 11:24 PM
 */

namespace com\ddocc\ddlite\data;

class iBase {
    var $Code;
    var $Message;
    var $IsOk;

    public function Paint()
    {
        $this->IsOk =  $this->Code > 0;
        //$this->Message =  strtoupper($this->Message);
        return json_encode($this);
    }

    public function __construct($ec = 0,$em = ''){
        $this->Code = $ec;
        $this->Message = $em;
        $this->IsOk = $ec > 0;
    }
}

class iUser extends iBase
{
    var $UserInfo;
}