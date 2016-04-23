<?php
/**
 * Created by PhpStorm.
 * User: okesolaa
 * Date: 12/26/14
 * Time: 8:48 PM
 */

namespace com\ddocc\base\utility;


class ServiceMessage {
    var $Id;
    var $Text;
    var $Status;

    public function Error($id, $txt = '')
    {
        $this->Id = $id * -1;
        $this->Status = false;
        $this->Text = $txt;
        if($txt == '')
        {
            $this->Text = 'Request failed!';
        }
    }

    public function Success($id, $txt = '')
    {
        $this->Id = $id;
        $this->Status = true;
        $this->Text = $txt;
        if($txt == '')
        {
            $this->Text = 'Request successful!';
        }
    }
} 