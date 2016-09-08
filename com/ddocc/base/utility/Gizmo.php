<?php

/**
 * Created by PhpStorm.
 * User: okesolaa
 * Date: 12/26/14
 * Time: 8:35 PM
 */

namespace com\ddocc\base\utility;

class Gizmo {

    private static $sumTable = array(array(0, 1, 2, 3, 4, 5, 6, 7, 8, 9), array(0, 2, 4, 6, 8, 1, 3, 5, 7, 9));

    public static function ExportToCSV($array, $filename = "export.csv", $delimiter = ",") {
        // open raw memory as file so no temp files needed, you might run out of memory though
        $f = fopen('php://memory', 'w');
        // loop over the input array
        foreach ($array as $line) {
            // generate csv lines from the inner arrays
            fputcsv($f, $line, $delimiter);
        }
        // reset the file pointer to the start of the file
        fseek($f, 0);
        // tell the browser it's going to be a csv file
       
        header('Content-Type: application/csv');
        // tell the browser we want to save it instead of displaying it
        header('Content-Disposition: attachment; filename="' . $filename . '";');
        // make php send the generated csv lines to the browser
        fpassthru($f);
    }

    public static function LuhnCalculate($number) {
        $length = strlen($number);
        $sum = 0;
        $flip = 1;
        // Sum digits (last one is check digit, which is not in parameter)
        for ($i = $length - 1; $i >= 0;  --$i) {
            $sum += Gizmo::$sumTable[$flip++ & 0x1][$number[$i]];
        }
        // Multiply by 9
        $sum *= 9;
        // Last digit of sum is check digit
        return (int) substr($sum, -1, 1);
    }

    public function LuhnValidate($number, $digit) {
        $calculated = Gizmo::LuhnCalculate($number);
        if ($digit == $calculated) {
            return true;
        } else {
            return false;
        }
    }

    public static function UniqueId() {
        $tme = microtime(true);
        $tme = Gizmo::Replace('.', '', $tme);
        $tme = str_pad($tme, 14, '0', STR_PAD_RIGHT);
        return strtoupper(base_convert($tme, 10, 36));
    }

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

    public static function ToMoney($key) {
        return number_format($key, 2);
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

    public static function DefaultDate() {
        return "1900-01-01 00:00:00";
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

    public static function FromDate($dtm) {
        //yyyy-mm-dd hh:ii:ss
        $y = substr($dtm, 0, 4);
        $m = substr($dtm, 5, 2);
        $d = substr($dtm, 8, 2);
        $h = substr($dtm, 11, 2);
        $i = substr($dtm, 14, 2);
        $s = substr($dtm, 17, 2);
        $dt = mktime($h, $i, $s, $m, $d, $y);
        return date('Y-m-d', $dt);
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

    public static function DifferenceInObject($obj1, $obj2) {
        $array = (array) $obj1;
        $diff = '';
        foreach ($array as $key => $value) {
            if (property_exists($obj2, $key) && $obj1->{$key} != $obj2->{$key}) {
                $diff .= $key . ' = ' . $value . '; ';
            }
        }
        return $diff;
    }

}
