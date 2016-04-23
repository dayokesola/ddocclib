<?php
namespace com\ddocc\halo\entity;
use com\ddocc\base\entity\EntityBase;
class CommunityUser extends EntityBase {

    var $community_id;
    var $user_id;
    var $role_id;
    var $statusflag;
    var $last_updated;
    
    function Set($dr) {
        $this->community_id = $dr['community_id'];
        $this->user_id = $dr['user_id'];
        $this->role_id = $dr['role_id'];
        $this->statusflag = $dr['statusflag'];
        $this->last_updated = $dr['last_updated'];
    } 
}
