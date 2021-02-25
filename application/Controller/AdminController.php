<?php

namespace Application\Controller;

ini_set("display_errors", 1);
error_reporting(E_ALL);

use Application\Lib\View;
use Application\Model\Admin;
use Application\Model\Car;
use Application\Model\User;


class AdminController
{
    private $view;

    public function __construct()
    {
        $this->view = new View();
    }

    public function index()
    {
        $this->view->render('cars' . DIRECTORY_SEPARATOR . 'index');
    }

    public function logout()
    {
        session_start();
        unset($_SESSION['adminID']);
        session_destroy();

        header('Location: ../HomeController/login', true, 301);
        exit();
    }

    public function addNewCar()
    {
        session_start();
        $admin = new Admin();

        $message = isset($_GET['success']) ? $_GET['success'] : null;

        $this->view->render('admin' . DIRECTORY_SEPARATOR . 'addNewCar');

        $fileUploadDir = dirname(dirname(__DIR__)) . DIRECTORY_SEPARATOR . 'public' . DIRECTORY_SEPARATOR . 'uploads' . DIRECTORY_SEPARATOR;


        if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['model'])) {
            if (!empty($_FILES['picture']['name']) && isset($_FILES['picture']['name'])) {
                $data = [
                    'name' => $_POST['name'],
                    'model' => $_POST['model'],
                    'picture' => $_FILES['picture']['name'],
                    'info' => $_POST['info'],
                    'price' => $_POST['price'],
                    'stock' => $_POST['stock']
                ];
                $targetFile = $fileUploadDir . basename($_FILES['picture']['name']);
                $imgFileType = strtolower(pathinfo($fileUploadDir, PATHINFO_EXTENSION));
                $imageFormats = ["jpg", "jpeg"];

                if (in_array($imgFileType, $imageFormats)) {
                    $imageBase64 = base64_encode(file_get_contents($_FILES['picture']['tmp_name']));
                    $image = 'data:image/' . $imgFileType . ';base64' . $imageBase64;
                }

                if (move_uploaded_file($_FILES['picture']['tmp_name'], $fileUploadDir . $data['picture'])) {
                    echo "File uploaded";
                }


            }
            if ($admin->addNewCar($data)) {
                header('Location: ../CarController/index?message=success', true, 301);
                exit();
            }

        }

    }

    public function updateCar()
    {
        session_start();
        if (!$_SESSION['adminID']) {
            header('Location: ../HomeController/login', true, 301);
            exit();
        }
        $admin = new Admin();
        $cars = new Car();

        $id = isset($_GET['id']) ? $_GET['id'] : null;
        $message = isset($_GET['success']) ? $_GET['success'] : null;

        $data = $cars->getCar($id);

        $name = '';
        foreach ($data as $d) {
            $name = $d['name'];
        }

        $name = isset($_GET['name']) ? $_GET['name'] : null;

        $this->view->render('admin' . DIRECTORY_SEPARATOR . 'updateCar', $data);

        $fileUploadDir = dirname(dirname(__DIR__)) . DIRECTORY_SEPARATOR . 'public' . DIRECTORY_SEPARATOR . 'uploads' . DIRECTORY_SEPARATOR;


        if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['model'])) {
            if (!empty($_FILES['picture']['name']) && isset($_FILES['picture']['name'])) {
                $data = [
                    'id' => $_POST['id'],
                    'name' => $_POST['name'],
                    'model' => $_POST['model'],
                    'picture' => $_FILES['picture']['name'],
                    'info' => $_POST['info'],
                    'price' => $_POST['price'],
                    'stock' => $_POST['stock']
                ];
                $targetFile = $fileUploadDir . basename($_FILES['picture']['name']);
                $imgFileType = strtolower(pathinfo($fileUploadDir, PATHINFO_EXTENSION));
                $imageFormats = ["jpg", "jpeg"];

                if (in_array($imgFileType, $imageFormats)) {
                    $imageBase64 = base64_encode(file_get_contents($_FILES['picture']['tmp_name']));
                    $image = 'data:image/' . $imgFileType . ';base64' . $imageBase64;
                }

                if (move_uploaded_file($_FILES['picture']['tmp_name'], $fileUploadDir . $data['picture'])) {
                    echo "New file uploaded";
                }


            }
            if ($admin->updateCar($data)) {
                //var_dump($data);
                header('Location: ../CarController/index?message=success', true, 301);
                exit();
            }

        }
    }

    public function deleteCar()
    {
        session_start();
        if (!$_SESSION['adminID']) {
            header('Location: ../HomeController/login', true, 301);
            exit();
        }

        $cars = new Car();
        $admin = new Admin();

        $id = isset($_GET['id']) ?: null;
        $data = $cars->getCar($id);

        $name = '';
        if (is_array($data)) {
            foreach ($data as $d) {
                $name = $d['name'];
            }
        }

        $message = isset($_GET['success']) ? $_GET['success'] : null;

        if ($admin->deleteCar($data)) {
            header('Location: ../CarController/index?message=success', true, 301);
            exit();
        }
    }

    public function manageUsers()
    {
        session_start();
        if (!$_SESSION['adminID']) {
            header('Location: ../HomeController/login', true,301);
            exit();
        }

        $admin = new Admin();

        $data = $admin->showUsers();

        $this->view->render('admin' . DIRECTORY_SEPARATOR . 'manageUsers', $data);
    }

    public function deleteUser()
    {
        session_start();
        if (!$_SESSION['adminID']) {
            header('Location: ..HomeController/login', true, 301);
            exit();
        }
        $admin = new Admin();

        $users = new User();

        $id = isset($_GET['id']) ? $_GET['id'] : null;
        $message = isset($_GET['success']) ? $_GET['success'] : null;

        $data = $users->getUser($id);

        if ($admin->deleteUser($id)) {
            header('Location: ../CarController/index?message=success', true, 301);
            exit();
        } else {
            die('Something went wrong');
        }
    }

    public function rent()
    {
        session_start();
        if (!$_SESSION['adminID']) {
            header('..HomeController/login', true, 301);
            exit();
        }

        $car = new Car();

        $data = $car->read($_SESSION['userID']);

        $this->view->render('admin' . DIRECTORY_SEPARATOR . 'rent', $data);
    }

}




