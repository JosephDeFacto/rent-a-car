<?php

namespace Application\Lib;

ini_set("display_errors", 1);
error_reporting(E_ALL);

class Request
{
    public static function post($key, $default = '')
    {
        return isset($_POST[$key]) ? $_POST[$key] : $default;
    }

    public static function get($key, $default = '')
    {
        return isset($_GET[$key]) ? $_GET[$key] : $default;
    }

    public static function isPost()
    {
        return $_SERVER['REQUEST_METHOD'] === 'POST';
    }

    public static function isGet()
    {
        return $_SERVER['REQUEST_METHOD'] === 'GET';
    }
}