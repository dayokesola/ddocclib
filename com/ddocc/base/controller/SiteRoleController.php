<?php
namespace com\ddocc\base\controller;
use com\ddocc\base\service\SiteRoleService;
use com\ddocc\base\ui\Alert; 
use com\ddocc\base\dto\SiteRoleDTO;

class SiteRoleController extends ControllerBase {
    
    public function IndexGet() {        
        $roles = SiteRoleService::AllRoles();
        $resp = array();        
        $resp['roles']= $roles;
        return $resp;
    }
    
    public function EditGet($request) {
        $i = SiteRoleService::GetByID($request['get']['id']);
        $resp = array();
        if (intval($i->role_id) <= 0) {
            $resp['view'] = 'site-role.index';
            $resp['redirect'] = '1';
        } else {
            $resp['role'] = $i;
        }
        return $resp;
    }

    public function EditPost($request) {
        $resp = array();
        $fields = array('role_name');
        $s = SiteRoleService::GetByID($request['get']['id']);
        $v = $s->SetPost($request['post'], $fields);
        if ($v != '') {
            $resp['alert'] = new Alert('danger', $v);
            return $resp;
        }
        $k = SiteRoleService::Update($s);
        if ($k > 0) {
            $resp['alert'] = new Alert('success', "Role has been updated");
        }
        $resp['role'] = $s;
        return $resp;
    }
    
    
    public function CreateGet() {
        $i = new SiteRoleDTO();
        $i->role_id = 0;
        $resp = array();
        $resp['dto'] = $i;
        return $resp;
    }

    public function CreatePost($request) {
        $resp = array();
        $fields = array('role_name');
        $dto = new SiteRoleDTO();
        $v = $dto->SetPost($request['post'], $fields);
        $resp['dto'] = $dto;
        if ($v != '') {
            $resp['alert'] = new Alert('danger', $v);
            return $resp;
        }
        $t = SiteRoleService::GetByName($dto->role_name);
        if ($t->role_id > 0) {
            $resp['alert'] = new Alert('danger', 'Role with this name already exists');
            return $resp;
        }        
        $k = SiteRoleService::Insert($dto);
        if ($k > 0) {
            $resp['alert'] = new Alert('success', "Role has been create");
        }
        return $resp;
    }
    
    public function FxnsGet($request) {        
        $fxns = SiteRoleService::AllRights($request['get']['id']);
        $resp = array();        
        $resp['fxns']= $fxns;
        return $resp;
    }
    
    public function FxnsPost($request) { 
        SiteRoleService::RemoveRoleFunctions($request['get']['id']);
        SiteRoleService::AddRoleFunctions($request['get']['id'], $request['post']['fxns']);
        SiteRoleService::PaintRoleMenu($request['get']['id']);
        $fxns = SiteRoleService::AllRights($request['get']['id']);
        $resp = array();        
        $resp['fxns']= $fxns;
        return $resp;
    }
}
