<?php

namespace Application\Lib;

ini_set("display_errors", 1);
error_reporting(E_ALL);

class View
{
    public function render($name, $data = [])
    {
        $path = BASE_PATH . DIRECTORY_SEPARATOR . "application" . DIRECTORY_SEPARATOR . "view" . DIRECTORY_SEPARATOR . "$name.phtml";
        // need to pass $name into render to check is accessible
        if (file_exists($path)) {
            require_once $path;
        } else {
            die("File does not exists");
        }
    }

}