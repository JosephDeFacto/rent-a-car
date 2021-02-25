<?php

namespace Application\Controller;

ini_set("display_errors", 1);
error_reporting(E_ALL);

use Application\Lib\View;
use Application\Model\Brand;

class BrandController
{
    private $view;

    public function __construct()
    {
        $this->view = new View();
    }

    public function getBrands()
    {
        $brand = new Brand();
        $brands = $brand->getBrands();

        $this->view->render('cars' . DIRECTORY_SEPARATOR . 'index', $brands);
    }
}