<?php
namespace com\ddocc\halo\entity;
use com\ddocc\base\ui\Bootstrap;

class Page extends Bootstrap {
    public function __construct() {
        parent::__construct();        
    }
    
    public function Paint($strTitle = '', $menushow = true) {
        $this->Title = $strTitle;
        $this->Header();
        if($menushow)
        {
            $this->Menu();
        }
    }
}
