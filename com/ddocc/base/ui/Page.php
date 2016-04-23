<?php
namespace com\ddocc\base\ui;   
use com\ddocc\base\entity\SiteUser;

class Page  {

    var $Title;
    var $TitleBar;
    var $TitleMini;    
    var $alertBox;
    var $su;
    var $menutext;
    var $route;

    public function __construct( ) {
        $this->alertBox = new Alert();
        $this->su = new SiteUser();
    }
    
    public function Alert() {
        if ($this->alertBox->msg == '')
            return;
        echo '<div class="alert alert-' . $this->alertBox->css . ' alert-dismissable">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
    ' . $this->alertBox->msg . '</div>';
    }
    
    
    public function BreadCrumb() {
        $xml = simplexml_load_file(SITEMAP);
        $route = strtolower(str_replace("\\", '.', $this->route));        
        $crumbs = array();        
        $crumbs_param = array();         
        $crumbs_param_val = array(); 

 
        do {
            $result = $xml->xpath("//page[@route='".$route."']")[0];  
            if(is_null($result)) {
                 
                return;
            }
            $name = $result->attributes()['name']->__toString();      
             
            $crumbs[$route] = $name;
            $params = array();
            $parent = $result->attributes()['parent']->__toString(); 
            if(isset($result->attributes()['params'])) {   
                $bits = explode(',',$result->attributes()['params']->__toString() );
                foreach($bits as $bit){ 
                    $params[$bit] = $_GET[$bit]; 
                }                
            }
            $crumbs_param[$parent] = $params;
            $route = $result->attributes()['parent']->__toString(); 
        } while ($route != '0');
        
        //dd($crumbs_param);
        $crumbs_rev =array_reverse($crumbs);
        $i = count($crumbs_rev);
        $txt = '<ol class="breadcrumb">';
        $j = 0;
        foreach($crumbs_rev as $k => $v){
            $j++;
            if($i != $j){
                $txt .= '<li><a href="'.  UrlParams($k, $crumbs_param[$k]).'">'. $v .'</a></li>';
            }
            else{
                $txt .= '<li class="active">'. $v .'</li>';
            }
        }
        $txt .= '</ol>';
        echo $txt; 
    }
 

}
