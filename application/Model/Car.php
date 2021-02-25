<?php

namespace Application\Model;

ini_set("display_errors", 1);
error_reporting(E_ALL);

use Application\Lib\DB;
use PDO;

class Car
{
    public function getNumberOfCars()
    {
        $sql = "SELECT COUNT(*) AS cNum FROM cars";
        $stmt = DB::getInstance()->prepare($sql);
        $stmt->execute();
        $numOfCars = $stmt->fetchColumn();

        return $numOfCars;
    }

    public function getCars()
    {
        $sql = "SELECT * FROM cars";
        $stmt = DB::getInstance()->prepare($sql);
        $stmt->execute();
        $cars = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $cars;
    }

    public function getCar($id)
    {
        $sql = "SELECT * FROM cars WHERE id = :id";
        $stmt = DB::getInstance()->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $rows[] = $row;
        }
        //return $rows; // undefined
        return isset($rows) ? $rows : '';
    }

    public function getCarDetails($id)
    {
        $sql = "SELECT * from cars, car_prices WHERE id = :id AND car_id = :id";
        $stmt = DB::getInstance()->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->rowCount() ? $stmt->fetch(PDO::FETCH_ASSOC) : null;
    }

    public function insertRental($data)
    {
        $carId = $data['car_id'][0];
        $userId = $data['user_id'];
        $sql = "INSERT INTO cars_users (car_id, user_id) VALUES (:car_id, :user_id)";
        $stmt = DB::getInstance()->prepare($sql);
        $stmt->bindParam(':car_id', $carId);
        $stmt->bindParam(':user_id',$userId );

        $stmt->execute();

        return true;
    }

    public function deleteRent($user_id)
    {
        $sql = "DELETE * FROM cars WHERE user_id = :user_id";
        $stmt = DB::getInstance()->prepare($sql);
        $stmt->bindParam(':user_id', $user_id);
        $stmt->execute();

        return true;
    }

    public function decreaseStock($stock, $id)
    {
        $stock = (int)$stock;
        $sql = "UPDATE cars SET stock = stock - 1 WHERE id = :id";
        $stmt = DB::getInstance()->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->execute();

        if ($stmt) {
            return true;
        }
        return false;
    }

    public function getStock($id)
    {
        $sql = "SELECT stock FROM cars WHERE id = :id";
        $stmt = DB::getInstance()->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->execute();

        $stock = $stmt->fetch(PDO::FETCH_ASSOC);

        return $stock;
    }

    public function read($id)
    {
        $sql = "SELECT firstname, lastname, name, model, picture, info, price, pickup_location, pickup_date, pickup_time, return_location, return_date, return_time FROM users
                LEFT JOIN cars_users ON users.id = cars_users.user_id
                LEFT JOIN cars ON cars_users.car_id = cars.id
                LEFT JOIN rent_locations ON cars_users.car_id = rent_locations.car_id
                WHERE rent_locations.user_id = users.id";
        $stmt = DB::getInstance()->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        $cartData = $stmt->fetch(PDO::FETCH_ASSOC);

        return $cartData;
    }

    public function getCarData($id)
    {
        $sql = "SELECT name, model, picture, info, price, stock FROM cars WHERE id = :id";
        $stmt = DB::getInstance()->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->execute();

        $data = $stmt->fetch(PDO::FETCH_ASSOC);
        return $data;
    }
}