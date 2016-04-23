<?php

namespace com\ddocc\halo\service;

use com\ddocc\base\utility\Connect;
use com\ddocc\halo\entity\Community;
use com\ddocc\halo\dto\CommunityDTO;
use com\ddocc\base\utility\Gizmo;
class CommunityService {

    public static function Search($community_name = '', $community_slug = '', 
            $parent_id = -1, $statusflag = -1, $records = 0, $community_id = 0, $ancestor_id = -1) {

        $sql = "SELECT c.id, c.community_name, c.parent_id, c.community_slug, c.statusflag, c.ancestor_id, 
            c.last_updated, s.community_name AS parent_name, a.community_name AS ancestor_name, COUNT(cu.community_id) AS all_members ,
SUM(CASE WHEN cu.role_id = 1 THEN 1 ELSE 0 END) AS admin_users,
SUM(CASE WHEN cu.role_id != 1 THEN 1 ELSE 0 END) AS non_admin_users,
SUM(CASE WHEN cu.statusflag IN (1,2) THEN 1 ELSE 0 END) AS members,
SUM(CASE WHEN cu.statusflag = 1 THEN 1 ELSE 0 END) AS active_users,
SUM(CASE WHEN cu.statusflag = 2 THEN 1 ELSE 0 END) AS inactive_users,
SUM(CASE WHEN cu.statusflag = 9 THEN 1 ELSE 0 END) AS request_users,
SUM(CASE WHEN cu.statusflag = 10 THEN 1 ELSE 0 END) AS blocked_users,
c.community_type_id, t.tab_text AS community_type_name
FROM __DB__comms c  
LEFT JOIN __DB__comms s ON c.parent_id = s.id 
LEFT JOIN __DB__comms a ON c.ancestor_id = a.id 
LEFT JOIN __DB__comm_users cu ON c.id = cu.community_id 
left join __DB__text t on t.tab_id = 30 AND t.tab_ent = c.community_type_id
GROUP BY c.id, c.community_name, c.parent_id, c.community_slug, c.statusflag,  c.ancestor_id,
c.last_updated, s.community_name, a.community_name,c.community_type_id, t.tab_text   "
                . " having c.id > 0 ";
        if ($community_name != '') {
            $sql .= "  and lower(c.community_name) like concat('%',:community_name,'%')";
        }
        if ($community_slug != '') {
            $sql .= "  and c.community_slug like concat('%',:community_slug,'%')";
        }
        if ($parent_id > 0) {
            $sql .= "  and c.parent_id = :parent_id ";
        }
        if ($ancestor_id > 0) {
            $sql .= "  and c.ancestor_id = :ancestor_id ";
        }
        if ($statusflag >= 0) {
            $sql .= "  and c.statusflag = :statusflag ";
        } 
        if ($community_id > 0) {
            $sql .= "  and c.id = :community_id ";
        }
        $sql .= ' ORDER BY c.community_name';
        if($records > 0){
            $sql .= ' limit ' . $records;
        } 
        //dd($sql);
        $cn = new Connect();
        $cn->SetSQL($sql);
        if ($community_name != '') {
            $cn->AddParam(':community_name', strtolower($community_name));
        }
        if ($community_slug != '') {
            $cn->AddParam(':community_slug', strtolower($community_slug));
        }
        if ($parent_id > 0) {
            $cn->AddParam(':parent_id', $parent_id);
        }
        if ($ancestor_id > 0) {
            $cn->AddParam(':ancestor_id', $ancestor_id);
        }
        if ($statusflag >= 0) {
            $cn->AddParam(':statusflag', $statusflag);
        } 
        if ($community_id > 0) {
            $cn->AddParam(':community_id', $community_id);
        }
        $ds = $cn->Select();
        $items = array();
        if ($cn->num_rows > 0) {
            foreach ($ds as $dr) {
                $item = new CommunityDTO();
                $item->Set($dr);
                $items[] = $item;
            }
        }
        return $items;
    } 
    
    public static function GetByID($id) {
        $sql = "SELECT id, community_name, parent_id, community_slug, community_type, statusflag, last_updated,ancestor_id "
                . "FROM halo_comms WHERE id = :id";
        $cn = new Connect();
        $cn->SetSQL($sql);
        $cn->AddParam(':id', $id);
        $ds = $cn->Select();
        $item = new Community();
        $item->id = 0;
        if ($cn->num_rows > 0) {
            $item->Set($ds[0]);
        }
        return $item;
    }

    public static function GetByName($id) {
        $sql = "SELECT id, community_name, parent_id, community_slug, community_type, statusflag, last_updated,ancestor_id "
                . "FROM halo_comms WHERE community_name = :id";
        $cn = new Connect();
        $cn->SetSQL($sql);
        $cn->AddParam(':id', $id);
        $ds = $cn->Select();
        $item = new Community();
        $item->id = 0;
        if ($cn->num_rows > 0) {
            $item->Set($ds[0]);
        }
        return $item;
    }

    public static function GetBySlug($id) {
        $sql = "SELECT id, community_name, parent_id, community_slug, community_type, statusflag, last_updated,ancestor_id "
                . "FROM halo_comms WHERE community_slug = :id";
        $cn = new Connect();
        $cn->SetSQL($sql);
        $cn->AddParam(':id', strtolower($id));
        $ds = $cn->Select();
        $item = new Community();
        $item->id = 0;
        if ($cn->num_rows > 0) {
            $item->Set($ds[0]);
        }
        return $item;
    }
    
    public static function GetByHost() {         
        return CommunityService::GetBySlug(Gizmo::Clean($_SERVER['HTTP_HOST']));
    }

    public static function Insert($item) {
        $sql = "INSERT INTO halo_comms "
                . "(community_name, parent_id,ancestor_id, community_slug, community_type, statusflag, last_updated) "
                . " VALUES ( :community_name, :parent_id, :ancestor_id, :community_slug, :community_type, :statusflag, :last_updated) ";
        $cn = new Connect();
        $cn->SetSQL($sql);
        $cn->AddParam(':community_name', $item->community_name);
        $cn->AddParam(':parent_id', $item->parent_id);
        $cn->AddParam(':ancestor_id', $item->ancestor_id);
        $cn->AddParam(':community_slug', $item->community_slug);
        $cn->AddParam(':community_type', $item->community_type);
        $cn->AddParam(':statusflag', $item->statusflag);
        $cn->AddParam(':last_updated', $item->last_updated);
        $item->id = $cn->Insert();
        return $item->id;
    }

    public static function Update($item) {
        $sql = "UPDATE halo_comms SET community_name = :community_name, parent_id = :parent_id,ancestor_id =:ancestor_id, "
                . "community_slug = :community_slug, community_type =: community_type, statusflag = :statusflag, last_updated = :last_updated WHERE id = :id";
        $cn = new Connect();
        $cn->SetSQL($sql);
        $cn->AddParam(':community_name', $item->community_name);
        $cn->AddParam(':parent_id', $item->parent_id);
        $cn->AddParam(':ancestor_id', $item->ancestor_id);
        $cn->AddParam(':community_slug', $item->community_slug);
        $cn->AddParam(':community_type', $item->community_type);
        $cn->AddParam(':statusflag', $item->statusflag);
        $cn->AddParam(':last_updated', $item->last_updated);
        $cn->AddParam(':id', $item->id);

        return $cn->Update();
    }

    public static function Delete($id) {
        $sql = "DELETE FROM halo_comms WHERE id = :id";
        $cn = new Connect();
        $cn->SetSQL($sql);
        $cn->AddParam(':id', $id);

        return $cn->Delete();
    }
    
}
