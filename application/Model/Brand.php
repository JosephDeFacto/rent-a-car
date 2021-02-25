<?php

namespace Application\Model;

ini_set("display_errors", 1);
error_reporting(E_ALL);

use Application\Lib\DB;


class Brand
{
    public function getBrands()
    {
        $sql = "SELECT * FROM brands";
        $stmt = DB::getInstance()->prepare($sql);
        $stmt->execute();

        $brands = $stmt->fetch(\PDO::FETCH_ASSOC);
        return $brands;
    }

    public function getBrandById($id)
    {
        $sql = "SELECT * FROM brands WHERE id = :id";
        $stmt = DB::getInstance()->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        $brand = $stmt->fetch(\PDO::FETCH_ASSOC);

        return $brand;
    }

    public function getCarsByBrand($id)
    {
        $sql = "SELECT name, model, picture, info, price, stock, name FROM cars c
                INNER JOIN brands_cars bc ON c.id = bc.car_id
                INNER JOIN brands b ON bc.brand_id = b.id
                WHERE bc.brand_id = b.id";
        $stmt = DB::getInstance()->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        $carsByBrand = $stmt->fetch(\PDO::FETCH_ASSOC);

        return $carsByBrand;
    }
}