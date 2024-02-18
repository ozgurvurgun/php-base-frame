<?php

namespace BaseFrame\System\Database;

use PDO;
use PDOException;

class Database
{
    protected $db = null;
    protected $stmt = null;
    private $hostname;
    private $username;
    private $password;
    private $databaseName;
    private $charset;
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
        $this->charset = $DB_CHAREST;
        try {
            $this->db = new PDO("mysql:host=$this->hostname;dbname=$this->databaseName;charset=$this->charset", "$this->username", "$this->password");
            $this->db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
        } catch (PDOException $e) {
            die('<pre><span style="color:red">CONNECTION ERROR: </span>' . $e->getMessage() . '</pre>');
        }
    }
}
