<?php
/**
 * Created by PhpStorm.
 * User: okesolaa
 * Date: 4/1/15
 * Time: 11:11 AM
 */

namespace com\ddocc\base\ui;


class CleanPage {



    var $Title;
    var $TitleBar;
    var $TitleMini;
    var $lite;
    var $Layout;
    var $MenuText;

    public function __construct( ) {

    }

    public function Header()
    {
        if(! isset($this->TitleBar))
        {
            $this->TitleBar = $this->Title;
        }
        include_once(SITELOC . 'layout/'.$this->Layout . '.php');
    }

    public function Footer() {
        include_once(SITELOC . 'layout/'.$this->Layout . '_foot.php');
    }


    function __destruct() {
        include_once(SITELOC . 'layout/'.$this->Layout . '_foot.php');
    }

    public function Alert($ibox) {

        if ($ibox->msg == '')
            return;
        echo '<div class="alert alert-' . $ibox->css . ' alert-dismissable">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
    ' . $ibox->msg . '</div>';
    }








}
