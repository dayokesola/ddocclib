<?php
namespace com\ddocc\halo\controller;

use com\ddocc\halo\dto\WelcomeDTO;
use com\ddocc\halo\service\CommunityService;
use com\ddocc\halo\service\CommunityUserService;
use com\ddocc\base\utility\Session;

class HomeController {
    public function IndexGet()
    {
        $resp = array(); 
        $su = Session::GetClass('authuser'); 
        $dto = new WelcomeDTO();
        $dto->community_count = count(CommunityService::Search('','',0,1));
        $dto->my_community_count = count(CommunityUserService::Search(0,$su->user_id,0,0));
        $resp['dto'] = $dto;
        return $resp;
    } 
}
