<?php 
namespace com\ddocc\base\controller; 
use com\ddocc\base\service\SystemService;
use com\ddocc\base\utility\Gizmo;
use com\ddocc\base\ui\Alert; 

class SystemController extends ControllerBase {
    //put your code here
    public function SqlGet() {
        $resp = array();
        $dtos = SystemService::GetTables();
        $resp['dtos'] = $dtos;
        $resp['cnt'] = 0;        
        $resp['data'] = array();
        $resp['sql'] = 'select ...'; 
        return $resp;
    }
    
    public function SqlPost($request) {
        $resp = array();
        $dtos = SystemService::GetTables();
        $resp['dtos'] = $dtos;
        $cnt = 0;
        $data = array();
        $sql = $request['post']['sql'];
        if(isset($request['post']['submit'])){
            $data = SystemService::SelectSQL($sql);
            $cnt = count($data);
        }
        if(isset($request['post']['export'])){
            $data = SystemService::SelectSQL($sql);
            $cnt = count($data);
            Gizmo::ExportToCSV($data);
            exit();
        }
        if(isset($request['post']['execute'])){ 
            $cnt = SystemService::ExecuteSQL($sql);
        }
        $resp['sql'] = $sql; 
        $resp['cnt'] = $cnt;        
        $resp['data'] = $data;
        $resp['alert'] = new Alert('info', $cnt ." records affected");
        return $resp;
    }
}
