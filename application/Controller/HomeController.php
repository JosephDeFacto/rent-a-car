<?php

namespace Application\Controller;

ini_set("display_errors", 1);
error_reporting(E_ALL);

use Application\Lib\View;
use Application\Model\Admin;
use Application\Model\User;

class HomeController
{
    public $view;

    public function __construct()
    {
        $this->view = new View();
    }
    public function index()
    {
        $this->view->render('users' . DIRECTORY_SEPARATOR . 'index');
    }

    public function login()
    {

        $users = new User();
        $admin = new Admin();

        $this->view->render('home' . DIRECTORY_SEPARATOR . 'login');

        try {
            if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                $username = $_POST['username'];
                $email = $_POST['email'];
                $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

                if ($admin->login($username, $email, $password)) {
                    $_SESSION['adminID'] = $admin->login($username, $email, $password);
                    $_SESSION['username'] = $username;
                    $_SESSION['email'] = $email;

                    header('Location: ../CarController/index', true, 301);
                    exit();


                } else if ($users->login($username, $email, $password)) {
                    $_SESSION['userID'] = $users->login($username, $email,$password);
                    $_SESSION['username'] = $username;
                    $_SESSION['email'] = $email;

                    header('Location: ../CarController/index', true, 301);
                    exit();

                } else {
                    header('Location: ../HomeController/login', true, 301);
                    exit();
                }
            }
        } catch (\PDOException $exception) {
            echo $exception->getCode();
        }
    }
}