<?php

namespace com\ddocc\halo\controller;

use com\ddocc\base\controller\ControllerBase;
use com\ddocc\base\ui\Alert;
use com\ddocc\halo\service\CommunityUserService;
use com\ddocc\halo\service\CommunityService;
use com\ddocc\halo\dto\CommunityUserDTO;
use com\ddocc\base\service\SiteUserService;
use com\ddocc\base\utility\Gizmo;
use com\ddocc\halo\dto\CommunityDTO;
use com\ddocc\base\utility\Session;
use com\ddocc\halo\entity\CommunityUser;

class CommunityUserController extends ControllerBase {

    public function AddAdminGet($request) {
        $resp = array();
        $dto = new CommunityUserDTO();
        $comm = CommunityService::GetByID($request['get']['id']);
        if ($comm->id <= 0) {
            $resp['alert'] = new Alert('warning', 'Invalid Community Selected');
            $resp['dto'] = $dto;
            return $resp;
        }
        $dto->community_name = $comm->community_name;
        $dto->community_id = $comm->id;
        $resp['dto'] = $dto;
        return $resp;
    }

    public function AddAdminPost($request) {
        $dto = new CommunityUserDTO();
        $dto->community_id = $request['get']['id'];
        $dto->role_id = 1;
        $fields = array('email', 'statusflag', 'community_name');
        $v = $dto->SetPost($request['post'], $fields);
        $resp['dto'] = $dto;
        if ($v != '') {
            $resp['alert'] = new Alert('danger', $v);
            return $resp;
        }
        $su = SiteUserService::GetUserByUsername($dto->email);
        if ($su->user_id <= 0) {
            $resp['alert'] = new Alert('danger', 'Email address is not recognized');
            return $resp;
        }
        $dto->user_id = $su->user_id;
        $cu_search = CommunityUserService::Search($dto->community_id, $dto->user_id);
        if (count($cu_search) > 0) {
            $resp['alert'] = new Alert('danger', $dto->email . ' is already a member of this community');
            return $resp;
        }
        //$su->role_id = 3; //change to community admin
        //$k = SiteUserService::Update($su);
        $k = CommunityUserService::Update($dto);
        if ($k > 0) {
            $resp['alert'] = new Alert('success', $dto->email . ' has been added as admin to this community');
        } else {
            $resp['alert'] = new Alert('danger', $dto->email . ' could not be added');
        }
        return $resp;
    }

    public function ListAdminGet($request) {
        $resp = array();
        $dto = new CommunityUserDTO();
        $resp['dto'] = $dto;
        $dtos = CommunityUserService::Search($request['get']['id'], -1, 1);
        $resp['dtos'] = $dtos; 
        return $resp;
    }
    
    public function JoinsGet($request) {
        //only community admins can view this page
        $resp = array();
        $id = Gizmo::ToInt($request['get']['id']); 
        $su = Session::GetClass('authuser');
        $admin_role = 1;
        $dtousers = CommunityUserService::Search($id, $su->user_id, $admin_role, 1);   
        if(count($dtousers) <= 0)
        {
            $resp["view"] = "community/search";
            $resp["redirect"] = 1;
            return $resp;                
        }  
        $dtos = CommunityUserService::Search($id, 0, 0, 9);        
        $dto = CommunityService::GetByID($id);
        $resp["dtos"] = $dtos;        
        $resp["dto"] = $dto;
        return $resp;
    }
          
    public function JoinsPost($request) {
        $resp = array();
        $id = Gizmo::ToInt($request['get']['id']); 
        $su = Session::GetClass('authuser');
        $admin_role = 1;
        $dtousers = CommunityUserService::Search($id, Gizmo::ToInt($su->user_id), $admin_role, 1);   
        if(count($dtousers) <= 0) {
            $resp["view"] = "community/search";
            $resp["redirect"] = 1;
            return $resp;                
        }  
        if(!isset($request['post']['user_ids'])) {
            $resp['alert'] = new Alert('danger', 'No user has been checked');
        }
        else {
            $uids_authorized = -1;
            $action = Gizmo::ToString($request['post']['submit']);
            $user_ids = $request['post']['user_ids'];            
            if($action == 'Accept'){
                $uids_authorized = CommunityUserService::AcceptUsers($user_ids, $id);
                $resp['alert'] = new Alert('success', $uids_authorized. ' users accepted');
            }
            if($action == 'Reject'){
                $uids_authorized = CommunityUserService::RejectUsers($user_ids, $id);
                $resp['alert'] = new Alert('success', $uids_authorized. ' users rejected');
            }     
            if($uids_authorized == -1) {
                $resp['alert'] = new Alert('danger', 'No action selected');
            } 
        }          
        $dtos = CommunityUserService::Search($id, 0, 0, 9);        
        $dto = CommunityService::GetByID($id);
        $resp["dtos"] = $dtos;        
        $resp["dto"] = $dto;
        return $resp;
    }
}
