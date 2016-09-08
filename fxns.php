<?php

function dd($s) {
    echo '<pre>';
    var_dump($s);
    echo '</pre>';
    exit;
}
function ddall() {
    echo '<pre>' . print_r(get_defined_vars(), true) . '</pre>';
    exit;
}

function import($dile){
    include_once $dile . '.php';
}

$class_global_route_base = array(
    "ControllerBase" => "com\\ddocc\\base\\controller\\ControllerBase",
    "SiteUserController" => "com\\ddocc\\base\\controller\\SiteUserController",
    "SiteRoleController" => "com\\ddocc\\base\\controller\\SiteRoleController",
    "SiteFxnController" => "com\\ddocc\\base\\controller\\SiteFxnController",
    "SiteTabController" => "com\\ddocc\\base\\controller\\SiteTabController",
    "SystemController" => "com\\ddocc\\base\\controller\\SystemController", 
    "SiteFxnDTO" => "com\\ddocc\\base\\dto\\SiteFxnDTO",
    "Gizmo" => "com\\ddocc\\base\\utility\\Gizmo",
    "Form" => "com\\ddocc\\base\\utility\\Form",
    "Alert" => "com\\ddocc\\base\\utility\\Alert",
    "Session" => "com\\ddocc\\base\\utility\\Session",
    "SiteUser" => "com\\ddocc\\base\\entity\\SiteUser",
    "SiteTab" => "com\\ddocc\\base\\entity\\SiteTab",
    "Page" => "com\\app\\entity\\Page",
);
$class_global_route = array_merge($class_global_route_base, $class_global_route_app);

function cast($destination, $sourceObject) {
    if (is_string($destination)) {
        $destination = new $destination();
    }
    $sourceReflection = new ReflectionObject($sourceObject);
    $destinationReflection = new ReflectionObject($destination);
    $sourceProperties = $sourceReflection->getProperties();
    foreach ($sourceProperties as $sourceProperty) {
        $sourceProperty->setAccessible(true);
        $name = $sourceProperty->getName();
        $value = $sourceProperty->getValue($sourceObject);
        if ($destinationReflection->hasProperty($name)) {
            $propDest = $destinationReflection->getProperty($name);
            $propDest->setAccessible(true);
            $propDest->setValue($destination, $value);
        } else {
            $destination->$name = $value;
        }
    }
    return $destination;
}

function __autoload($class_name) {

    global $class_global_route;
    $fle = str_replace("\\", '/', $class_name);
     
    if (file_exists(BASELIB . $fle . '.php')) {
        include_once BASELIB . $fle . '.php';
        return;
    }
    if (file_exists(APPLIB . $fle . '.php')) {
        include_once APPLIB . $fle . '.php';
        return;
    }
    $fle = $class_global_route[$class_name];
    //echo BASELIB . $fle . '.php';
    if (file_exists(BASELIB . $fle . '.php')) {
        include_once BASELIB . $fle . '.php';
        return;
    }
    if (file_exists(APPLIB . $fle . '.php')) {
        include_once APPLIB . $fle . '.php';
        return;
    }
    include_once BASELIB . $fle . '.php';
}

function BringUp($str, $delim = '') {
    $r = "";
    $bits = explode('-', $str);
    foreach ($bits as $bit) {
        $r .= ucwords($bit) . $delim;
    }
    return $r;
}

function Url($str, $id = '') {
    $str = str_replace('.', "/", $str);
    return 'index.php?r=' . $str;
}

function UrlID($str, $id) {
    $str = Url($str);
    if ($id != '') {
        $str .= '&id=' . $id;
    }
    return $str;
}

function UrlParams($str, $params) {
    $str = Url($str);
    if (count($params) > 0) {
        foreach ($params as $key => $value) {
            $str .= '&' . $key . '=' . $value;
        }
    }
    return $str;
}

function RouteToSlash($str) {
    $str = str_replace('.', "/", $str);
    return $str;
}
