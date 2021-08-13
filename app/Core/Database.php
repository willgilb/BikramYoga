<?php

declare(strict_types=1);

namespace Core;

use PDO;
use PDOException;

use function define;
use function printf;

define('DSN', sprintf('%s:host=%s;port=%d;dbname=%s;charset=%s;user=%s;password=%s', DRIVER, HOST, PORT, DBNAME, CHARSET, USER, PASSWORD));

class Database
{
    private $pdo;

    public function __construct()
    {
        try {
            $this->pdo = new PDO(DSN);
            $this->pdo->setAttribute(\PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->pdo->setAttribute(\PDO::MYSQL_ATTR_INIT_COMMAND, sprintf("SET NAMES %s", CHARSET));
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
