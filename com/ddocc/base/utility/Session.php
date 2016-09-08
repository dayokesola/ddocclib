<?php
namespace com\ddocc\base\utility;

class Session {

    public static function SetClass($key,$class) {
        $_SESSION[$key] = serialize($class);
    }

    public static function GetClass($key) {
        if(! Session::Exists($key)){
            return null;
        }
        return unserialize($_SESSION[$key]);
    }

    public static function Set($key,$val) {
        $_SESSION[$key] = $val;
    }

    public static function Get($key) {
        $r = '';
        if(isset($_SESSION[$key])){
            $r = $_SESSION[$key];
        }
        return $r;
    }
    public static function Exists($key) {
        return isset($_SESSION[$key]) && !empty($_SESSION[$key]);
    }

    public static function Clear() {
        session_destroy();
    }
    public static function Logout() {
        session_unset();
        session_destroy();
    }
    public static function Start() {
        session_start();
    }
    public static function ID() {
        return session_id();
    }
}