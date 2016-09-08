<?php

namespace com\ddocc\base\service;

use com\ddocc\base\utility\Connect;
use com\ddocc\base\utility\InfoBox;
use com\ddocc\base\dto\SiteFxnDTO;

class SiteFxnService {

    public static $base_sql = '   SELECT fxn.fxn_id, fxn.fxn_name, fxn.fxn_group, fxn.fxn_sort, fxn.fxn_url, 
            fxn.fxn_flag,fxn.fxn_secure, fxn.fxn_icon, fxn.last_updated , fxntext.tab_text AS fxn_group_name
            FROM __DB__fxns fxn LEFT JOIN __DB__text fxntext ON fxntext.tab_id = 1 AND fxn.fxn_group = fxntext.tab_ent ';

    public static function GetByID($id) {
        $sql = SiteFxnService::$base_sql . " WHERE fxn.fxn_id = :fxn_id";
        $cn = new Connect();
        $cn->SetSQL($sql);
        $cn->AddParam(':fxn_id', $id);
        $ds = $cn->Select();
        $f = new SiteFxnDTO();
        $f->fxn_id = 0;
        if ($cn->num_rows > 0) {
            $f->Set($ds[0]);
        }
        return $f;
    }

    public static function GetFxnByUrl($url) {
        $sql = SiteFxnService::$base_sql . " WHERE fxn.fxn_url = :fxn_url";
        $cn = new Connect();
        $cn->SetSQL($sql);
        $cn->AddParam(':fxn_url', $url);
        $ds = $cn->Select();
        $f = new SiteFxnDTO();
        $f->fxn_id = 0;
        if ($cn->num_rows > 0) {
            $f->Set($ds[0]);
        }
        return $f;
    }

    public static function InsertFxn($item) {
        $sql = "INSERT INTO __DB__fxns "
                . "(fxn_name, fxn_group, fxn_sort, fxn_url, fxn_flag, fxn_secure, fxn_icon, last_updated)  "
                . "VALUES "
                . "( :fxn_name, :fxn_group, :fxn_sort, :fxn_url, :fxn_flag, :fxn_secure, :fxn_icon, :last_updated) ";
        $cn = new Connect();
        $cn->SetSQL($sql);
        $cn->AddParam(':fxn_name', $item->fxn_name);
        $cn->AddParam(':fxn_group', $item->fxn_group);
        $cn->AddParam(':fxn_sort', $item->fxn_sort);
        $cn->AddParam(':fxn_url', $item->fxn_url);
        $cn->AddParam(':fxn_flag', $item->fxn_flag);
        $cn->AddParam(':fxn_secure', $item->fxn_secure);
        $cn->AddParam(':fxn_icon', $item->fxn_icon);
        $cn->AddParam(':last_updated', $item->last_updated);
        $item->fxn_id = $cn->Insert();
        return $item;
    }

    public static function GetByName($id) {
        $sql = "SELECT fxn_id, fxn_name, fxn_group, fxn_sort, fxn_url, fxn_flag,"
                . " fxn_secure, fxn_icon, last_updated FROM __DB__fxns WHERE fxn_url = :fxn_url";
        $cn = new Connect();
        $cn->SetSQL($sql);
        $cn->AddParam(':fxn_url', $id);
        $ds = $cn->Select();
        $f = new SiteFxn();
        $f->fxn_id = 0;
        if ($cn->num_rows > 0) {
            $f->Set($ds[0]);
        }
        return $f;
    }

    public static function BelongsTo($fxn_id, $role_id) {
        $sql = "SELECT fxn_id, role_id  "
                . "FROM __DB__role_fxns WHERE fxn_id = :fxn_id and role_id = :role_id";
        $cn = new Connect();
        $cn->SetSQL($sql);
        $cn->AddParam('fxn_id', $fxn_id);
        $cn->AddParam('role_id', $role_id);
        $cn->Select();
        if ($cn->num_rows > 0)
            return TRUE;
        else
            return FALSE;
    }

    public static function Update($fxn) {
        $sql = "UPDATE __DB__fxns SET fxn_name = :fxn_name, fxn_group = :fxn_group, fxn_sort = :fxn_sort, "
                . "fxn_url = :fxn_url, fxn_flag = :fxn_flag, fxn_secure = :fxn_secure, fxn_icon = :fxn_icon, "
                . "last_updated = :last_updated WHERE fxn_id = :fxn_id";
        $cn = new Connect();
        $cn->SetSQL($sql);
        $cn->AddParam(':fxn_name', $fxn->fxn_name);
        $cn->AddParam(':fxn_group', $fxn->fxn_group);
        $cn->AddParam(':fxn_sort', $fxn->fxn_sort);
        $cn->AddParam(':fxn_url', $fxn->fxn_url);
        $cn->AddParam(':fxn_flag', $fxn->fxn_flag);
        $cn->AddParam(':fxn_secure', $fxn->fxn_secure);
        $cn->AddParam(':fxn_icon', $fxn->fxn_icon);
        $cn->AddParam(':last_updated', $fxn->last_updated);
        $cn->AddParam(':fxn_id', $fxn->fxn_id);
        return $cn->Update();
    }
    
       public static function DeleteFxn($fxn) {
        $sql = "delete from __DB__fxns WHERE fxn_id = :fxn_id";
        $cn = new Connect();
        $cn->SetSQL($sql);
        $cn->AddParam(':fxn_id', $fxn->fxn_id);
        return $cn->Delete();
    }

    public static function PostCreate($p) {
        $msg = '';
        if ($p->fxn_name == '')
            $msg .= '<li>function name cannot be empty</li>';
        if ($p->fxn_url == '')
            $msg .= '<li>function url cannot be empty</li>';
        if ($msg != '') {
            return new InfoBox(false, '<ul>' . $msg . '</ul>');
        }
        //check if one exist
        $xp = new SiteFxn();
        $xp->fxn_url = $p->fxn_url;
        $xp->LoadByUrl();
        if ($xp->fxn_id > 0) {
            return new InfoBox(false, 'function already exists');
        }

        $cnt = $p->Insert();
        if ($cnt > 0) {
            return new InfoBox(true, 'function has been created');
        } else {
            return new InfoBox(false, 'function could not be created');
        }
        return new InfoBox('', '');
    }

    public static function PostEdit($p) {
        $msg = '';
        if ($p->fxn_name == '')
            $msg .= '<li>function name cannot be empty</li>';
        if ($p->fxn_url == '')
            $msg .= '<li>function url cannot be empty</li>';
        if ($msg != '') {
            return new InfoBox(false, '<ul>' . $msg . '</ul>');
        }
        $cnt = $p->Update();
        if ($cnt > 0) {
            return new InfoBox(true, 'function has been updated');
        } else {
            return new InfoBox(false, 'function could not be updated');
        }
        return new InfoBox('', '');
    }

    public static function AllFunctions() {
        $sql = "SELECT f.fxn_id, f.fxn_name, f.fxn_group, f.fxn_sort,
f.fxn_url, f.fxn_flag, f.fxn_secure, f.fxn_icon, f.last_updated, t.tab_text
 FROM __DB__fxns f LEFT JOIN __DB__text t ON t.tab_id = 1 AND t.tab_ent = f.fxn_group
 ORDER BY f.fxn_group, f.fxn_sort, f.fxn_name";
        $cn = new Connect();
        $cn->SetSQL($sql);
        return $cn->SelectObject();
    }

    public static function SearchFunctions($k) {
        $sql = "SELECT * FROM __DB__fxns where fxn_name like concat('%',:nme,'%') or  fxn_url like concat('%',:url,'%')";
        $cn = new Connect();
        $cn->SetSQL($sql);
        $cn->AddParam(':nme', $k);
        $cn->AddParam(':url', $k);
        return $cn->Select();
    }

    public static function GetRoleFunctions($role_id) {
        $sql = " SELECT f.* 
            FROM __DB__fxns f INNER JOIN __DB__role_fxns rf ON f.fxn_id = rf.fxn_id 
            WHERE f.fxn_secure = 1 AND rf.role_id = :role_id order by f.fxn_group,f.fxn_sort ";
        $cn = new Connect();
        $cn->SetSQL($sql);
        $cn->AddParam(':role_id', $role_id);
        return $cn->SelectObject();
    }

}
