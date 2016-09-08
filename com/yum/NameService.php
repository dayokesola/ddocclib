<?php
namespace com\yum; 
class NameService { 
    public static function ControllerName($name) {
        $txt = BringUp($name) . 'Controller';
        return $txt;
    }
    
    public static function ServiceName($name) {
        $txt = BringUp($name) . 'Service';
        return $txt;
    }
    
    public static function PageTitle($name) {
        $txt = BringUp($name, ' ');
        return trim($txt);
    }
    
    public static function EntityName($name) {
        $txt = BringUp($name);
        return trim($txt);
    }
    
    public static function VarName($name) {
        $txt = strtolower(BringUp($name));
        return trim($txt);
    }
    
    public static function DTOName($name) {
        $txt = BringUp($name) . 'DTO';
        return trim($txt);
    }
}
