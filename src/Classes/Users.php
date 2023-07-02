<?php

namespace Abyzs\Spa\Classes;

use Abyzs\Spa\Classes\DB\Database;

class Users
{
    private Database $pdo;

    public function __construct(Database $database)
    {
        $this->pdo = $database;
    }

    public function addUser(string $login, string $pass, string $email): bool
    {
        try {
            $insert = $this->pdo->query("INSERT INTO `users` (login, pass, email)
            VALUES (:login, :pass, :email)", [
                'login' => $login,
                'pass' => $pass,
                'email' => $email
            ]);

            if ($insert > 0) {
                return true;
            }

            $this->pdo->dbClose();
        } catch (\PDOException $e) {
            return false;
        }
    }

    public function checkUserLogin($login): array
    {
        return $this->pdo->query("SELECT `login` FROM users WHERE `login` = :login", ['login' => $login]);
    }

    public function validateUser($login, $pass): bool
    {
        $user = $this->pdo->query("SELECT `login`, `pass` FROM users WHERE `login` = :login && `pass` = :pass",
            ['login' => $login, 'pass' => $pass]);

        if ($user) {
            return true;
        } else {
            return false;
        }
    }
}