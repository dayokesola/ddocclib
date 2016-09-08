<?php

namespace com\ddocc\base\controller;

use com\ddocc\base\service\SiteTabService;
use com\ddocc\base\ui\Alert;

class SiteTabController {

    //put your code here
    public function IndexGet() {
        $resp = array();
        $dtos = SiteTabService::GetTabList(999);
        $resp['dtos'] = $dtos;
        $resp['dto'] = SiteTabService::NewTabGroup();
        return $resp;
    }

    public function CreateGet() {
        $dto = SiteTabService::NewTabGroup();
        $resp = array();
        $resp['dto'] = $dto;
        return $resp;
    }

    public function CreatePost($request) {
        $resp = array();
        $dto = SiteTabService::NewTabGroup();
        $fields = array('tab_ent', 'tab_text', 'var1', 'var2', 'var3', 'var4', 'var5');
        $v = $dto->SetPost($request['post'], $fields);
        $resp['dto'] = $dto;
        if ($v != '') {
            $resp['alert'] = new Alert('danger', $v);
            return $resp;
        }
        $t = SiteTabService::GetTabByID($dto->tab_id, $dto->tab_ent);
        if ($t->tab_id > 0) {
            $resp['alert'] = new Alert('danger', 'Tab Group [ID:' . $t->tab_ent . ' => ' . $t->tab_text . '] already exists');
            return $resp;
        }

        $k = SiteTabService::Insert($dto);
        if ($k > 0) {
            $resp['alert'] = new Alert('success', "Site Tab Group has been created");
        } else {
            $resp['alert'] = new Alert('danger', "Site Tab Group was not created, contact Admin");
        }
        $resp['dto'] = $dto;
        return $resp;
    }

    public function EditGet($request) {
        $dto = SiteTabService::GetTabByID(999, $request['get']['id']);
        $resp = array();
        if ($dto->tab_id <= 0) {
            $resp['view'] = 'site-tab.index';
            $resp['redirect'] = '1';
        } else {
            $resp['dto'] = $dto;
        }
        return $resp;
    }

    public function EditPost($request) {
        $resp = array();
        $fields = array('tab_text', 'var1', 'var2', 'var3', 'var4', 'var5');
        $dto = SiteTabService::GetTabByID(999, $request['get']['id']);
        $v = $dto->SetPost($request['post'], $fields);
        if ($v != '') {
            $resp['alert'] = new Alert('danger', $v);
            return $resp;
        }
        $k = SiteTabService::Update($dto);
        if ($k > 0) {
            $resp['alert'] = new Alert('success', "Site Tab Group has been updated");
        } else {
            $resp['alert'] = new Alert('danger', "Site Tab Group was not updated, contact Admin");
        }
        $resp['dto'] = $dto;
        return $resp;
    }

    public function DeleteGet($request) {
        $dto = SiteTabService::GetTabByID(999, $request['get']['id']);
        $resp = array();
        if ($dto->tab_id <= 0) {
            $resp['view'] = 'site-tab.index';
            $resp['redirect'] = '1';
        } else {
            $resp['dto'] = $dto;
        }
        return $resp;
    }

    public function DeletePost($request) {
        $resp = array();
        $dto = SiteTabService::GetTabByID(999, $request['get']['id']);
        $k = SiteTabService::Delete($dto);
        if ($k > 0) {
            $resp['alert'] = new Alert('success', "Site Tab Group has been deleted");
        } else {
            $resp['alert'] = new Alert('danger', "Site Tab Group could not be deleted");
        }
        $resp['dto'] = $dto;
        return $resp;
    }

    public function IndexEntryGet($request) {
        $resp = array();
        $id = 999;
        if (isset($request['get']['id'])) {
            $id = $request['get']['id'];
        } else {
            $resp['view'] = 'site-tab.index';
            $resp['redirect'] = '1';
            return $resp;
        }
        $dtos = SiteTabService::GetTabList($id);
        $resp['dtos'] = $dtos;        
        $resp['dto'] = SiteTabService::GetTabByID(999, $id);
        return $resp;
    }

    public function CreateEntryGet($request) {
        $dto = SiteTabService::NewTabEntry($request['get']['id']);
        $resp = array();
        $resp['dto'] = $dto;
        return $resp;
    }

    public function CreateEntryPost($request) {
        $resp = array();
        $dto = SiteTabService::NewTabEntry($request['get']['id']);
        $fields = array('tab_ent', 'tab_text', 'var1', 'var2', 'var3', 'var4', 'var5');
        $v = $dto->SetPost($request['post'], $fields);
        $resp['dto'] = $dto;
        if ($v != '') {
            $resp['alert'] = new Alert('danger', $v);
            return $resp;
        }
        $t = SiteTabService::GetTabByID($dto->tab_id, $dto->tab_ent);
        if ($t->tab_id > 0) {
            $resp['alert'] = new Alert('danger', 'Tab Entry [ID:' . $t->tab_ent . ' => ' . $t->tab_text . '] already exists');
            return $resp;
        }

        $k = SiteTabService::Insert($dto);
        if ($k > 0) {
            $resp['alert'] = new Alert('success', "Site Tab Entry has been created");
        } else {
            $resp['alert'] = new Alert('danger', "Site Tab Entry was not created, contact Admin");
        }
        $resp['dto'] = $dto;
        return $resp;
    }

    public function EditEntryGet($request) {
        $dto = SiteTabService::GetTabByID($request['get']['id'],$request['get']['ent']);
        $resp = array();
        if ($dto->tab_id <= 0) {
            $resp['view'] = 'site-tab.index';
            $resp['redirect'] = '1';
        } else {
            $resp['dto'] = $dto;
        }
        
         $resp['tab'] = SiteTabService::GetTabByID(999,$request['get']['id']);
        return $resp;
    }

    public function EditEntryPost($request) {
        $resp = array();
        $fields = array('tab_text', 'var1', 'var2', 'var3', 'var4', 'var5');
        $dto = SiteTabService::GetTabByID($request['get']['id'],$request['get']['ent']);
        $v = $dto->SetPost($request['post'], $fields);
         $resp['tab'] = SiteTabService::GetTabByID(999,$request['get']['id']);
        if ($v != '') {
            $resp['alert'] = new Alert('danger', $v);
            return $resp;
        }
         
        
        $k = SiteTabService::Update($dto);
        if ($k > 0) {
            $resp['alert'] = new Alert('success', "Site Tab Entry has been updated");
        } else {
            $resp['alert'] = new Alert('danger', "Site Tab Entry was not updated, contact Admin");
        }
        $resp['dto'] = $dto;
        return $resp;
    }

    public function DeleteEntryGet($request) {
        $dto = SiteTabService::GetTabByID(999, $request['get']['id']);
        $resp = array();
        if ($dto->tab_id <= 0) {
            $resp['view'] = 'site-tab.index';
            $resp['redirect'] = '1';
        } else {
            $resp['dto'] = $dto;
        }
        return $resp;
    }

    public function DeleteEntryPost($request) {
        $resp = array();
        $dto = SiteTabService::GetTabByID(999, $request['get']['id']);
        $k = SiteTabService::Delete($dto);
        if ($k > 0) {
            $resp['alert'] = new Alert('success', "Site Tab Group has been deleted");
        } else {
            $resp['alert'] = new Alert('danger', "Site Tab Group could not be deleted");
        }
        $resp['dto'] = $dto;
        return $resp;
    }

}
