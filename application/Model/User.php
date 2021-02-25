<?php

namespace Application\Model;

ini_set("display_errors", 1);
error_reporting(E_ALL);

use PDO;
use Application\Lib\DB;

class User
{
    public function doesEmailExists($email)
    {
        $sql = "SELECT * FROM users WHERE email = :email";
        $stmt = DB::getInstance()->prepare($sql);
        $stmt->bindParam(':email', $email);
        $stmt->execute();

        return ($stmt->rowCount() ? $stmt->fetch(PDO::FETCH_ASSOC) : false);
    }
	public function doesUserExists($id)
	{
        $sql = "SELECT * FROM users WHERE id = :id";
        $stmt = DB::getInstance()->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        if ($stmt->rowCount() > 0) {
            return true;
        }
        return false;
	}

    public function register($id, $data)
    {
    	$sql = "INSERT INTO users (id, firstname, lastname, email, password, username, phone_number, join_time, role_id) VALUES (:id, :firstname, :lastname, :email, :password, :username, :phone_number, :join_time, :role_id)";
    	$stmt = DB::getInstance()->prepare($sql);
    	$stmt->bindParam(':id', $id);
    	$stmt->bindParam(':firstname', $data['firstname']);
    	$stmt->bindParam('lastname', $data['lastname']);
    	$stmt->bindParam(':email', $data['email']);
    	$stmt->bindParam(':password', $data['password']);
    	$stmt->bindParam('username', $data['username']);
    	$stmt->bindParam(':phone_number', $data['phone_number']);
    	$stmt->bindParam(':join_time', $data['join_time']);
    	$stmt->bindParam(':role_id', $data['role_id']);

    	if ($stmt->execute()) {
    	    return true;
        }
    	return false;
    }

    public function login($username, $email, $password)
    {
        $sql = "SELECT id FROM users WHERE username = :username OR email = :email OR password = :password";
        $stmt = DB::getInstance()->prepare($sql);
        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':password', $password);
        $stmt->execute();
        $id = null;
        while ($rows = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $id = $rows['id'];
        }
        return $id;
    }

    public function getPassword($email, $password)
    {
        $sql = "SELECT password FROM users WHERE email = :email AND password = :password";
        $stmt = DB::getInstance()->prepare($sql);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':password', $password);
        $stmt->execute();

        $pass = $stmt->fetch(PDO::FETCH_ASSOC);
        $fetchRow = $stmt->rowCount();

        return $fetchRow;
    }

    /* Password changer */
    public function recoverPassword($data)
    {
        $sql = "SELECT password FROM users WHERE email = :email AND password = :password";
        $stmt = DB::getInstance()->prepare($sql);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':password', $password);
        $stmt->execute();

        $numOfRows= $stmt->rowCount();

        if ($numOfRows > 0) {
            $sql = "UPDATE users SET password = :password WHERE email = :email";
            $stmt = DB::getInstance()->prepare($sql);
            $stmt->bindParam(':email', $data['email']);
            $stmt->bindParam(':password', $data['password']);

            $stmt->execute();
        }
        return true;
    }

    public function getUsers()
    {
        $sql = "SELECT * FROM users";
        $stmt = DB::getInstance()->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getNumberOfUsers()
    {
        $sql = "SELECT COUNT(id) AS number_of_users FROM users";
        $stmt = DB::getInstance()->prepare($sql);
        $stmt->execute();
        return ($stmt->rowCount() ? $stmt->fetch(PDO::FETCH_ASSOC) : false);
    }

    public function getUser($id)
    {
        $sql = "SELECT * FROM users WHERE id = :id";
        $stmt = DB::getInstance()->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        $rows = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $rows[] = $row;
        }
        //return $rows;
        return isset($rows) ? $rows : '';
    }

    public function userAccount($id)
    {

        $sql = "SELECT firstname, lastname, email, password, username, phone_number, join_time FROM users WHERE id = :id";
        $stmt = DB::getInstance()->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        $rows = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $rows[] = $row;
        }
        return $rows;
    }

    public function updateUserData($data)
    {
        $sql = "UPDATE users SET firstname = :firstname, lastname = :lastname, email = :email, username = :username, phone_number = :phone_number WHERE id = :id";
        $stmt = DB::getInstance()->prepare($sql);
        $stmt->bindParam(':id', $data['id']);
        $stmt->bindParam(':firstname', $data['firstname']);
        $stmt->bindParam(':lastname', $data['lastname']);
        $stmt->bindParam(':email', $data['email']);
        $stmt->bindParam(':username', $data['username']);
        $stmt->bindParam(':phone_number', $data['phone_number']);

        $stmt->execute();

        return true;
    }

}