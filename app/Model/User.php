<?php

declare(strict_types=1);

namespace Model;

use Core\Database;

class User
{
    public ?string $username = null;
    public ?string $email = null;
    public ?int $role_id = null;
    public ?string $pwhash = null;
    private object $db;

    public function __construct()
    {
        $pdo = new Database;
        $this->db = $pdo->getConnection();
    }

    public function insertUser()
    {
        $sql = "INSERT INTO users (username, email, role_id, pwhash) VALUES (:username, :email, :role_id, :pwhash)";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':username', $this->username, \PDO::PARAM_STR);
        $stmt->bindValue(':email', $this->email, \PDO::PARAM_STR);
        $stmt->bindValue(':role_id', $this->role_id, \PDO::PARAM_INT);
        $stmt->bindValue(':pwhash', $this->pwhash, \PDO::PARAM_STR);
        return $stmt->execute();
    }

    public function allUsers()
    {
        $sql = "SELECT * FROM users";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function byUsername(string $username)
    {

        $sql = "SELECT *
                FROM users
                INNER JOIN roles ON users.role_id = roles.id
                WHERE username = :username";

        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':username', $username, \PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetch();
    }
}
