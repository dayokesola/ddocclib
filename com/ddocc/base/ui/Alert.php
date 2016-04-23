<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace com\ddocc\base\ui;

/**
 * Description of Alert
 *
 * @author Dayo
 */
class Alert {
    var $msg;
    var $css;
    public function __construct($css = 'info', $msg = '') {
        $this->msg = $msg;
        $this->css = $css;
    }
}
