<?php

namespace com\ddocc\base\service;

use com\ddocc\base\utility\Connect;
use com\ddocc\base\dto\SiteTabDTO;

class SiteTabService {
    public static function NewTabGroup() {
        $b = new SiteTabDTO();
        $b->tab_id = 999;
        $b->tab_ent = 0; 
        return $b;
    }
    
    public static function NewTabEntry($tab_id) {
        $b = new SiteTabDTO();
        $b->tab_id = $tab_id;
        $b->tab_ent = 0; 
        return $b;
    }

    public static function GetTabList($tab_id, $sort = 2, $filter1 = '', $filter2 = '', $filter3 = '', $filter4 = '', $filter5 = '') {
        $sql = "SELECT tab_id, tab_ent, tab_text, var1, var2, var3, var4, var5 "
                . "FROM __DB__text WHERE tab_id = :tab_id ";
        if ($filter1 != '') {
            $sql .= " and var1 = :var1 ";
        }
        if ($filter2 != '') {
            $sql .= " and var2 = :var2 ";
        }
        if ($filter3 != '') {
            $sql .= " and var3 = :var3 ";
        }
        if ($filter4 != '') {
            $sql .= " and var4 = :var4 ";
        }
        if ($filter5 != '') {
            $sql .= " and var5 = :var5 ";
        }
        $sql .= "order by " . $sort;
        $cn = new Connect();
        $cn->SetSQL($sql);
        $cn->AddParam(':tab_id', $tab_id);
        if ($filter1 != '') {
            $cn->AddParam(':var1', $filter1);
        }
        if ($filter2 != '') {
            $cn->AddParam(':var2', $filter2);
        }
        if ($filter3 != '') {
            $cn->AddParam(':var3', $filter3);
        }
        if ($filter4 != '') {
            $cn->AddParam(':var4', $filter4);
        }
        if ($filter5 != '') {
            $cn->AddParam(':var5', $filter5);
        }
        $ds = $cn->Select();
        $items = array();
        if ($cn->num_rows > 0) {
            foreach ($ds as $dr) {
                $item = new SiteTabDTO();
                $item->Set($dr);
                $items[$item->tab_ent] = $item;
            }
        }
        return $items;
    }

    public static function GetTabList2($tab_id, $sort = 2) {
        $sql = "SELECT tab_id, tab_ent, tab_text, var1, var2, var3, var4, var5 "
                . "FROM __DB__text WHERE tab_id = :tab_id order by " . $sort;
        $cn = new Connect();
        $cn->SetSQL($sql);
        $cn->AddParam(':tab_id', $tab_id);
        return $cn->Select();
    }

    public static function Load($item) {
        $sql = "SELECT tab_id, tab_ent, tab_text, var1, var2, var3, var4, var5 FROM __DB__text WHERE tab_id = :tab_id and tab_ent = :tab_ent";
        $cn = new Connect();
        $cn->SetSQL($sql);
        $cn->AddParam(':tab_id', $item->tab_id);
        $cn->AddParam(':tab_ent', $item->tab_ent);
        $ds = $cn->Select();
        $item = new SiteTabDTO();
        $item->tab_id = 0;
        if ($cn->num_rows > 0) {
            $item->Set($ds[0]);
        }
        return $item;
    }

    public static function GetTabByID($tab_id, $tab_ent) {
        $sql = "SELECT tab_id, tab_ent, tab_text, var1, var2, var3, var4, var5 FROM __DB__text WHERE tab_id = :tab_id and tab_ent = :tab_ent";
        $cn = new Connect();
        $cn->SetSQL($sql);
        $cn->AddParam(':tab_id', $tab_id);
        $cn->AddParam(':tab_ent', $tab_ent);
        $ds = $cn->Select();
        $item = new SiteTabDTO();
        $item->tab_id = 0;
        if ($cn->num_rows > 0) {
            $item->Set($ds[0]);
        }
        return $item;
    }

    public static function Insert($item) {
        $sql = "INSERT INTO __DB__text (tab_id, tab_ent, tab_text, var1, var2, var3, var4, var5)  VALUES ( :tab_id, :tab_ent, :tab_text, :var1, :var2, :var3, :var4, :var5) ";
        $cn = new Connect();
        $cn->SetSQL($sql);
        $cn->AddParam(':tab_id', $item->tab_id);
        $cn->AddParam(':tab_ent', $item->tab_ent);
        $cn->AddParam(':tab_text', $item->tab_text);
        $cn->AddParam(':var1', $item->var1);
        $cn->AddParam(':var2', $item->var2);
        $cn->AddParam(':var3', $item->var3);
        $cn->AddParam(':var4', $item->var4);
        $cn->AddParam(':var5', $item->var5);
        return $cn->Update();
    }

    public static function Update($item) {
        $sql = "UPDATE __DB__text SET tab_text = :tab_text, var1 = :var1, var2 = :var2, var3 = :var3, var4 = :var4, var5 = :var5 WHERE tab_id = :tab_id and tab_ent = :tab_ent";
        $cn = new Connect();
        $cn->SetSQL($sql);
        $cn->AddParam(':tab_text', $item->tab_text);
        $cn->AddParam(':var1', $item->var1);
        $cn->AddParam(':var2', $item->var2);
        $cn->AddParam(':var3', $item->var3);
        $cn->AddParam(':var4', $item->var4);
        $cn->AddParam(':var5', $item->var5);
        $cn->AddParam(':tab_id', $item->tab_id);
        $cn->AddParam(':tab_ent', $item->tab_ent);

        return $cn->Update();
    }

    public static function Delete($item) {
        $sql = "DELETE FROM __DB__text WHERE tab_id = :tab_id and tab_ent = :tab_ent";
        $cn = new Connect();
        $cn->SetSQL($sql);
        $cn->AddParam(':tab_id', $item->tab_id);
        $cn->AddParam(':tab_ent', $item->tab_ent);

        return $cn->Delete();
    }

    public static function GetList($sort = 2) {
        $sql = "SELECT tab_id, tab_ent, tab_text, var1, var2, var3, var4, var5 "
                . "FROM __DB__text WHERE tab_id = :tab_id order by " . $sort;
        $cn = new Connect();
        $cn->SetSQL($sql);
        $cn->AddParam('tab_id', $this->tab_id);
        return $cn->Select();
    }

    public static function GetTabsByArray($tab_id, $recarray) {
        $sql = "SELECT tab_id, tab_ent, tab_text, var1, var2, var3, var4, var5 FROM __DB__text "
                . "WHERE tab_id = :tab_id and  tab_ent in ('0'";
        foreach ($recarray as $rec) {
            $sql .= ",'" . $rec . "'";
        }
        $sql .= ')';
        $cn = new Connect();
        $cn->SetSQL($sql);
        $cn->AddParam(':tab_id', $tab_id);
        $ds = $cn->Select();
        $items = array();
        if ($cn->num_rows > 0) {
            foreach ($ds as $dr) {
                $item = new SiteTabDTO();
                $item->Set($dr);
                $items[$item->tab_ent] = $item;
            }
        }
        return $items;
    }

}
