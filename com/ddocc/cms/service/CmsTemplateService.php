<?php
namespace com\ddocc\cms\service;
use com\ddocc\base\utility\Connect;
use com\ddocc\base\utility\InfoBox;
Class CmsTemplateService
{
    public static function GetTemplates()
    {
        $sql = "SELECT * FROM ez_templates order by template_name   ";
        $cn = new Connect();
        $cn->SetSQL($sql);
        return $cn->SelectObject();
    }

    public static function GetTemplatesDS()
    {
        $sql = "SELECT * FROM ez_templates order by template_name   ";
        $cn = new Connect();
        $cn->SetSQL($sql);
        return $cn->Select();
    }

}