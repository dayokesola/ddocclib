<?php
/**
 * Created by PhpStorm.
 * User: okesolaa
 * Date: 2/21/15
 * Time: 7:53 AM
 */

namespace com\ddocc\market\service;
use com\ddocc\market\entity\Category;
use com\ddocc\base\utility\InfoBox;
use com\ddocc\base\utility\Gizmo;
use com\ddocc\base\utility\Connect;
use com\ddocc\base\utility\ImageResize;

class CategoryService {
    public static function AllCategories()
    {
        $sql = 'SELECT m.cate_id, m.cate_name, m.parent_id, p.cate_name AS parent_name , m.statusflag, m.date_added, m.last_updated
FROM tbl_mkt_cates m  LEFT JOIN tbl_mkt_cates p ON m.parent_id = p.cate_id
where m.cate_id > 1 order by m.cate_name';
        $cn = new Connect();
        $cn->SetSQL($sql);
        return $cn->SelectObject();
    }

    public static function GetParents($cate_id)
    {
        $sql = 'SELECT  cate_id,  cate_name FROM tbl_mkt_cates where cate_id != :cate_id  order by parent_id, cate_name';
        $cn = new Connect();
        $cn->SetSQL($sql);
        $cn->AddParam(':cate_id', $cate_id);
        return $cn->SelectObject();
    }


    public static function PostCreate($p)
    {
        $msg = '';
        if($p->cate_name == '') $msg .= '<li>Category name cannot be empty</li>';

        if($msg != '')
        {
            return new InfoBox(false,'<ul>' .$msg . '</ul>');
        }
        //check if one exist
        $xp = new Category();
        //load by name
        $xp->cate_name = $p->cate_name;
        $xp->LoadByName();
        if($xp->cate_id > 0){
            return new InfoBox(false,'Category name already exists');
        }
        $cnt = $p->Insert();
        if($cnt > 0) {
            return new InfoBox(true,'Category has been created');
        }
        else{
            return new InfoBox(false,'Category could not be created');
        }
        return new InfoBox();
    }

    public static function PostEdit($p)
    {
        $msg = '';
        if($p->cate_name == '') $msg .= '<li>Category name cannot be empty</li>';

        if($msg != '')
        {
            return new InfoBox(false,'<ul>' .$msg . '</ul>');
        }
        //check if one exist
        $xp = new Category();
        //load by name
        $xp->cate_name = $p->cate_name;
        $xp->LoadByName();
        if($xp->cate_id > 0 && $xp->cate_id != $p->cate_id){
            return new InfoBox(false,'Category name already exists');
        }


        $cnt = $p->Update();
        if($cnt > 0) {
            return new InfoBox(true,'Category has been updated');
        }
        else{
            return new InfoBox(false,'Category could not be updated');
        }
        return new InfoBox();
    }

    public static function PostImageSave($p)
    {
        //try to save the image
        if($p->cate_logo["tmp_name"] == ''){
            return new InfoBox(false,'No image uploaded');
        }
        if($p->cate_logo["type"] != 'image/jpeg')
        {
            return new InfoBox(false,'Upload only JPEG');
        }

        $check = Gizmo::GetImageSize($p->cate_logo["tmp_name"]);


        $img_l = MEDIALOC . 'cate/l/'. $p->cate_id . '.jpg';
        $img_m = MEDIALOC . 'cate/m/'. $p->cate_id . '.jpg';
        $img_s = MEDIALOC . 'cate/s/'. $p->cate_id . '.jpg';

        if($check !== false) {
            $resizeObj = new ImageResize($p->cate_logo["tmp_name"],$p->cate_logo["type"]);
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