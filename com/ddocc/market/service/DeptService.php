<?php
/**
 * Created by PhpStorm.
 * User: okesolaa
 * Date: 2/16/15
 * Time: 8:53 PM
 */
namespace com\ddocc\market\service;
use com\ddocc\market\entity\Dept;
use com\ddocc\base\utility\InfoBox;
use com\ddocc\base\utility\Gizmo;
use com\ddocc\base\utility\Connect;
use com\ddocc\base\utility\ImageResize;

class DeptService {
    public static function AllDepts($sort = 2)
    {
        $sql = 'SELECT * FROM tbl_mkt_depts order by '. $sort;
        $cn = new Connect();
        $cn->SetSQL($sql);
        return $cn->SelectObject();
    }

    public static function DeptsByStore($store_id, $sort = 2)
    {
        $sql = 'SELECT * FROM tbl_mkt_depts
WHERE dept_id IN (SELECT dept_id FROM tbl_mkt_store_depts  WHERE store_id = :store_id)
 order by '. $sort;
        $cn = new Connect();
        $cn->SetSQL($sql);
        $cn->AddParam(':store_id', $store_id);
        return $cn->SelectObject();
    }

    public static function DeptsNotInStore($store_id, $sort = 2)
    {
        $sql = 'SELECT * FROM tbl_mkt_depts
WHERE dept_id NOT IN (SELECT dept_id FROM tbl_mkt_store_depts  WHERE store_id = :store_id)
 order by '. $sort;
        $cn = new Connect();
        $cn->SetSQL($sql);
        $cn->AddParam(':store_id', $store_id);
        return $cn->SelectObject();
    }

    public static function PostCreate($p)
    {
        $msg = '';
        if($p->dept_name == '') $msg .= '<li>Department name cannot be empty</li>';

        if($msg != '')
        {
            return new InfoBox(false,'<ul>' .$msg . '</ul>');
        }
        //check if one exist
        $xp = new Dept(0);
        //load by name
        $xp->dept_name = $p->dept_name;
        $xp->LoadByName();
        if($xp->dept_id > 0){
            return new InfoBox(false,'Department name already exists');
        }
        $cnt = $p->Insert();
        if($cnt > 0) {
            return new InfoBox(true,'Department has been created');
        }
        else{
            return new InfoBox(false,'Department could not be created');
        }
        return new InfoBox('','');
    }

    public static function PostEdit($p)
    {
        $msg = '';
        if($p->dept_name == '') $msg .= '<li>dept name cannot be empty</li>';

        if($msg != '')
        {
            return new InfoBox(false,'<ul>' .$msg . '</ul>');
        }
        //check if one exist
        $xp = new Dept(0);
        //load by name
        $xp->dept_name = $p->dept_name;
        $xp->LoadByName();
        if($xp->dept_id > 0 && $xp->dept_id != $p->dept_id){
            return new InfoBox(false,'dept name already exists');
        }


        $cnt = $p->Update();
        if($cnt > 0) {
            return new InfoBox(true,'dept has been updated');
        }
        else{
            return new InfoBox(false,'dept could not be updated');
        }
        return new InfoBox();
    }

    public static function PostImageSave($p)
    {
        //try to save the image
        if($p->dept_logo["tmp_name"] == ''){
            return new InfoBox(false,'No image uploaded');
        }
        if($p->dept_logo["type"] != 'image/jpeg')
        {
            return new InfoBox(false,'Upload only JPEG');
        }

        $check = Gizmo::GetImageSize($p->dept_logo["tmp_name"]);


        $img_l = MEDIALOC . 'dept/l/'. $p->dept_id . '.jpg';
        $img_m = MEDIALOC . 'dept/m/'. $p->dept_id . '.jpg';
        $img_s = MEDIALOC . 'dept/s/'. $p->dept_id . '.jpg';

        if($check !== false) {
            $resizeObj = new ImageResize($p->dept_logo["tmp_name"],$p->dept_logo["type"]);
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
} 