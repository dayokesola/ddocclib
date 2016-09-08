<?php

namespace com\yum;

class UtilService {

    public static function CreateFolder($path) {
        mkdir($path);
    }

    public static function CreateFile($path, $data) {
        file_put_contents($path, $data);
    }

}
