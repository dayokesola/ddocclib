<?php
/**
 * Created by PhpStorm.
 * User: okesolaa
 * Date: 2/5/15
 * Time: 7:01 PM
 */

namespace com\ddocc\market\service;


use com\ddocc\base\utility\Connect;
use com\ddocc\base\utility\ImageResize;
use com\ddocc\base\utility\InfoBox;
use com\ddocc\base\utility\Gizmo;
use com\ddocc\market\entity\Store;
use com\ddocc\market\entity\Dept;
class StoreService {

    public static function AllStores()
    {
        $sql = 'SELECT * FROM tbl_mkt_stores';
        $cn = new Connect();
        $cn->SetSQL($sql);
        return $cn->SelectObject();
    }

    public static function PostCreate($p)
    {
        $msg = '';
        if($p->store_name == '') $msg .= '<li>Store name cannot be empty</li>';
        if($p->store_email == '') $msg .= '<li>Store email cannot be empty</li>';
        if(!Gizmo::IsEmailValid($p->store_email))  $msg .= '<li>Store email is not valid</li>';

        if($msg != '')
        {
            return new InfoBox(false,'<ul>' .$msg . '</ul>');
        }
        //check if one exist
        $xp = new Store();
        //load by name
        $xp->store_name = $p->store_name;
        $xp->LoadByName();
        if($xp->store_id > 0){
            return new InfoBox(false,'store name already exists');
        }
        //load by alias
        $xp->store_alias = $p->store_alias;
        $xp->LoadByAlias();
        if($xp->store_id > 0){
            return new InfoBox(false,'store alias already exists');
        }

        $cnt = $p->Insert();
        if($cnt > 0) {
            return new InfoBox(true,'store has been created');
        }
        else{
            return new InfoBox(false,'store could not be created');
        }
        return new InfoBox('','');
    }

    public static function PostImageSave($p)
    {
        //try to save the image
        if($p->store_logo["tmp_name"] == ''){
             return new InfoBox(false,'No image uploaded');
        }
        if($p->store_logo["type"] != 'image/jpeg')
        {
            return new InfoBox(false,'Upload only JPEG');
        }

        $check = Gizmo::GetImageSize($p->store_logo["tmp_name"]);


        $img_l = MEDIALOC . 'store/l/'. $p->store_id . '.jpg';
        $img_m = MEDIALOC . 'store/m/'. $p->store_id . '.jpg';
        $img_s = MEDIALOC . 'store/s/'. $p->store_id . '.jpg';

        if($check !== false) {
            $resizeObj = new ImageResize($p->store_logo["tmp_name"],$p->store_logo["type"]);
            $resizeObj -> resizeImage(300, 300, 'crop');
            $resizeObj -> saveImage($img_l, 100);
            $resizeObj -> resizeImage(200, 200, 'crop');
            $resizeObj -> saveImage($img_m, 100);
            $resizeObj -> resizeImage(100, 100, 'crop');
            $resizeObj -> saveImage($img_s, 100);

            return new InfoBox(true,'Image has been saved');
         }
        else{
            return new InfoBox(false,'No image uploaded');
        }
    }

    public static function PostEdit($p)
    {
        $msg = '';
        if($p->store_name == '') $msg .= '<li>Store name cannot be empty</li>';
        if($p->store_email == '') $msg .= '<li>Store email cannot be empty</li>';
        if(!Gizmo::IsEmailValid($p->store_email))  $msg .= '<li>Store email is not valid</li>';

        if($msg != '')
        {
            return new InfoBox(false,'<ul>' .$msg . '</ul>');
        }
        //check if one exist
        $xp = new Store();
        //load by name
        $xp->store_name = $p->store_name;
        $xp->LoadByName();
        if($xp->store_id > 0 && $xp->store_id != $p->store_id){
            return new InfoBox(false,'store name already exists');
        }
        //load by alias
        $xp->store_alias = $p->store_alias;
        $xp->LoadByAlias();
        if($xp->store_id > 0 && $xp->store_id != $p->store_id){
            return new InfoBox(false,'store alias already exists');
        }

        $cnt = $p->Update();
        if($cnt > 0) {
            return new InfoBox(true,'store has been updated');
        }
        else{
            return new InfoBox(false,'store could not be updated');
        }
        return new InfoBox();
    }

    public static function PostAddDepts($p)
    {
        $msg = '';
        if(count($p->dept_ids)<= 0) $msg .= '<li>No department selected</li>';
        if($msg != '')
        {
            return new InfoBox(false,'<ul>' .$msg . '</ul>');
        }
        $cnt = 0;
        foreach($p->dept_ids as $dept_id)
        {
            $d = new Dept($dept_id);
            if($d->dept_id > 0)
            {
                $cnt += StoreService::AddDepartmentToStore($p->store_id, $d->dept_id);
            }
        }
        if($cnt > 0){
            return new InfoBox(true,$cnt . ' department(s) added successfully');
        }
        else{
            return new InfoBox(false,'No department was added');
        }
    }

    public static function AddDepartmentToStore($store_id, $dept_id)
    {
        $sql = 'insert into tbl_mkt_store_depts(store_id, dept_id) values (:store_id, :dept_id)';
        $cn = new Connect();
        $cn->SetSQL($sql);
        $cn->AddParam(':store_id', $store_id);
        $cn->AddParam(':dept_id', $dept_id);
        return $cn->Update();
    }

    public static function PostRemoveDepts($p)
    {
        $msg = '';
        if(count($p->dept_ids)<= 0) $msg .= '<li>No department selected</li>';
        if($msg != '')
        {
            return new InfoBox(false,'<ul>' .$msg . '</ul>');
        }
        $cnt = 0;
        foreach($p->dept_ids as $dept_id)
        {
            $d = new Dept($dept_id);
            if($d->dept_id > 0)
            {
                $cnt += StoreService::RemoveDepartmentFromStore($p->store_id, $d->dept_id);
            }
        }
        if($cnt > 0){
            return new InfoBox(true,$cnt . ' department(s) removed successfully');
        }
        else{
            return new InfoBox(false,'No department was removed');
        }
    }

    public static function RemoveDepartmentFromStore($store_id, $dept_id)
    {
        $sql = 'delete from tbl_mkt_store_depts where store_id = :store_id and dept_id = :dept_id';
        $cn = new Connect();
        $cn->SetSQL($sql);
        $cn->AddParam(':store_id', $store_id);
        $cn->AddParam(':dept_id', $dept_id);
        return $cn->Delete();
    }
} 