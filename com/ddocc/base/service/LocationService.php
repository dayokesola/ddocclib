<?php
/**
 * Created by PhpStorm.
 * User: okesolaa
 * Date: 1/13/15
 * Time: 8:42 PM
 */

namespace com\ddocc\base\service;
use com\ddocc\base\utility\Connect;


class LocationService {
    public static function ActiveDialCodes()
    {
        $sql = "  SELECT CONCAT(c.country_name,' - ', d.dialcode_val) AS country_name, c.country_id, c.country_code, d.dialcode_val, d.dialcode_id
 FROM tbl_country_dialcodes cdc
 LEFT JOIN tbl_country c ON cdc.country_id = c.country_id
 LEFT JOIN tbl_dialcodes d ON cdc.dialcode_id = d.dialcode_id
 WHERE cdc.statusflag = 1 ORDER BY c.country_name";
        $cn = new Connect();
        $cn->SetSQL($sql);
        return $cn->SelectObject();
    }
} 