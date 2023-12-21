<?php

namespace CompartSoftware\System\Database;

class Database
{
    protected $db;
    private $hostname;
    private $username;
    private $password;
    private $databaseName;
    public function __construct()
    {
        /*
        This path is used when the file will be executed directly.
        require __DIR__ . '/../../env.php';
        */
        require 'env.php';
        $this->hostname = $DB_HOST;
        $this->username = $DB_USER;
        $this->password = $DB_PASSWORD;
        $this->databaseName = $DB_NAME;
        try {
            $this->db = new \PDO("mysql:host=$this->hostname;dbname=$this->databaseName;", "$this->username", "$this->password");
            $this->db->query('SET CHARACTER SET utf8');
        } catch (\PDOException $e) {
            echo '<pre><span style="color:red">CONNECTION ERROR: </span>' . $e->getMessage() . '</pre>';
        }
    }
}
