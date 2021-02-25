<?php

namespace Application\Model;

ini_set("display_errors", 1);
error_reporting(E_ALL);

use Application\Lib\DB;
use PDO;

class Admin
{

    public function login($username, $email, $password)
    {
        $sql = "SELECT role_id FROM admin WHERE username = :username OR email = :email OR password = :password";
        $stmt = DB::getInstance()->prepare($sql);
        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':password', $password);
        $stmt->execute();

        $adminLogin = $stmt->fetch(PDO::FETCH_ASSOC);
        return $adminLogin;
    }
    
    public function addNewCar($data)
    {
        $sql = "INSERT INTO cars (name, model, picture, info, price, stock) VALUES (:name, :model, :picture, :info, :price, :stock)";
        $stmt = DB::getInstance()->prepare($sql);
        $stmt->bindParam(':name', $data['name']);
        $stmt->bindParam(':model', $data['model']);
        $stmt->bindParam(':picture', $data['picture']);
        $stmt->bindParam(':info', $data['info']);
        $stmt->bindParam(':price', $data['price']);
        $stmt->bindParam(':stock', $data['stock']);
        $stmt->execute();

        if ($stmt) {
            return true;
        }
        return false;
    }

    public function updateCar($data)
    {
        $sql = "UPDATE cars SET name = :name, model = :model, picture = :picture, info = :info, price = :price, stock = :stock WHERE id = :id";
        $stmt = DB::getInstance()->prepare($sql);

        $stmt->bindParam(':name', $data['name']);
        $stmt->bindParam(':model', $data['model']);
        $stmt->bindParam(':picture', $data['picture']);
        $stmt->bindParam(':info', $data['info']);
        $stmt->bindParam(':price', $data['price']);
        $stmt->bindParam(':stock', $data['stock']);
        $stmt->bindParam(':id', $data['id']);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    public function deleteCar($id)
    {
        $sql = "DELETE * FROM cars WHERE id = :id";
        $stmt = DB::getInstance()->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->execute();

        return true;
    }

    public function showUsers()
    {
        $sql = "SELECT * FROM users";
        $stmt = DB::getInstance()->prepare($sql);
        $stmt->execute();

        $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $users;
    }

    public function deleteUser($id)
    {
        $id = (int)$id;
        $sql = "DELETE * FROM users WHERE id = :id";
        $stmt = DB::getInstance()->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->execute();

        if ($stmt) {
            return true;
        }
        return false;


    }

    /*
     * Add new car
     * Update car
     * show all cars
     * show all users
     * delete user*/
}