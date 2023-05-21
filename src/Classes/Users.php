<?php

namespace Abyzs\Spa\Classes;

use Abyzs\Spa\Classes\DB\Connection;
use Abyzs\Spa\Classes\DB\Database;

class Users
{
    private Database $pdo;
    private $msg = [];

    public function __construct()
    {
        $this->pdo = new Database((new Connection())->getConnection());
    }

    public function addUser(string $login, string $pass, string $email): string
    {
        try {
            $insert = $this->pdo->query("INSERT INTO `users` (login, pass, email)
            VALUES (:login, :pass, :email)", [
                'login' => $login,
                'pass' => $pass,
                'email' => $email
            ]);

            if ($insert > 0) {
                return $this->msg['msg'] = 'signUp';
            }

            $this->pdo->dbClose();
        } catch (\PDOException $e) {
            return $this->msg['msg'] = $e->getMessage();
        }
    }

    public function checkUserLogin($login): array
    {
        return $this->pdo->query("SELECT `login` FROM users WHERE `login` = :login", ['login' => $login]);
    }

    public function validateUser($login, $pass): string
    {
        $user = $this->pdo->query("SELECT `login`, `pass` FROM users WHERE `login` = :login && `pass` = :pass",
            ['login' => $login, 'pass' => $pass]);

        if ($user) {
            return $this->msg = 'signIn';
        } else {
            return $this->msg = 'error';
        }
    }
}