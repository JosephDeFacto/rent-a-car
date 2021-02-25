<?php

/*
 * key/pair values
 * */

return [
    'db' => [
        'host' => 'localhost',
        'name' => 'rent-a-car',
        'user' => 'root',
        'password' => ''
    ],
    // pretty useful for including css
    /* i.e <?php echo \Application\Lib\Config::config('url') ?>public/css/style.css
        where url is key and root path is value
    */
    'url' => 'http://localhost/rent-a-car/',
];