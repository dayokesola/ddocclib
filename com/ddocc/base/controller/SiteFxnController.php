<?php

namespace com\ddocc\base\controller;

use com\ddocc\base\service\SiteFxnService;
use com\ddocc\base\ui\Alert;

class SiteFxnController {

    //put your code here
    public function IndexGet() {
        $fxns = SiteFxnService::AllFunctions();
        $resp = array();
        $resp['fxns'] = $fxns;
        return $resp;
    }

    public function EditGet($request) {
        $fxn = SiteFxnService::GetByID($request['get']['id']);
        $resp = array();
        if (intval($fxn->fxn_id) <= 0) {
            $resp['view'] = 'site-fxn.index';
            $resp['redirect'] = '1';
        } else {
            $resp['fxn'] = $fxn;
        }
        return $resp;
    }

    public function EditPost($request) {
        $resp = array();
        $fields = array('fxn_name', 'fxn_url', 'fxn_group', 'fxn_sort', 'fxn_flag', 'fxn_secure', 'fxn_icon');
        $s = SiteFxnService::GetByID($request['get']['id']);
        $v = $s->SetPost($request['post'], $fields);
        if ($v != '') {
            $resp['alert'] = new Alert('danger', $v);
            return $resp;
        }
        $k = SiteFxnService::Update($s);
        if ($k > 0) {
            $resp['alert'] = new Alert('success', "Function has been updated");
        }
        $resp['fxn'] = $s;
        return $resp;
    }

    public function DeleteGet($request) {
        $fxn = SiteFxnService::GetByID($request['get']['id']);
        $resp = array();
        if (intval($fxn->fxn_id) <= 0) {
            $resp['view'] = 'site-fxn.index';
            $resp['redirect'] = '1';
        } else {
            $resp['fxn'] = $fxn;
        }
        return $resp;
    }

    public function DeletePost($request) {
        $resp = array();
        $fields = array('fxn_name');
        $s = SiteFxnService::GetByID($request['get']['id']);
        $v = $s->SetPost($request['post'], $fields);
        if ($v != '') {
            $resp['alert'] = new Alert('danger', $v);
            return $resp;
        }
        $k = SiteFxnService::DeleteFxn($s);
        if ($k > 0) {
            $resp['alert'] = new Alert('success', "Function has been deleted");
        } else {
            $resp['alert'] = new Alert('danger', "Function could not be deleted");
        }
        $resp['fxn'] = $s;
        return $resp;
    }
}
