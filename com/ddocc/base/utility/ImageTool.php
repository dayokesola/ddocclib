<?php
/**
 * Created by PhpStorm.
 * User: okesolaa
 * Date: 2/6/15
 * Time: 9:17 AM
 */

namespace com\ddocc\base\utility;


class ImageTool {
    public static function SaveResize($Loc)
    {
        return getimagesize($loc);
    }

} 