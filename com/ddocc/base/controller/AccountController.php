<?php

namespace com\ddocc\base\controller;

use com\ddocc\base\ui\Alert;
use com\ddocc\base\service\SiteUserService;
use com\ddocc\base\service\SiteRoleService;
use com\ddocc\base\utility\Session;
use com\ddocc\base\dto\RegisterDTO;
use com\ddocc\base\dto\LoginDTO;
use com\ddocc\base\dto\ResetDTO;
use com\ddocc\base\dto\ActivateDTO;
use com\ddocc\base\entity\SiteUser;
use com\ddocc\base\utility\Gizmo; 

class AccountController {

    public function LoginGet($request) {
        $resp = array();
        $dto = new LoginDTO();
        $resp['dto'] = $dto;
        return $resp;
    }

    public function LoginPost($request) {
        $resp = array();
        $dto = new LoginDTO();
        $fields = array('email', 'pwd');
        $v = $dto->SetPost($request['post'], $fields);
        if ($v != '') {
            $resp['alert'] = new Alert('danger', $v);
            $resp['dto'] = $dto;
            return $resp;
        }        
        $su = SiteUserService::GetUserByUsername($dto->email);
        $logged = $su->auth_phrase == crypt($dto->pwd, $su->auth_spice); 
        if ($logged) {
            $resp['view'] = 'home.index';
            $resp['redirect'] = '1';
            //hide pwd from session? yes cool so I dont forget it there
            $comm = \com\ddocc\halo\service\CommunityService::GetByHost();
            $su->HideAuth();
            Session::SetClass("authuser", $su);
            Session::SetClass("authcomm", $comm);            
            $role = SiteRoleService::GetByID($su->role_id);
            Session::Set('authmenu', $role->GetMenu());
        } else {
            $resp['alert'] = new Alert('danger', 'Invalid Credentials');
            $resp['dto'] = $dto;
        }
        return $resp;
    }

    public function RegisterGet() {
        $resp = array();
        $reg = new RegisterDTO();
        $resp['reg'] = $reg;
        return $resp;
    }

    public function RegisterPost($request) {
        $resp = array();
        $reg = new RegisterDTO();
        $fields = array('fname', 'lname', 'email', 'pwd1', 'pwd2', 'mobile');
        $v = $reg->SetPost($request['post'], $fields);
        $resp['reg'] = $reg;
        
        $comm = \com\ddocc\halo\service\CommunityService::GetByHost();
        if($comm->id <= 0)
        {
            //$resp['alert'] = new Alert('warning', 'There is no default community for this website<br />Please contact your administrator');
            //return $resp;
        }            

        if ($v != '') {
            $resp['alert'] = new Alert('danger', $v);
            return $resp;
        }
        $su = SiteUserService::GetUserByUsername($reg->email);
        if ($su->user_id > 0) {
            $resp['alert'] = new Alert('danger', 'Email is already registered');
            $resp['reg'] = $reg;
            return $resp;
        }
        $su = new SiteUser();
        $su->auth_email = $reg->email;
        $cost = 10;
        $salt = strtr(base64_encode(mcrypt_create_iv(16, MCRYPT_DEV_URANDOM)), '+', '.');
        $su->auth_spice = sprintf("$2a$%02d$", $cost) . $salt;
        $su->auth_phrase = crypt($reg->pwd1, $su->auth_spice);
        $su->date_added = Gizmo::Now();
        $su->fname = $reg->fname;
        $su->last_reset = Gizmo::Now();
        $su->last_updated = Gizmo::Now();
        $su->lname = $reg->lname;
        $su->role_id = 2; //default user
        $su->statusflag = 2;
        $su->auth_code = '0';
        $su->mobile = $reg->mobile;
        $su->user_id = SiteUserService::Insert($su);
        if ($su->user_id > 0) {
            $resp['view'] = 'home.index';
            $resp['redirect'] = '1';
            Session::SetClass("authuser", $su);
            $role = SiteRoleService::GetByID($su->role_id);
            Session::Set('authmenu', $role->GetMenu());
            
            //add user to the default community
            if($comm->id > 0) {
                $cu = new \com\ddocc\halo\entity\CommunityUser();
                $cu->community_id = $comm->id;
                $cu->user_id = $su->user_id;
                $cu->role_id = 2;
                $cu->statusflag = 9;
                $cu->last_updated = Gizmo::Now();
                \com\ddocc\halo\service\CommunityUserService::Insert($cu);
            }            
        } else {
            $resp['alert'] = new Alert('danger', 'Registration cannot be completed now, pls try again later');
            $resp['reg'] = $reg;
        }
        return $resp;
    }

    public function ResetGet() {
        $resp = array();
        $dto = new ResetDTO();
        $resp['dto'] = $dto;
        return $resp;
    }
    
    public function ResetPost($request) {
        $resp = array();
        $fields = array('email');
        $dto = new ResetDTO();
        $v = $dto->SetPost($request['post'], $fields);
        $resp['dto'] = $dto;
        if ($v != '') {
            $resp['alert'] = new Alert('danger', $v);
            return $resp;
        }          
        $su = SiteUserService::GetUserByUsername($dto->email);
        if($su->user_id <= 0)
        { 
            $resp['alert'] = new Alert('danger', 'Invalid Email');
            return $resp; 
        }
        $su->auth_code = Gizmo::Random(32);
        $su->last_reset = Gizmo::Now();
        $mailed = SiteUserService::MailReset($su); 
        if ($mailed) {
            SiteUserService::Update($su);
            $resp['alert'] = new Alert('success', 'A reset mail has been sent to '. $su->auth_email);
        } else {
            $resp['alert'] = new Alert('danger', 'Password reset failed, please try again later');
        }
        return $resp;
    }

    public function ActivateGet($request) {
        $resp = array();
        $dto = new ActivateDTO();
        $dto->code = $request['get']['code'];        
        $dto->email = $request['get']['email'];
        $resp['dto'] = $dto;
        //lets validate this,m remember to add time factor pls
        $su = SiteUserService::GetUserByUsername($dto->email);
        if($dto->code != $su->auth_code)
        {
            $resp['alert'] = new Alert('danger', 'Invalid Authorization code');
            $resp['view'] = 'account\\reset';
        }
        return $resp;
    }
    
    public function ActivatePost($request) {
        $resp = array();
        $fields = array('pwd1','pwd2');
        $dto = new ActivateDTO();
        $dto->code = $request['get']['code'];        
        $dto->email = $request['get']['email'];
        $v = $dto->SetPost($request['post'], $fields);
        $resp['dto'] = $dto;
        if ($v != '') {
            $resp['alert'] = new Alert('danger', $v);
            return $resp;
        }          
        $su = SiteUserService::GetUserByUsername($dto->email);
        if($dto->code != $su->auth_code)
        {
            $resp['alert'] = new Alert('danger', 'Invalid Authorization code');
            $resp['view'] = 'account\\reset';
        }
        $su->auth_code = '0'; 
        $cost = 10;
        $salt = strtr(base64_encode(mcrypt_create_iv(16, MCRYPT_DEV_URANDOM)), '+', '.');
        $su->auth_spice = sprintf("$2a$%02d$", $cost) . $salt;
        $su->auth_phrase = crypt($dto->pwd1, $su->auth_spice);
        $k = SiteUserService::Update($su);
        if ($k > 0) {            
            $resp['alert'] = new Alert('success', 'Your Account password has been reset<br />Continue to <a href="'.Url('account.login').'">Login</a>');
        } else {
            $resp['alert'] = new Alert('danger', 'Password reset failed, please try again later');
        }
        return $resp;
    }

    
    public function ChangepwdGet() {
        $resp = array();
        $dto = new ResetDTO();
        $resp['dto'] = $dto;
        return $resp;
    }
    
    public function ChangepwdPost($request) {
        $resp = array();
        $fields = array('email');
        $dto = new ResetDTO();
        $v = $dto->SetPost($request['post'], $fields);
        $resp['dto'] = $dto;
        if ($v != '') {
            $resp['alert'] = new Alert('danger', $v);
            return $resp;
        }          
        $su = SiteUserService::GetUserByUsername($dto->email);
        if($su->user_id <= 0)
        { 
            $resp['alert'] = new Alert('danger', 'Invalid Email');
            return $resp; 
        }
        $su->auth_code = Gizmo::Random(32);
        $su->last_reset = Gizmo::Now();
        $mailed = SiteUserService::MailReset($su); 
        if ($mailed) {
            SiteUserService::Update($su);
            $resp['alert'] = new Alert('success', 'A reset mail has been sent to '. $su->auth_email);
        } else {
            $resp['alert'] = new Alert('danger', 'Password reset failed, please try again later');
        }
        return $resp;
    }
    
    public function LogoutGet($request) {
        Session::Logout();
        $resp = array();
        $resp['view'] = 'account.login';
        $resp['redirect'] = '1';
        return $resp;
    }

}
