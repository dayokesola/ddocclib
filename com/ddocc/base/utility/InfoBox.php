<?php
namespace com\ddocc\base\utility;

Class InfoBox {
    var $css;
    var $csn;
    var $msg;
    var $id;
    public function __construct($c=false,$m='', $i = 0)
    {
        if($c){
            $this->css = 'success';
        }
        else {
            $this->css = 'danger';
        }
        $this->msg = $m;
        $this->id = $i;
    }
}

