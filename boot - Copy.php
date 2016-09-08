<?php
use com\ddocc\base\service\SiteFxnService; 
use com\ddocc\base\service\SiteUserService;
use com\ddocc\base\utility\Gizmo; 
use com\ddocc\base\utility\Form; 
use com\ddocc\base\utility\Session; 
use com\ddocc\base\entity\SiteUser; 
use com\ddocc\base\dto\SiteFxnDTO;
$freed = false;
$me3 = "home/index";
if ($_GET && isset($_GET['r'])) {
    $me3 = $_GET["r"];
}
$bits = explode('/', $me3);
$ctrl = "Home";
$meth = "Index";
if (count($bits) == 1) {
        $ctrl = ucwords($bits[0]);
}
if (count($bits) == 2) {
    $ctrl = ucwords($bits[0]);
    $meth = ucwords($bits[1]);
}
$me3 = $ctrl.'/'.$meth;
$f = SiteFxnService::GetFxnByUrl(strtolower($me3));
if ($f->fxn_id <= 0 && ENV == 'dev') {
    $f->fxn_name = strtolower($me3);
    $f->fxn_group = 0;
    $f->fxn_secure = 0;
    $f->fxn_flag = 0;
    $f->fxn_sort = 0;
    $f->fxn_url = strtolower($me3);
    $f->fxn_icon = '';
    $f->last_updated = Gizmo::Now();
    $f = SiteFxnService::InsertFxn($f);
}
$logged = 1;
$su = SiteUserService::NewUser();
if (!Session::Exists("authuser")) {
    $logged = 0;
    $su->user_id = 0;
} else {
    $su = Session::GetClass("authuser");
}
if ($f->fxn_secure == 1) {
    if ($logged == 0) {
        header('location: ' . SITEURL . '?r=account/login&nosession');
    }
    if (!SiteFxnService::BelongsTo($f->fxn_id, $su->role_id)) {
        header('location: ' . SITEURL . '?r=account/login&redirect=' . $me3);
    }
}
  

$orig_meth = $meth;
$orig_ctrl = $ctrl;
$meth = BringUp($meth);
$ctrl = BringUp($ctrl);
$methdir = "Get";
$request = array("get" => $_GET, "post" => $_POST);
if ($_POST) {
    if (isset($_POST['action'])) {
        $methdir = "Post";
    }
}
$response = array(); 
try {
    $reflector = new ReflectionClass($class_global_route[$ctrl . 'Controller']);
    $inst = $reflector->newInstanceArgs();
    $publishMethod = $reflector->getMethod($meth . $methdir);
    $response = $publishMethod->invoke($inst, $request);
} catch (Exception $e) {
    dd($e);
    echo $e->xdebug_message;
    exit();
}

if($view == FALSE)
{
    header("Expires: ". date('r'));
    header("Cache-Control: no-cache");
    header("Pragma: no-cache");
    header("Content-type:application/json");
    echo json_encode($response);
    exit();
}
$form = new Form();
$view = $orig_ctrl . '\\' . $orig_meth;
if(isset($response['view']))
{
    $view = RouteToSlash($response['view']);
}
if(isset($response['redirect']))
{
    $params = array();
    if(isset($response['params'])){
        $params = $response['params'];
    }
    if($response['redirect'] == '1'){
        header('location: '. UrlParams($view, $params));
    }
    
}
if(isset($response['alert']))
{
    $page->alertBox = $response['alert'];
} 
if(!file_exists ( VIEWS . $view . '.php' ))
{
    echo $view;
    $view = 'error\404';    
}
$page->su = $su;
$page->route = $view;
$page->menutext = Session::Get('authmenu');
extract($response);
//dd($response);
include_once(VIEWS . $view . '.php'); 