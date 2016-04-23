<?php
namespace com\ddocc\cms\service;
use com\ddocc\base\utility\Connect;
use com\ddocc\base\utility\InfoBox;
Class CmsComponentService
{
    public static function AllComponents()
    {
        $sql = "SELECT * FROM ez_components order by component_name   ";
        $cn = new Connect();
        $cn->SetSQL($sql);
        return $cn->SelectObject();
    }

    private static $sql_GetComponentsByTemplate = "
           SELECT c.component_id, c.component_name,c.component_method,c.last_updated,c.component_code
, tc.template_id FROM ez_components c
LEFT JOIN ez_template_components tc
ON c.component_id = tc.component_id
AND tc.template_id = :id ";

    public static function GetComponentsByTemplate($id)
    {
        $cn = new Connect();
        $cn->SetSQL(self::$sql_GetComponentsByTemplate);
        $cn->AddParam(":id", $id);
        return $cn->SelectObject();
    }

    public static function GetComponentsByTemplateDS($id)
    {
        $cn = new Connect();
        $cn->SetSQL(self::$sql_GetComponentsByTemplate);
        $cn->AddParam(":id", $id);
        return $cn->Select();
    }

    public static function RemoveComponentsByTemplate($id)
    {
        $sql = "Delete FROM ez_template_components where template_id = :id";
        $cn = new Connect();
        $cn->SetSQL($sql);
        $cn->AddParam(":id", $id);
        return $cn->Update();
    }

    public static function AddTemplateToComponent($t,$c)
    {
        $sql = "insert into ez_template_components (template_id,component_id) values (:t,:c)";
        $cn = new Connect();
        $cn->SetSQL($sql);
        $cn->AddParam(":t", $t);
        $cn->AddParam(":c", $c);
        return $cn->Update();
    }

    public static function PostCreate($p)
    {
        $msg = '';
        if($p->component_name == '') $msg .= '<li>Component name cannot be empty</li>';
        if($msg != '')
        {
            return new InfoBox(false,'<ul>' .$msg . '</ul>');
        }
        //check if one exist
        $xp = new CmsComponent();
        $xp->component_name = $p->component_name;
        $xp->LoadByName();
        if($xp->component_id > 0){
            return new InfoBox(false,'Component name already exists');
        }

        $cnt = $p->Insert();
        if($cnt > 0) {
            return new InfoBox(true,'Component has been created');
        }
        else{
            return new InfoBox(false,'Component could not be created');
        }
        return new InfoBox('','');
    }

    public static function PostEdit($p)
    {
        //validate
        $msg = '';
        if($p->component_name == '') $msg .= '<li>component name cannot be empty</li>';
        if($p->component_method == '') $msg .= '<li>component method cannot be empty</li>';
        if($p->component_code == '') $msg .= '<li>component code cannot be empty</li>';

        if($msg != '')
        {
            return new InfoBox(false,'<ul>' .$msg . '</ul>');
        }

        $cnt = $p->Update();
        if($cnt > 0) {
            return new InfoBox(true,'Component has been updated');
        }
        else{
            return new InfoBox(false,'Component could not be updated');
        }
        return new InfoBox('','');
    }

}
