<?php

namespace com\yum;

use com\ddocc\base\utility\Gizmo;

class CodeService {

    public static function GetCode($entity, $code) {
        $view = CodeService::$$code;
        $view = Gizmo::Replace("%PAGETITLE%", NameService::PageTitle($entity), $view);
        $view = Gizmo::Replace("%ENTITY%", $entity, $view);
        $view = Gizmo::Replace("%VARNAME%", NameService::VarName($entity), $view);
        $view = Gizmo::Replace("%CLASS%", NameService::EntityName($entity), $view);
        $view = Gizmo::Replace("%APP%", APP, $view);
        $view = Gizmo::Replace("%CLASSSERVICE%", NameService::ServiceName($entity), $view);
        $view = Gizmo::Replace("%CLASSCONTROLLER%", NameService::ControllerName($entity), $view);
        $view = Gizmo::Replace("%CLASSDTO%", NameService::DTOName($entity), $view);
        return $view;
    }
 

    public static $class_entity = '<?php

namespace com\%APP%\entity;

use com\ddocc\base\entity\EntityBase;

class %CLASS% extends EntityBase {

    var $id;
    var $%VARNAME%_name;
    var $%VARNAME%_slug;
    var $created_at;
    var $updated_at;
    var $statusflag;

    function Set($dr, $entity = "") {
        $this->id = $dr[$entity . "id"];
        $this->%VARNAME%_name = $dr[$entity . "%VARNAME%_name"];
        $this->%VARNAME%_slug = $dr[$entity . "%VARNAME%_slug"];
        $this->created_at = $dr[$entity . "created_at"];
        $this->updated_at = $dr[$entity . "updated_at"];
        $this->statusflag = $dr[$entity . "statusflag"];
    }
}
                ';
    public static $class_dto = '<?php
namespace com\%APP%\dto;
use com\%APP%\entity\%CLASS%;

class %CLASS%DTO extends %CLASS% {
    var $statustext;
    
    function Set($dr, $entity = "")
    {
        parent::Set($dr, $entity);
        $this->statustext = $dr[$entity . "statustext"]; 
    } 
    
    function Rules() {
        $rules = array(
            "required" => array(
                "%VARNAME%_name" => "yes",
                "%VARNAME%_slug" => "yes", 
            ),
            "length" => array(
                "%VARNAME%_name" => "128",
                "%VARNAME%_slug" => "64",
            ),
            "numeric" => array( 
            ),
        );
        return $rules;
    }    
    var $labels = array(
        "id" => "%PAGETITLE% ID",
        "%VARNAME%_name" => "%PAGETITLE% Name",
        "%VARNAME%_slug" => "%PAGETITLE% Slug",
        "statusflag" => "Status Flag",        
        "statustext" => "Status Text",
        "updated_at" => "Last Updated",
        "created_at" => "Date Added",
    );
    
    function PaintNameSlug(){
        return $this->%VARNAME%_name . " [". $this->%VARNAME%_slug ."]";
        
    }
    function PaintColumn($cnt){
        return "";
        
    }
    function PaintRows(){
        return "";        
    }
    function PaintSummary(){
        return "";        
    }
    function PaintDetail(){
        return "";        
    }
}

                ';
    public static $class_service = '<?php

namespace com\%APP%\service;

use com\ddocc\base\utility\Connect;
use com\ddocc\base\utility\Gizmo;
use com\%APP%\dto\%CLASS%DTO;

class %CLASSSERVICE% {

    public static $base_sql = "SELECT... ";

    public static function List%CLASS%s() {
        $sql = %CLASSSERVICE%::$base_sql;
        $cn = new Connect();
        $cn->SetSQL($sql);
        $ds = $cn->Select();
        $items = array();
        if ($cn->num_rows > 0) {
            foreach ($ds as $dr) {
                $item = new %CLASSDTO%();
                $item->Set($dr);
                $items[$item->id] = $item;
            }
        }
        return $items;
    }

    public static function New%CLASS%() {
        $b = new %CLASSDTO%();
        $b->id = 0;
        return $b;
    }
    
    public static function Get%CLASS%ById($id) {
        $sql = %CLASSSERVICE%::$base_sql . " where %VARNAME%.id = :%VARNAME%_id ";
        $cn = new Connect();
        $cn->SetSQL($sql);
        $cn->AddParam(":%VARNAME%_id", $id); 
        $ds = $cn->Select();
        $item = new %CLASSDTO%();
        $item->id = 0;
        if ($cn->num_rows > 0) {
            $item->Set($ds[0]);
        }
        return $item;
    }
    
    public static function Get%CLASS%ByName($name) {
        $sql = %CLASSSERVICE%::$base_sql . " where %VARNAME%.%VARNAME%_name = :%VARNAME%_name ";
        $cn = new Connect();
        $cn->SetSQL($sql);
        $cn->AddParam(":%VARNAME%_name", $name); 
        $ds = $cn->Select();
        $item = new %CLASSDTO%();
        $item->id = 0;
        if ($cn->num_rows > 0) {
            $item->Set($ds[0]);
        }
        return $item;
    }

    public static function Get%CLASS%ByNameOrSlug($item) {
        $sql = %CLASSSERVICE%::$base_sql . " where %VARNAME%.%VARNAME%_name = :%VARNAME%_name or %VARNAME%.%VARNAME%_slug = :%VARNAME%_slug";
        $cn = new Connect();
        $cn->SetSQL($sql);
        $cn->AddParam(":%VARNAME%_name", Gizmo::ToLower($item->%VARNAME%_name));
        $cn->AddParam(":%VARNAME%_slug", Gizmo::ToLower($item->%VARNAME%_slug));
        $ds = $cn->Select();
        $item = new %CLASSDTO%();
        $item->id = 0;
        if ($cn->num_rows > 0) {
            $item->Set($ds[0]);
        }
        return $item;
    }

    public static function Insert%CLASS%($item) {
        $sql = " ";
        $cn = new Connect();
        $cn->SetSQL($sql); 
        $item->id = $cn->Insert();
        return $item;
    }

    public static function Update%CLASS%($item) {
        $sql = " ";
        $cn = new Connect();
        $cn->SetSQL($sql); 
        return $cn->Update();
    }

    public static function Delete%CLASS%($item) {
        $sql = " ";
        $cn = new Connect();
        $cn->SetSQL($sql); 
        return $cn->Delete(); 
    }

    public static function Search%CLASS%s($item) {
        $sql = " ";
        $cn = new Connect();
        $cn->SetSQL($sql); 
        $ds = $cn->Select();
        $items = array();
        if ($cn->num_rows > 0) {
            foreach ($ds as $dr) {
                $item = new %CLASSDTO%();
                $item->Set($dr);
                $items[] = $item;
            }
        }
        return $items;
    }
}

                ';
    public static $class_controller = '<?php
namespace com\%APP%\controller;

use com\ddocc\base\controller\ControllerBase;
use com\ddocc\base\ui\Alert; 
use com\ddocc\base\utility\Gizmo;
use com\%APP%\service\%CLASSSERVICE%;

class %CLASSCONTROLLER%  extends ControllerBase {
    //put your code here
    public function IndexGet() {
        $resp = array();
        $resp["dtos"] = %CLASSSERVICE%::List%CLASS%s(); 
        $resp["dto"] = %CLASSSERVICE%::New%CLASS%();
        return $resp;
    }
    public function CreateGet() {
        $resp = array();
        $resp["dto"] = %CLASSSERVICE%::New%CLASS%();
        return $resp;
    }
    
    public function CreatePost($request) {
        $resp = array(); 
        $dto = %CLASSSERVICE%::New%CLASS%();
        $fields = array("%VARNAME%_name", "%VARNAME%_slug");
        $v = $dto->SetPost($request["post"], $fields);
        $resp["dto"] = $dto;
        if ($v != "") {
            $resp["alert"] = new Alert("danger", $v);
            return $resp;
        } 
        $t = %CLASSSERVICE%::Get%CLASS%ByNameOrSlug($dto);
        if ($t->id > 0) {
            $resp["alert"] = new Alert("danger", "%PAGETITLE% with this name/slug already exists - " . $t->PaintNameSlug());
            return $resp;
        }
        $dto->created_at = Gizmo::Now();
        $dto->statusflag = 1;
        $dto = %CLASSSERVICE%::Insert%CLASS%($dto);
        if ($dto->id > 0) { 
            $resp["alert"] = new Alert("success", "%PAGETITLE% has been created successfully");  
        } 
        else {
            $resp["alert"] = new Alert("danger", "%PAGETITLE% could not be created, contact admin");
        }
        $resp["dto"] = $dto;
        return $resp;
    }
    
    public function EditGet($request) {
        $resp = array();
        $id = $request["get"]["id"];
        return $resp;
    }
    
    public function EditPost($request) {
        $resp = array(); 
        $id = $request["get"]["id"];
        return $resp;
    }
    
    public function DeleteGet($request) {
        $resp = array(); 
        $id = $request["get"]["id"];
        return $resp;
    }
    
    public function DeletePost($request) {
        $resp = array(); 
        $id = $request["get"]["id"];
        return $resp;
    }
    
    public function SearchGet($request) {
        $resp = array(); 
        return $resp;
    }
    
    public function SearchPost($request) {
        $resp = array(); 
        return $resp;
    }
}

                ';
    public static $view_create = '<?php 
$page->Paint("New %PAGETITLE%"); 
$page->PageHeader(); 
?>
<div class="row" >  
    <div class="col-md-4" >        
        <?php $page->Alert(); ?>
        <div class="panel panel-default">            
            <div class="panel-body">
                <?php
                $form->Start("%ENTITY%_create");
                $form->Hidden("id", $dto->id);                               
                $form->Submit("submit", "Submit");
                $form->Close();
                ?>
            </div>
        </div>
    </div>
</div>
                ';
    public static $view_edit = '<?php 
$page->Paint("Edit %PAGETITLE%"); 
$page->PageHeader(); 
?>
<div class="row" >  
    <div class="col-md-4" >        
        <?php $page->Alert(); ?>
        <div class="panel panel-default">            
            <div class="panel-body">
                <?php
                $form->Start("%ENTITY%_edit");
                $form->Hidden("id", $dto->id);                               
                $form->Submit("submit", "Submit");
                $form->Close();
                ?>
            </div>
        </div>
    </div>
</div>
                ';
    public static $view_delete = '<?php 
$page->Paint("Delete %PAGETITLE%"); 
$page->PageHeader(); 
?>
<div class="row" >  
    <div class="col-md-4" >        
        <?php $page->Alert(); ?>
        <div class="panel panel-default">            
            <div class="panel-body">
                <?php
                $form->Start("%ENTITY%_delete");
                $form->Hidden("id", $dto->id);                               
                $form->Submit("submit", "Submit");
                $form->Close();
                ?>
            </div>
        </div>
    </div>
</div>
                ';
    public static $view_index = '<?php
$page->Paint("All %PAGETITLE%s");
$page->PageHeader();
?>
<div class="row">
    <div class="col-md-12">
        <table class="table table-condensed table-bordered small">
            <tr>
                <th><?= $dto->labels["%VARNAME%_name"] ?> 
                    (<a class="btn btn-xs btn-link" href="<?= Url("%ENTITY%.create") ?>">New %PAGETITLE%?</a>)</th>
                <th><?= $dto->labels["%VARNAME%_slug"] ?></th>   
                <th><?= $dto->labels["statustext"] ?></th> 
                <th>Action </th>
            </tr>
            <?php foreach ($dtos as $dto) { ?>
                <tr>
                    <td><?= $dto->%VARNAME%_name ?></td>
                    <td><?= $dto->%VARNAME%_slug ?></td> 
                    <td><?= $dto->statustext ?></td>
                    <td>
                        <div class="btn-group" role="group">
                            <a class="btn btn-xs btn-default" href="<?= UrlID("%ENTITY%.edit", $dto->id) ?>">Edit</a>
                            <a class="btn btn-xs btn-danger" href="<?= UrlID("%ENTITY%.delete", $dto->id) ?>">Delete</a>
                        </div>
                    </td>
                </tr>
            <?php } ?>
        </table>
    </div>
</div>
                ';

}
