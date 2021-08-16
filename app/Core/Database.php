<?php

declare(strict_types=1);

namespace Core;

use PDO;
use PDOException;

use function printf;

class Database
{
    private $pdo;

    public function __construct()
    {
        try {
            $this->pdo = new PDO(getenv('DATABASE_DNS'));
            $this->pdo->setAttribute(\PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->pdo->setAttribute(\PDO::MYSQL_ATTR_INIT_COMMAND, "SET NAMES utf8mb4");
            $this->pdo->setAttribute(\PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
            return $this->pdo;
        } catch (PDOException $ex) {
            exit(printf('Connection Error: %s', $ex->getMessage()));
        }
    }

    public function getConnection()
    {
        if ($this->pdo instanceof PDO) {
            return $this->pdo;
        }
    }

    public function __destruct()
    {
        $this->pdo = null;
    }
}
