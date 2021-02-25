<?php

namespace Application\Controller;

ini_set("display_errors", 1);
error_reporting(E_ALL);

use Application\Lib\View;
use Application\Model\Car;
use Application\Model\Rental;

class RentalController
{
    private $view;
    
    public function __construct() {
        $this->view = new View();
    }

    public function index()
    {
        session_start();
        $rental = new Rental();
        $id = isset($_GET['id']) ? $_GET['id'] : null;
        $data = $rental->getLocationById($id);
    }

    public function insertRentLocation()
    {
        session_start();

        ob_start();
        $rental = new Rental();

        $cars = new Car();
        $id = isset($_GET['id']) ? $_GET['id'] : null;
        $data = $cars->getCar($id);
        $c = [];
        if (is_array($data)) {
            foreach ($data as $car) {
                $c[] = $car['id'];
            }
        }

        $this->view->render('rental' . DIRECTORY_SEPARATOR . 'insertRentLocation', $data);

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $data = [
                /* strtoupper() will work with a-z, but it won't work with č, ć, etc. UTF-8 should be pass-in to support these characters
                   it could be done already in database connection
                */
                'pickup_location' => mb_convert_case($_POST['pickup_location'], MB_CASE_UPPER, "UTF-8"),
                'pickup_date' => $_POST['pickup_date'],
                'pickup_time' => $_POST['pickup_time'],
                'return_location' => mb_convert_case($_POST['return_location'], MB_CASE_UPPER, "UTF-8"),
                'return_date' => $_POST['return_date'],
                'return_time' => $_POST['return_time'],
                'car_id' => $_SESSION['carID'],
                'user_id' => $_SESSION['userID']
            ];

            if ($rental->insertRentLocation($data)) {
                header('Location: ../CarController/checkout', true, 301);
                exit();
            }
        }
    }
}