<?php
namespace com\ddocc\base\controller;
use com\ddocc\base\service\SiteUserService;
use com\ddocc\base\utility\Session;
class SiteUserController extends ControllerBase {
    
    public function ProfileGet() {     
        $su = Session::GetClass('authuser'); 
        $dto = SiteUserService::GetUserByUsernameDTO($su->auth_email);   
        $dto->profile = SiteUserService::GetProfileInfo($su);
        $i = 0;
        $j = 0;
        foreach ($dto->profile as $profile)
        {
            $i++;
            if($profile->profile_value != '')
            {
                $j++;                
            }
        }
        $k = ($j / $i) * 100;
        $txt = 'success';
        $msg = 'Your profile is complete!';
        if ($k == 100) { 
        }
        elseif ($k > 90) {
            $txt = 'info';
            $msg = 'Your profile is almost complete!';
        } 
        elseif ($k > 50) {
            $txt = 'warning';
            $msg = 'Your profile is not yet complete!';
        }
        else{
            $txt = 'danger';
            $msg = 'You really need to update your profile!';
        } 
        $resp = array();   
        $resp['alert'] = new \com\ddocc\base\ui\Alert($txt, $msg);
        $resp['dto']= $dto;        
        $resp['btn']= $txt;

        return $resp;
    }    
        
    public function ProfilePost() {      
        $resp = array();         
        return $resp;
    }
}
