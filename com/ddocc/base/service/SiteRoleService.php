<?php
namespace com\ddocc\base\service;
use com\ddocc\base\utility\Connect;
use com\ddocc\base\utility\Gizmo;
use com\ddocc\base\entity\SiteRole;
class SiteRoleService {

    public static function GetByID($id) {
        $sql = "SELECT role_id, role_name, role_text, last_updated FROM __DB__roles WHERE role_id = :role_id";
        $cn = new Connect();
        $cn->SetSQL($sql);
        $cn->AddParam(':role_id', $id);
        $ds = $cn->Select();
        $i = new SiteRole();
        $i->role_id = 0;
        if ($cn->num_rows > 0) {
            $i->Set($ds[0]);
        }
        return $i;
    }

    public static function GetByName($id) {
        $sql = "SELECT role_id, role_name, role_text, last_updated FROM __DB__roles WHERE role_name = :role_name";
        $cn = new Connect();
        $cn->SetSQL($sql);
        $cn->AddParam(':role_name', $id);
        $ds = $cn->Select();
        $i = new SiteRole();
        $i->role_id = 0;
        if ($cn->num_rows > 0) {
            $i->Set($ds[0]);
        }
        return $i;
    }

    public static function Update($i) {
        $sql = "UPDATE __DB__roles SET role_name = :role_name,
         last_updated = :last_updated WHERE role_id = :role_id";
        $cn = new Connect();
        $cn->SetSQL($sql);
        $cn->AddParam(':role_name', $i->role_name);
        $cn->AddParam(':last_updated', $i->last_updated);
        $cn->AddParam(':role_id', $i->role_id);
        return $cn->Update();
    }

    public static function Insert($i)
    {
        $sql = "INSERT INTO __DB__roles (role_name, role_text, last_updated)  VALUES ( :role_name, :role_text, :last_updated) ";
        $cn = new Connect();
        $cn->SetSQL($sql);
        $cn->AddParam(':role_name', $i->role_name);
        $cn->AddParam(':role_text', $i->role_text);
        $cn->AddParam(':last_updated', $i->last_updated);
        $i->role_id = $cn->Insert();
        return $i->role_id;
    }
    
    public static function AllRoles() {
        $sql = "SELECT * FROM __DB__roles order by role_name";
        $cn = new Connect();
        $cn->SetSQL($sql);
        return $cn->SelectObject();
    }

    public static function SearchRoles($k) {
        $sql = "SELECT * FROM __DB__roles where role_name like concat('%',:nme,'%')";
        $cn = new Connect();
        $cn->SetSQL($sql);
        $cn->AddParam('nme', $k);
        return $cn->Select();
    }

    public static function AllRights($role_id) {
        $sql = "SELECT f.fxn_id , f.fxn_name ,IFNULL(rf.role_id,0) AS role_id, f.fxn_url, f.fxn_group, t.tab_text, f.fxn_secure,f.fxn_flag
            FROM __DB__fxns f LEFT JOIN __DB__role_fxns rf ON f.fxn_id = rf.fxn_id 
            and f.fxn_secure = 1 AND (rf.role_id = :role_id OR rf.role_id IS NULL)
            left join __DB__text t on t.tab_id = 1 and t.tab_ent = f.fxn_group
            order by f.fxn_group, f.fxn_sort";
        $cn = new Connect();
        $cn->SetSQL($sql);
        $cn->AddParam('role_id', $role_id);
        return $cn->SelectObject();
    }

    public static function RemoveRoleFunctions($role_id) {
        $cn = new Connect();
        $cn->SetSQL("delete from __DB__role_fxns where role_id = :role_id ");
        $cn->AddParam(':role_id', $role_id);
        return $cn->Delete();
    }

    public static function AddRoleFunctions($role_id, $arr) {
        $cn = new Connect();
        $cn->Persist = TRUE;
        $sql = "insert into __DB__role_fxns (role_id, fxn_id) values(:role_id,:fxn_id)";
        $k = 0;
        foreach ($arr as $fxn_id) {
            $cn->SetSQL($sql);
            $cn->AddParam(':role_id', $role_id);
            $cn->AddParam(':fxn_id', $fxn_id);
            $k += $cn->Update();
        }
        $cn->CloseAll();
        return $k;
    }

    public static function PaintRoleMenu($role_id) {
        //~c class=
        //~d data-original-title=
        //~m hidden-minibar
        //~h a href=
        $strMain = "~d%%appgroup%%~e%%strsub%%~f";
        $strSub = "~g%%appurl%%~h%%appname%%~i";
        $tx = SiteTabService::GetTabList(1, 2);
        $ds = SiteFxnService::GetRoleFunctions($role_id);
        $txtMain = '';
        $txtSub = '';
        foreach ($tx as $trow) {
            $txtSub = '';
            $txt2 = "";
            $j = 0;
            foreach ($ds as $frow) {
                if ($trow->tab_ent == $frow->fxn_group && $frow->fxn_flag == 1) {
                    $txt2 = $strSub;
                    $txt2 = Gizmo::Replace("%%appurl%%", Url($frow->fxn_url), $txt2);
                    $txt2 = Gizmo::Replace("%%appname%%", $frow->fxn_name, $txt2);
                    $txtSub .= $txt2;
                    $j++;
                }
            }
            if ($j > 0) {
                $txt1 = $strMain;
                $txt1 = Gizmo::Replace("%%appgroup%%", $trow->tab_text, $txt1);
                $txt1 = Gizmo::Replace("%%strsub%%", $txtSub, $txt1);
                $txtMain .= $txt1;
            }
        }

        $r = new SiteRole();
        $r->role_id = $role_id;
        $r->Load();
        $r->role_text = Gizmo::SafeHTMLEncode($txtMain);
        $r->Update();
    }

}
