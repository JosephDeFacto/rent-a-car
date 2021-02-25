<?php

namespace Application\Model;

ini_set("display_errors", 1);
error_reporting(E_ALL);

use Application\Lib\DB;

class Rental
{
    public function getCarRentedByUser($id)
    {
        $sql = "SELECT firstname, lastname, name, picture, info, price FROM users 
                INNER JOIN cars_users ON users.id = cars_users.user_id 
                INNER JOIN cars ON cars_users.car_id = cars.id";
        $stmt = DB::getInstance()->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        $userRentals = $stmt->fetchAll(\PDO::FETCH_ASSOC);
        return $userRentals;
    }

    public function getLocationById($id)
    {
        $sql = "SELECT * FROM rent_locations WHERE id = :id";
        $stmt = DB::getInstance()->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        $locationID = $stmt->fetch(\PDO::FETCH_ASSOC);

        return $locationID;
    }

    public function insertRentLocation($data)
    {
        $sql = "INSERT INTO rent_locations (pickup_location, pickup_date, pickup_time, return_location, return_date, return_time, car_id, user_id)
                VALUES (:pickup_location, :pickup_date, :pickup_time, :return_location, :return_date, :return_time, :car_id, :user_id)";
        $stmt = DB::getInstance()->prepare($sql);
        $carID = $data['car_id'];
        $userID = $data['user_id'];
        $stmt->bindParam(':pickup_location', $data['pickup_location']);
        $stmt->bindParam(':pickup_date', $data['pickup_date']);
        $stmt->bindParam(':pickup_time', $data['pickup_time']);
        $stmt->bindParam(':return_location', $data['return_location']);
        $stmt->bindParam(':return_date', $data['return_date']);
        $stmt->bindParam(':return_time', $data['return_time']);
        $stmt->bindParam(':car_id', $carID);
        $stmt->bindParam(':user_id', $userID);

       $stmt->execute();

       return true;
    }

    public function getRentalUserInfoById($id)
    {

    }

    /*
     * User can see his rented car, date&time and pickup&return location
     *  */

    /*
    public function insertRentLocation($data)
    {
        $sql = "INSERT INTO rent_locations(pickup_location, pickupDateAndTime, return_location, returnDateAndLocation)
                VALUES (:pickup_location, :pickupDateAndTime, :return_location, :returnDateAndLocation)";
        $stmt = DB::getInstance()->prepare($sql);
        $stmt->bindParam(':pickup_location', $data['pickup_location']);
        $stmt->bindParam(':pickupDateAndTime', $data['pickupDateAndTime']);
        $stmt->bindParam(':return_location', $data['return_location']);
        $stmt->bindParam(':returnDateAndLocation', $data['returnDateAndLocation']);
        $stmt->execute();

        return true;
    }
    */
    /*
    public function rentLocation($location_id, $car_id, $user_id)
    {
        $sql = "INSERT INTO locations_cars (location_id, car_id, user_id) VALUES (:location_id, :car_id, :user_id)";
        $stmt = DB::getInstance()->prepare($sql);
        $stmt->bindParam(':location_id', $location_id);
        $stmt->bindParam(':car_id', $car_id);
        $stmt->bindParam(':user_id', $user_id);
        $stmt->execute();

        return true;
    }

    public function getRentLocations()
    {
        $sql = "SELECT * FROM rent_locations";
        $stmt = DB::getInstance()->prepare($sql);
        $stmt->execute();

        $locations = $stmt->fetch(\PDO::FETCH_ASSOC);

        return $locations;
    }
    */
    /*
    public function getRentLocation($id)
    {
        $sql = "SELECT * FROM rent_locations WHERE id = :id";
        $stmt = DB::getInstance()->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        $rentLocation = $stmt->fetch(\PDO::FETCH_ASSOC);

        return $rentLocation;
    }
    */
}