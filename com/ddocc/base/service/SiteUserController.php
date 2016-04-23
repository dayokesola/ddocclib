<?php
namespace com\ddocc\base\service;
use com\ddocc\base\utility\Connect;
class SiteUserController {
    
    public function login($a)
    {       
        include_once 'SiteUserService.php';
        return UserService::Login($a); 
    }
    
    public function activate($a)
    {          
        include_once 'SiteUserService.php';
        return UserService::Activate($a);         
    }
    
    public function register($a)
    {       
        include_once 'SiteUserService.php';
        return UserService::Register($a);  
    }
}

