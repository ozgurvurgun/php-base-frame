<?php

namespace BaseFrame\System\Core;

use BaseFrame\System\Database\Database;
use PDOStatement;

class Model extends Database
{
    public function queryExec(string $query, array $params = null): PDOStatement
    {
        if (is_null($params)) {
            $this->stmt = $this->db->query($query);
        } else {
            $this->stmt = $this->db->prepare($query);
            $this->stmt->execute($params);
        }
        return $this->stmt;
    }

    public function __destruct()
    {
        $this->db = null;
    }
}
