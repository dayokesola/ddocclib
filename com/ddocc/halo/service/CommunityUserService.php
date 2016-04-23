<?php

namespace com\ddocc\halo\service;

use com\ddocc\halo\entity\CommunityUser;
use com\ddocc\halo\dto\CommunityUserDTO;
use com\ddocc\base\utility\Connect;

class CommunityUserService {

    //put your code here
    public static function Search($commumity_id = -1, $user_id = -1, $role_id = -1, $statusflag = -1) {

        $sql = "SELECT cu.community_id, cu.user_id, cu.role_id, cu.statusflag,cu.last_updated, c.community_name,c.community_slug,
u.auth_email AS email, u.fname,u.lname, u.mobile, r.tab_text AS role_name, s.tab_text AS statustext
FROM halo_comm_users cu 
INNER JOIN halo_users u ON cu.user_id = u.user_id
INNER JOIN halo_comms c ON cu.community_id = c.id 
INNER JOIN halo_text r ON r.tab_id = 21 AND cu.role_id = r.tab_ent 
INNER JOIN halo_text s ON s.tab_id = 22 AND cu.statusflag = s.tab_ent "
                . " WHERE cu.community_id > 0 ";
        if ($commumity_id > 0) {
            $sql .= "  and cu.community_id = :community_id";
        }
        if ($user_id > 0) {
            $sql .= "  and cu.user_id = :user_id";
        }
        if ($role_id > 0) {
            $sql .= "  and cu.role_id = :role_id ";
        }
        if ($statusflag > 0) {
            $sql .= "  and cu.statusflag = :statusflag ";
        }
        $cn = new Connect();
        $cn->SetSQL($sql);
        if ($commumity_id > 0) {
            $cn->AddParam(':community_id', $commumity_id);
        }
        if ($user_id > 0) {
            $cn->AddParam(':user_id', $user_id);
        }
        if ($role_id > 0) {
            $cn->AddParam(':role_id', $role_id);
        }
        if ($statusflag > 0) {
            $cn->AddParam(':statusflag', $statusflag);
        }
        $ds = $cn->Select();
        $items = array();
        if ($cn->num_rows <= 0) {
            return $items;
        }
        foreach ($ds as $dr) {
            $item = new CommunityUserDTO();
            $item->Set($dr);
            $items[] = $item;
        }
        return $items;
    }

    public static function GetByID($item) {
        $sql = "SELECT community_id, user_id, role_id, statusflag,last_updated FROM __DB__comm_users "
                . "WHERE community_id = :community_id and user_id = :user_id";
        $cn = new Connect();
        $cn->SetSQL($sql);
        $cn->AddParam(':community_id', $item->community_id);
        $cn->AddParam(':user_id', $item->user_id);
        $ds = $cn->Select();
        $item = new CommunityUser();
        $item->community_id = 0;
        $item->user_id = 0;
        if ($cn->num_rows > 0) {
            $item->Set($ds[0]);
        }
        return $item;
    }

    public static function Insert($item) {
        $sql = "INSERT INTO __DB__comm_users (community_id, user_id, role_id, statusflag,last_updated)  "
                . "VALUES ( :community_id, :user_id, :role_id, :statusflag, :last_updated) ";
        $cn = new Connect();
        $cn->SetSQL($sql);
        $cn->AddParam(':community_id', $item->community_id);
        $cn->AddParam(':user_id', $item->user_id);
        $cn->AddParam(':role_id', $item->role_id);
        $cn->AddParam(':statusflag', $item->statusflag);
        $cn->AddParam(':last_updated', $item->last_updated);
        return $cn->Update();
    }

    public static function Update($item) {
        $sql = "UPDATE __DB__comm_users SET role_id = :role_id, statusflag = :statusflag, last_updated = :last_updated"
                . " WHERE community_id = :community_id and user_id = :user_id";
        $cn = new Connect();
        $cn->SetSQL($sql);
        $cn->AddParam(':role_id', $item->role_id);
        $cn->AddParam(':statusflag', $item->statusflag);
        $cn->AddParam(':last_updated', $item->last_updated);
        $cn->AddParam(':community_id', $item->community_id);
        $cn->AddParam(':user_id', $item->user_id);

        return $cn->Update();
    }

    public static function Delete($id) {
        $sql = "DELETE FROM __DB__comm_users WHERE community_id = :community_id and user_id = :user_id";
        $cn = new Connect();
        $cn->SetSQL($sql);
        $cn->AddParam(':community_id', $item->community_id);
        $cn->AddParam(':user_id', $item->user_id);

        return $cn->Delete();
    }

    public static function AcceptUsers($user_ids, $community_id) {
        $k = 0;
        foreach($user_ids as $user_id) {
            $k += CommunityUserService::AuthorizeCommunityUser($user_id, $community_id, 1);
        }
        return $k;
    }
    
    public static function RejectUsers($user_ids, $community_id) {
        $k = 0;
        foreach($user_ids as $user_id) {
            $k += CommunityUserService::AuthorizeCommunityUser($user_id, $community_id, 10);
        }
        return $k;
    }
    
    
    public static function AuthorizeCommunityUser($user_id, $community_id, $action) {
        $x= new CommunityUser();
        $x->community_id = $community_id;
        $x->user_id = $user_id;
        $item = CommunityUserService::GetByID($x);
        if($item->user_id <= 0) {
            return 0;
        }        
        $item->statusflag = $action;
        $item->last_updated = \com\ddocc\base\utility\Gizmo::Now();
        return CommunityUserService::Update($item);
    }
}
