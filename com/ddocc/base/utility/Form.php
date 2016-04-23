<?php

namespace com\ddocc\base\utility;

use com\ddocc\base\entity\SiteTab;
use com\ddocc\base\utility\Session;

/**
 * Description of cls_form
 *
 * @author okesolaa
 */
class Form {

    public function CleanData($data) {
        $data = htmlspecialchars(stripslashes(trim($data)));
        //$data = stripslashes($data);
        //$data = htmlspecialchars($data);
        return $data;
    }

    public function Alert($ibox) {
        if ($ibox->msg == '') {
            return;
        }
        echo '<div class="alert alert-' . $ibox->css . ' alert-dismissable">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
            ' . $ibox->msg . '</div>';
    }

    public function Start($action = '', $autocomplete = 0, $multipart = 0, $method='post') {
        $dt = ' enctype="multipart/form-data" ';
        if ($multipart === 0) {
            $dt = '';
        }
        $ac = ' autocomplete="off" ';
        if ($autocomplete === 0) {
            $ac = '';
        }

        $txt = '
        <form role="form" method="'. $method .'" ' . $dt . $ac . '>';
        $token = md5(uniqid(rand(), TRUE));
        Session::Set("token_" . $action, $token);
        Session::Set("token_time_" . $action, time());
        echo $txt;
        Form::Hidden('token', $token);
        Form::Hidden('action', $action);
    }

    public function Start_h() {
        $txt = '
        <form role="form" method="post" class="form-horizontal">';

        echo $txt;
    }

    public function Close() {
        $txt = '
        </form>

';
        echo $txt;
    }

    public function Captcha() {
        include(SITELOC . "content/captchaphp/simple-php-captcha.php");
        Session::Set('captcha', simple_php_captcha());
        $g = Session::Get('captcha');
        $txt = '<img src="' . $g['image_src'] . '" />';
        echo $txt;
    }

    public function VerifyCaptcha($val) {
        $g = Session::Get('captcha');
        return $g['code'] == $val;
    }

    public function Hidden($name, $val) {
        $txt = '
            <input name="' . $name . '" type="hidden" value="' . $val . '" />';
        echo $txt;
    }

    public function Button($name, $val, $col = 'primary', $class ='') {
        $txt = '
            <input name="' . $name . '" id="' . $name . '" class="btn btn-' . $col . ' ' . $class . '" type="button" value="' . $val . '" />';
        echo $txt;
    }

    public function Link($name, $val) {
        $txt = '
            <a href="#" name="' . $name . '" id="' . $name . '">' . $val . '</a>';
        echo $txt;
    }

    public function Submit($name, $val, $col = 'primary', $enabled = 1, $block = 1, $class ='') {
        $hide = '';
        if ($enabled == 0) {
            $hide = ' disabled';
        }
        
        $blk = ' btn-block';
        if ($block == 0) {
            $blk = ' ';
        }
        $txt = '
            <input name="' . $name . '" id="' . $name . '" class="btn btn-' . $col . ' '.$blk.' ' . $class . '"  type="submit" value="' . $val . '" ' . $hide . ' />';
        echo $txt;
    }

    public function Submit_h($name, $val, $col = 'primary', $hor = 4) {
        $ho2 = 12 - $hor;
        $txt = '<div class="form-group">
										<div class="col-sm-offset-' . $hor . ' col-sm-' . $ho2 . '">
										  <!-- Buton -->
										  <input name="' . $name . '" id="' . $name . '" class="btn btn-' . $col . '" type="submit" value="' . $val . '" />
										</div>
									</div>';
        echo $txt;
    }
    
    

    public function TextBox($name, $label, $val, $type = 'text', $enabled = 1, $placer = '', $class = '') {
        $hide = '';
        if ($enabled == 0) {
            $hide = ' disabled';
        }
        if ($enabled == 2) {
            $hide = ' readonly';
        }
        $txt = '
            <div class="form-group">
                <label for="' . $name . '">' . $label . '</label>
                <input type="' . $type . '" class="form-control ' . $class . '" id="' . $name . '" name="' . $name . '" value="' . $val . '" placeholder="' . $placer . '"' . $hide . '>
            </div> ';
        echo $txt;
    }

    public function FileUpload($name, $label, $enabled = 1) {
        $hide = '';
        if ($enabled == 0) {
            $hide = ' disabled';
        }
        if ($enabled == 2) {
            $hide = ' readonly';
        }
        $txt = '
            <div class="form-group">
                <label for="' . $name . '">' . $label . '</label>
                <input type="file" class="form-control" id="' . $name . '" name="' . $name . '" ' . $hide . ' />
            </div> ';
        echo $txt;
    }

    public function TextBox_h($name, $label, $val, $type = 'text', $hor = 4, $enabled = 1, $placer = '', $class ='') {
        $hide = '';
        $ho2 = 12 - $hor;
        if ($enabled == 0) {
            $hide = ' disabled';
        }
        $txt = '
            <div class="form-group ' . $class . '">
                <label for="' . $name . '" class="col-sm-' . $hor . ' control-label">' . $label . '</label>
                <div class="col-sm-' . $ho2 . '"><input type="' . $type . '" class="form-control" id="' . $name . '" name="' . $name . '"
                 value="' . $val . '" placeholder="' . $placer . '"' . $hide . '></div>
            </div> ';
        echo $txt;
    }

    public function TextArea($name, $label, $val, $rows = 3, $enabled = 1, $placer = '') {
        $hide = '';
        if ($enabled == 0) {
            $hide = ' disabled';
        }
        $txt = '
            <div class="form-group">
                <label for="' . $name . '">' . $label . '</label>
                <textarea rows="' . $rows . '" class="form-control" id="' . $name . '" name="' . $name . '" placeholder="' . $placer . '"' . $hide . '>' . $val . '</textarea>
            </div> ';
        echo $txt;
    }

    public function TextAreaHTML($name, $label, $val, $rows = 3, $enabled = 1, $placer = '') {
        $hide = '';
        if ($enabled == 0) {
            $hide = ' disabled';
        }
        $txt = '
            <div class="form-group">
                <label for="' . $name . '">' . $label . '</label>
                <textarea style="font-family:Courier;" rows="' . $rows . '" class="form-control" id="' . $name . '" name="' . $name . '" placeholder="' . $placer . '"' . $hide . '>' . $val . '</textarea>
            </div> ';
        echo $txt;
    }

    public function DropListTab($name, $label, $val, $tab_id, $enabled = 1, $sort = 2) {
        $hide = '';
        if ($enabled == 0) {
            $hide = ' disabled';
        }
        $t = new SiteTab();
        $t->tab_id = $tab_id;
        $ds = $t->GetList($sort);
        $selected = '';
        $txt = '<div class="form-group">
                <label for="' . $name . '">' . $label . '</label>
                <select class="form-control" name="' . $name . '" id="' . $name . '"' . $hide . '>
            ';
        foreach ($ds as $dr) {
            if ($val == $dr["tab_ent"]) {
                $selected = ' selected="selected"';
            }
            $txt .= '      <option value="' . $dr["tab_ent"] . '"' . $selected . '>' . $dr["tab_text"] . '</option>
            ';
            $selected = '';
        }
        $txt .= '    </select>
            </div> ';
        echo $txt;
    }

    public function DropList($name, $label, $val, $ds, $drkey, $drval, $no_list_value = 0, $no_list_item = '', $enabled = 1) {
        $hide = '';
        if ($enabled == 0) {
            $hide = ' disabled ';
        }
        $selected = '';
        $txt = '
            <div class="form-group">
                <label for="' . $name . '">' . $label . '</label>
                <select class="form-control" name="' . $name . '" id="' . $name . '"' . $hide . '>';
        if ($no_list_item != '') {
            $txt .= '
                    <option value="' . $no_list_value . '">' . $no_list_item . '</option>';
        }
        foreach ($ds as $dr) {
            if ($val == $dr->$drkey) {
                $selected = ' selected="selected"';
            }
            $txt .= '
                    <option value="' . $dr->$drkey . '"' . $selected . '>' . $dr->$drval . '</option>';
            $selected = '';
        }
        $txt .= '
                </select>
            </div> ';
        echo $txt;
    }

    public function DropList_h($name, $label, $val, $ds, $drkey, $drval, $hor = 4, $no_list_value = 0, $no_list_item = '', $enabled = 1) {
        $hide = '';
        $ho2 = 12 - $hor;
        if ($enabled == 0) {
            $hide = ' disabled ';
        }
        $selected = '';
        $txt = '
            <div class="form-group">
                <label for="' . $name . '" class="col-sm-' . $hor . ' control-label">' . $label . '</label>
                <div class="col-sm-' . $ho2 . '"><select class="form-control" name="' . $name . '" id="' . $name . '"' . $hide . '>';
        if ($no_list_item != '') {
            $txt .= '
                    <option value="' . $no_list_value . '">' . $no_list_item . '</option>';
        }
        foreach ($ds as $dr) {
            if ($val == $dr->$drkey) {
                $selected = ' selected="selected"';
            }
            $txt .= '
                    <option value="' . $dr->$drkey . '"' . $selected . '>' . $dr->$drval . '</option>';
            $selected = '';
        }
        $txt .= '
                </select></div>
            </div> ';
        echo $txt;
    }

    public function CheckBoxList($name, $label, $val, $ds, $enabled = 1) {
        $txt = '
        <div class="form-group">';
        foreach ($ds as $dr) {
            $txt .= '<div class="checkbox">
                                            <label class="">
                                                <div class="icheckbox_minimal checked" aria-checked="true" 
                                                aria-disabled="false" style="position: relative;">
                                                <input type="checkbox" style="position: absolute; opacity: 0;">
                                                <ins class="iCheck-helper" style="position: absolute; top: 0%; left: 0%; display: block; width: 100%; height: 100%; margin: 0px; padding: 0px; background-color: rgb(255, 255, 255); border: 0px; opacity: 0; background-position: initial initial; background-repeat: initial initial;"></ins></div> Check me out
                                            </label>
                                        </div>';
        }

        $txt .= '</div>';
        echo $txt;
    }

    public function CheckBox($name, $label, $val, $enabled = 1) {
        $hide = '';
        if ($enabled == 0) {
            $hide = ' disabled';
        }
        if ($enabled == 2) {
            $hide = ' readonly';
        }
        $txt = '
            <div class="form-group">
                <label for="' . $name . '">' . $label . '</label>
                <input  type="checkbox" class="form-control" id="' . $name . '" name="' . $name . '" value="' . $val . '" ' . $hide . '>
            </div> ';
        echo $txt;
    }
    
    public function CheckBoxBare($name, $label, $val, $enabled = 1) {
        $hide = '';
        if ($enabled == 0) {
            $hide = ' disabled';
        }
        if ($enabled == 2) {
            $hide = ' readonly';
        }
        $txt = '<input  type="checkbox" id="' . $name . '" name="' . $name . '" value="' . $val . '" ' . $hide . '>
            ' . $label . '';
        echo $txt;
    }

}
