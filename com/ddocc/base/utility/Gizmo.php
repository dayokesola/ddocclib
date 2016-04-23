<?php

/**
 * Created by PhpStorm.
 * User: okesolaa
 * Date: 12/26/14
 * Time: 8:35 PM
 */

namespace com\ddocc\base\utility;

class Gizmo {

    public static function Clean($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

    public static function BringUp($str) {
        $r = "";
        $bits = explode('-', $str);
        foreach ($bits as $bit) {
            $r .= ucwords($bit);
        }
        return $r;
    }

    public static function Url($str, $id = '') {
        $str = str_replace('.', "/", $str);
        if ($id != '') {
            $str .= '&id=' . $id;
        }
        return 'index.php?r=' . $str;
    }

    //put your code here
    public static function QSGetInt($key) {
        $id = 0;
        if ($_GET && isset($_GET[$key])) {
            $id = $_GET[$key];
        }
        return $id;
    }

    public static function GetImageSize($loc) {
        return getimagesize($loc);
    }

    public static function FileExists($loc) {
        return file_exists($loc);
    }

    public static function QSGetString($key, $otherwise = '') {
        $id = $otherwise;
        if ($_GET && isset($_GET[$key])) {
            $id = $_GET[$key];
        }
        return $id;
    }

    public static function ToInt($key) {
        return (int) $key;
    }

    public static function ToLower($key) {
        return strtolower($key);
    }

    public static function ToString($key) {
        return $key;
    }

    public static function Replace($find_str, $replace_str, $main_str) {
        return str_replace($find_str, $replace_str, $main_str);
    }

    public static function Random($length) {
        if ($length > 0) {
            $rand_id = "";
            for ($i = 1; $i <= $length; $i++) {
                mt_srand((double) microtime() * 1000000);
                $num = mt_rand(1, 62);
                $rand_id .= Gizmo::GetChar($num);
            }
        }
        return $rand_id;
    }

    public static function IsEmailValid($email) {
        return preg_match("/([\w\-]+\@[\w\-]+\.[\w\-]+)/", $email);
    }

    public static function StartsWith($haystack, $needle) {
        return $needle === "" || strpos($haystack, $needle) === 0;
    }

    public static function EndsWith($haystack, $needle) {
        return $needle === "" || substr($haystack, -strlen($needle)) === $needle;
    }

    public static function Now() {
        return date("Y-m-d H:i:s");
    }

    public static function SafeHTMLEncode($str) {
        return htmlentities($str, ENT_QUOTES);
    }

    public static function SafeHTMLDecode($str) {
        return html_entity_decode($str, ENT_QUOTES);
    }

    public static function GetChar($num) {
        $val = 0;
        if ($num > 0 && $num <= 10) {
            $val = $num + 47;
        } else if ($num > 10 && $num <= 36) {
            $val = $num + 54;
        } else if ($num > 36 && $num <= 62) {
            $val = $num + 60;
        }
        if ($val == 0) {
            $val = 48;
        }
        return chr($val);
    }

    public static function PrettyDate($dtm) {
        //yyyy-mm-dd hh:ii:ss
        $y = substr($dtm, 0, 4);
        $m = substr($dtm, 5, 2);
        $d = substr($dtm, 8, 2);
        $h = substr($dtm, 11, 2);
        $i = substr($dtm, 14, 2);
        $s = substr($dtm, 17, 2);
        $dt = mktime($h, $i, $s, $m, $d, $y);
        return date('M d, Y', $dt);
        //return $y;
    }

    public static function PrettyDateTime($dtm) {
        //yyyy-mm-dd hh:ii:ss
        $y = substr($dtm, 0, 4);
        $m = substr($dtm, 5, 2);
        $d = substr($dtm, 8, 2);
        $h = substr($dtm, 11, 2);
        $i = substr($dtm, 14, 2);
        $s = substr($dtm, 17, 2);
        $dt = mktime($h, $i, $s, $m, $d, $y);
        return date('d-M-Y g:ia', $dt);
        //return $y;
    }

    public static function RemoveSpaces($str) {
        $np = trim($str);
        $np = ucwords(strtolower($np));
        $np = str_replace(" ", "", $np);
        return $np;
    }

}
