<?php

namespace com\ddocc\base\service;

use com\ddocc\base\utility\Connect;
use com\ddocc\base\utility\Session;

class SystemService {

    public static function GetSettings() {
        $bank_id = Session::Get('bankid');
        $sql = " Select sys_key, sys_val from __DB__system  WHERE bank_id = :bank_id";
        $cn = new Connect();
        $cn->SetSQL($sql);
        $cn->AddParam(':bank_id', $bank_id);
        return $cn->SelectObject();
    }
    
    public static function GetSetting($k) {
        $bank_id = Session::Get('bankid');
        $sql = " Select sys_val from __DB__system  WHERE bank_id = :bank_id and sys_key = :k";
        $cn = new Connect();
        $cn->SetSQL($sql);
        $cn->AddParam(':bank_id', $bank_id);
        $cn->AddParam(':k', $k);
        return $cn->SelectScalar();
    }
    
    public static function SaveSetting($k, $v) {
        $bank_id = Session::Get('bankid');
        $sql = "update __DB__system set sys_val = :v WHERE bank_id = :bank_id and sys_key = :k";
        $cn = new Connect();
        $cn->SetSQL($sql);
        $cn->AddParam(':v', $v);
        $cn->AddParam(':bank_id', $bank_id);
        $cn->AddParam(':k', $k);
        return $cn->Update();
    }
    
    public static function GetTables(){
        $sql ="SHOW FULL TABLES IN " . DBNAME . "  where upper(tables_in_" . DBNAME .") like '". DBPREFIX ."%'";
        $cn = new Connect();
        $cn->SetSQL($sql);        
        return $cn->SelectObject();
    }
    
    public static function ExecuteSQL($sql){
        $cn = new Connect();
        $cn->SetSQL($sql);        
        return $cn->Update();
    }
    
    public static function SelectSQL($sql){
        $cn = new Connect();
        $cn->SetSQL($sql);        
        return $cn->Select();
    }

}
