<?php

namespace Spa\Classes;

class Users
{
    private $pdo;
    private $msg = [];

    public function __construct(Database $pdo)
    {
        $this->pdo = $pdo;
    }

    public function addUser($login, $pass, $email)
    {
        $insert = $this->pdo->query("INSERT INTO users (login, pass, email)
            VALUES (:login, :pass, :email)", [
            'login' => $login,
            'pass' => $pass,
            'email' => $email
        ]);

        if ($insert > 0) {
            return $this->msg['msg'] = 'signUp';
        }
    }

    public function checkUserLogin($login)
    {
        return $this->pdo->query("SELECT login FROM users WHERE `login` = :login", ['login' => $login]);
    }

    public function validateUser($login, $pass)
    {
        $query = $this->pdo->query("SELECT login, pass FROM users WHERE `login` = :login && `pass` = :pass", ['login' => $login, 'pass' => $pass]);

        if ($query) {
            return $this->msg = 'signIn';
        } else {
            return $this->msg = 'error';
        }
    }
}