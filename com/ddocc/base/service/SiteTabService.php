<?php
namespace com\ddocc\base\service;
use com\ddocc\base\utility\Connect;

class SiteTabService
{
                     
    public static function GetTabList($tab_id, $sort = 2)
    {
        $sql = "SELECT tab_id, tab_ent, tab_text, var1, var2, var3, var4, var5 "
                . "FROM __DB__text WHERE tab_id = :tab_id order by ".$sort;        
        $cn = new Connect();
        $cn->SetSQL($sql);  	
        $cn->AddParam(':tab_id', $tab_id);
        return $cn->SelectObject();
    }

    public static function GetTabList2($tab_id, $sort = 2)
    {
        $sql = "SELECT tab_id, tab_ent, tab_text, var1, var2, var3, var4, var5 "
            . "FROM __DB__text WHERE tab_id = :tab_id order by ".$sort;
        $cn = new Connect();
        $cn->SetSQL($sql);
        $cn->AddParam(':tab_id', $tab_id);
        return $cn->Select();
    }
    
}
