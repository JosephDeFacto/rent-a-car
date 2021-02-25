<?php

namespace Application\Controller;

ini_set("display_errors", 1);
error_reporting(E_ALL);

use Application\Lib\Request;
use Application\Lib\View;
use Application\Model\Admin;
use Application\Model\Car;
use Application\Model\User;

class UserController
{
    public $view;

    public function __construct()
    {
        $this->view = new View();
    }

    public function register()
    {
        $users = new User();

        $id = array_key_exists('id', $_GET) ?: null;

        $this->view->render('users' . DIRECTORY_SEPARATOR . 'register');

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $data = [
                'id' => $_POST['id'],
                'firstname' => $_POST['firstname'],
                'lastname' => $_POST['lastname'],
                'email' => $_POST['email'],
                'password' => password_hash($_POST['password'], PASSWORD_DEFAULT),
                'confirm_password' => $_POST['confirm_password'],
                'username' => $_POST['username'],
                'phone_number' => $_POST['phone_number'],
                'role_id' => $_POST['role_id']
            ];


            if ($users->doesEmailExists($data['email'])) {
                echo "<script type=\"text/javascript\">alert('Email already exists.');</script>";
                exit();
            }

            if (empty($errors['email_err'])) {
                if ($users->register($id, $data)) {
                    header('Location: ../HomeController/login', true, 301);
                    exit();
                    //echo "Registered";
                }
            } else {
                $this->view->render('users' . DIRECTORY_SEPARATOR . 'register', $errors);
            }

        }
    }

    public function account()
    {
        session_start();
        if (!$_SESSION['userID']) {
            header('Location: ../HomeController/login', true, 301);
            exit();

        }
        $users = new User();

        $id = isset($_SESSION['userID']) ? $_SESSION['userID'] : null;

        $data = $users->userAccount($id);

        $this->view->render('users' . DIRECTORY_SEPARATOR . 'account', $data);
    }

    public function changePassword()
    {
        session_start();
        if (!$_SESSION['userID']) {
            header('Location: ../HomeController/login', true, 301);
            exit();
        }

        $user = new User();

        $this->view->render('users' . DIRECTORY_SEPARATOR . 'changePassword');

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $data = [
                'firstname' => $_POST['firstname'],
                'lastname' => $_POST['lastname'],
                'email' => $_SESSION['email'],
                'password' => $_POST['password'],
                'new-password' => $_POST['newpassword']
            ];

            if ($user->recoverPassword($data)) {
                header('Location: ../HomeController/login', true, 301);
                exit();
            }
        }
    }

    public function update()
    {
        session_start();
        if (!$_SESSION['userID']) {
            header('Location: ../HomeController/index', true, 301);
            exit();
        }
        $users = new User();

        $id = isset($_SESSION['userID']) ? $_SESSION['userID'] : null;
        $data = $users->getUser($id);
        $message = isset($_GET['success']) ? $_GET['success'] : null;


        $this->view->render('users' . DIRECTORY_SEPARATOR . 'update', $data);

        if ($_SERVER['REQUEST_METHOD'] == 'POST' && $_POST['update']) {
            $data = [
                'id' => $_SESSION['userID'],
                'firstname' => $_POST['firstname'],
                'lastname' => $_POST['lastname'],
                'email' => $_POST['email'],
                'username' => $_POST['username'],
                'phone_number' => $_POST['phone_number'],
            ];

            if ($users->updateUserData($data)) {
                //echo "Updated";
                header('Location: ../UserController/account?message=success', true, 301);
                exit();
            }
        }
    }

    public function rent()
    {
        session_start();
        if (!$_SESSION['userID']) {
            header('Location: ../HomeController/login', true, 301);
            exit();
        }

        $car = new Car();

        $data = $car->read($_SESSION['userID']);

        $this->view->render('users' . DIRECTORY_SEPARATOR . 'rent', $data);
    }

    public function logout()
    {
        session_start();
        unset($_SESSION['userID']);
        session_destroy();

        header('Location: ../HomeController/login', true, 301);
        exit();

    }
}