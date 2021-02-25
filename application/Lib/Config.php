<?php

namespace Application\Lib;

ini_set("display_errors", 1);
error_reporting(E_ALL);

class Config
{
    public static function config($key)
    {
        $config = include BASE_PATH . DIRECTORY_SEPARATOR . "application" . DIRECTORY_SEPARATOR . "config.php";

        return $config[$key];
    }
}