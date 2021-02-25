<?php 

ini_set("display_errors", 1);

use Application\Lib\Router;
use Application\Lib\Validation;

define('BASE_PATH', dirname(__DIR__));
define('SITE_ROOT', 'http://localhost/rent-a-car');

//var_dump(SITE_ROOT);

spl_autoload_register(function($className) {
    $class = lcfirst($className);
    $filename = BASE_PATH . DIRECTORY_SEPARATOR . str_replace('\\', DIRECTORY_SEPARATOR, $class) . '.php';
    $fEx = file_exists($filename);
    if (file_exists($filename)) {
        require $filename;
    }
});

$router = new Router();

$router->invoke();


/*
 *
 * TESTING
 *
 */

/*
$validator = Validation::equal('12345', '12344'); // To se riješi u post metodi
if (!Validation::isSuccess()) {
    echo Validation::showErrors();
}
*/