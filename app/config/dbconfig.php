<?php

namespace config;

use PDO;
use PDOException;

class dbconfig
{
    protected $connection;
    private $servername = 'mysql';
    private $username = 'user';
    private $password = 'secret123';
    private $database = 'db_haarlem_festival';

    public function __construct()
    {
        $this->connect();
    }

    private function connect()
    {
        try {
            $this->connection = new PDO("mysql:host=$this->servername;dbname=$this->database", $this->username, $this->password);
            $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            echo "Connection failed: " . $e->getMessage();
            $this->connection = null;
        }
    }

    public function getConnection()
    {
        return $this->connection;
    }
}
