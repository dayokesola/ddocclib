<?php

namespace com\ddocc\halo\entity;

use com\ddocc\base\entity\EntityBase;

class Community extends EntityBase {
    var $id;
    var $community_name;
    var $parent_id;
    var $ancestor_id;
    var $community_slug;
    var $community_type_id;
    var $statusflag;
    var $last_updated; 

    function Set($dr) {
        $this->id = $dr['id'];
        $this->community_name = $dr['community_name'];
        $this->parent_id = $dr['parent_id'];
        $this->ancestor_id = $dr['ancestor_id'];
        $this->community_slug = $dr['community_slug'];        
        $this->community_type_id = $dr['community_type_id'];
        $this->statusflag = $dr['statusflag'];
        $this->last_updated = $dr['last_updated'];
    } 

}
