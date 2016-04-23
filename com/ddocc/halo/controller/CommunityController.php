<?php

namespace com\ddocc\halo\controller;

use com\ddocc\base\controller\ControllerBase;
use com\ddocc\base\ui\Alert;
use com\ddocc\halo\service\CommunityService;
use com\ddocc\halo\service\CommunityUserService;
use com\ddocc\halo\dto\CommunityDTO;
use com\ddocc\halo\entity\Community;
use com\ddocc\halo\dto\CommunityUserDTO;
use com\ddocc\halo\entity\CommunityUser;
use com\ddocc\base\utility\Session;
use com\ddocc\base\utility\Gizmo;
class CommunityController extends ControllerBase {

    public function SearchGet() {
        $resp = array();
        $dtos = CommunityService::Search('', '', -1, 1, 12);
        shuffle($dtos);
        $resp['dtos'] = $dtos;
        return $resp;
    }
    
    public function SearchPost($request) {
        $resp = array();
        $dtos = CommunityService::Search('', '', -1, 1, 12);
        shuffle($dtos);
        $resp['dtos'] = $dtos;
        if(isset($request['post']) && isset($request['post']['q']))
        {
            $q = $request['post']['q'];
            if($q != ''){
                $items = CommunityService::Search($q,'',-1,1);   
            }
            else {
                $items = array();
            }
        }        
        $resp['items'] = $items;
        return $resp;
    }     

    public function IndexGet() {
        $resp = array();
        $dto = new CommunityDTO();
        $resp['dto'] = $dto; 
        $dtos = CommunityService::Search('', '', 0, 1);
        dd($dtos);
        $resp['dtos'] = $dtos;
        return $resp;
    }

    public function CreateGet($request) {
        $resp = array();
        $s = CommunityService::GetByHost();
        $dto = new CommunityDTO();
        $dto->ancestor_id = $s->id;  
        if(isset($request["get"]["pid"])){
            $dto->parent_id = Gizmo::ToInt($request["get"]["pid"]);
        } else {
            $dto->parent_id = 0;            
        }
        $resp['dto'] = $dto;
        return $resp;
    }
    
    public function CreatePost($request) {
        $resp = array();
        $dto = new CommunityDTO();
        $fields = array('community_name', 'parent_id', 'community_slug','ancestor_id');
        $v = $dto->SetPost($request['post'], $fields);
        $resp['dto'] = $dto;
        if ($v != '') {
            $resp['alert'] = new Alert('danger', $v);
            return $resp;
        }
         
        $t = CommunityService::GetByName($dto->community_name);
        if ($t->id > 0) {
            $resp['alert'] = new Alert('danger', 'Community with this name already exists');
            return $resp;
        }
        $s = CommunityService::GetBySlug($dto->community_slug);
        if ($s->id > 0) {
            $resp['alert'] = new Alert('danger', 'Community with this alias/slug already exists');
            return $resp;
        }
        $dto->statusflag = 1;
        
        $su = Session::GetClass('authuser'); 
        
        $k = CommunityService::Insert($dto);
        if ($k > 0) { 
            $resp['alert'] = new Alert('success', "Community has been created successfully");            
            if ($su->role_id == 1) { //admins create top level groups
                $dto->id = $k;
                $dto->ancestor_id = $k;
                $dto->parent_id = $k;
                $dto->community_type = 1;
                CommunityService::Update($dto);
            }
        } 
        else{
            $resp['alert'] = new Alert('danger', "Community could not be created, contact admin");
        }
        return $resp;
    }
      
    public function ListGet() {
        $resp = array();        
        $su = Session::GetClass('authuser'); 
        $dto = new CommunityUserDTO();
        $resp['dto'] = $dto;
        $dtos = CommunityUserService::Search(0, $su->user_id, 0, 0);
        $resp['dtos'] = $dtos;
        return $resp;
    }
    
    public function DetailGet($request) {
        $resp = array();
        $dto = new CommunityDTO();
        $dto->id = 0;
        $dtouser = new CommunityUserDTO();
        $dtouser->community_id = 0;
        $id = Gizmo::ToInt($request['get']['id']);         
        $dtos = CommunityService::Search('', '', -1, 1, 0, $id);   
        if(count($dtos) > 0)
        {
            $dto = $dtos[0];                
        }
        else
        {
            $resp["view"] = "community/search";
            $resp["redirect"] = 1;
            return $resp;
        }
        $su = Session::GetClass('authuser'); 
        $dtousers = CommunityUserService::Search($dto->id, $su->user_id);
        if(count($dtousers) > 0)
        {
            $dtouser = $dtousers[0];
        } 
        $resp['dto'] = $dto;
        $resp['dtouser'] = $dtouser;
        return $resp;
    }
    
}
