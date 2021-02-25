<?php

namespace Application\Lib;

ini_set("display_errors", 1);
error_reporting(E_ALL);

class DB extends \PDO
{
    private static $instance;

    public function __construct()
    {
        $dbConfig = Config::config('db');
        $dsn = 'mysql:host=' . $dbConfig['host'] . ';dbname=' . $dbConfig['name'];

        parent::__construct($dsn, $dbConfig['user'], $dbConfig['password']);

        $this->setAttribute(
            \PDO::ATTR_DEFAULT_FETCH_MODE,
            \PDO::FETCH_ASSOC
        );
    }

    private function __clone()
    {
        // !clone
    }

    public static function getInstance()
    {
        if (static::$instance === null) {
            self::$instance = new static();
        }

        return self::$instance;
    }
}