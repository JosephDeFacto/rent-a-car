<?php

namespace Application\Controller;

ini_set("display_errors", 1);
error_reporting(E_ALL);


use Application\Lib\View;
use Application\Model\Brand;
use Application\Model\Car;
use Application\Lib\DB;
use Application\Model\User;

class CarController
{
    private $view;

    public function __construct()
    {
        $this->view = new View();
    }

    public function index()
    {
        session_start();


        $cars = new Car();

        $data = $cars->getCars();



        $id = array_key_exists('id', $_GET) ? $_GET['id'] : null;

        $view = new View();


        $view->render('cars' . DIRECTORY_SEPARATOR . 'index', $data);
    }

    public function rentCar()
    {
        session_start();

        $view = new View();

        $cars = new Car();

        $id = isset($_GET['id']) ? $_GET['id'] : null;

        $stock = $cars->getStock($id);

        $data = $cars->getCar($id);

        $users = new User();
        $c = [];
        if (is_array($data)) {
            foreach ($data as $car) {
                $c[] = $car['id'];
            }
        }

        $view->render('cars' . DIRECTORY_SEPARATOR . 'rentCar', $data);
        if (!$_POST) {
            return;
        }

        $data = [
            //'id' => $data['id'],
            'car_id' => $c,
            //'user_id' => isset($_SESSION['userID']) ? $_SESSION['userID'] : null,
            'user_id' => $_SESSION['userID'],
            //'value' => $_POST['value']
        ];
        $_SESSION['carID'] = $data['car_id'][0];

        if ($cars->insertRental($data)) {
            $cars->decreaseStock($stock, $id);
            header('Location: ../RentalController/insertRentLocation');
            // header('Location: ../UserController/index');
            exit();
        }
    }

    public function decreaseStock()
    {
        $cars = new Car();

        $id = isset($_GET['id']) ? $_GET['id'] : null;
        $stock = $cars->getStock($id);
        $data = $cars->decreaseStock($stock, $id);
    }

    public function checkout()
    {
        session_start();

        $cars = new Car();

        $userID = isset($_SESSION['userID']) ? $_SESSION['userID'] : null;

        $data = $cars->read($userID);

        $this->view->render('cars' . DIRECTORY_SEPARATOR . 'checkout', $data);
    }

    public function placeRentOrder()
    {
        session_start();

        $this->view->render('cars' . DIRECTORY_SEPARATOR . 'placeRentOrder');
    }

    public function deleteRent()
    {
        session_start();

        $cars = new Car();
        $users = new User();

        $data = [
            $users->getUser($_SESSION['userID'])
        ];

        if ($cars->deleteRent($data)) {
            header('Location: ../CarController/index', true, 301);
            exit();
        }
    }
}