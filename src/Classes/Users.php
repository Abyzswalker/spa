<?php

namespace Spa\Classes;

class Users
{
    private $pdo;
    public $msg = [];

    public function __construct(Database $pdo)
    {
        $this->pdo = $pdo;
    }

    public function allUsers()
    {
        return $this->pdo->query("SELECT * FROM users WHERE id > 0");
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
            return $this->msg['msg'] = 'Registration was successful';
        }
    }

    public function checkUser($login)
    {
        return $this->pdo->query("SELECT login FROM users WHERE `login` = :login", ['login' => $login]);
    }


//    public function getUserById($id)
//    {
//        $stmt = $this->connection->prepare("SELECT id, login FROM users WHERE `id` = ?");
//        $stmt->execute(["$id"]);
//        $this->user = $stmt->get_result();
//
//        return $this->user->fetch_assoc();
//    }
//
//    public function getUserByName($login)
//    {
//        $stmt = $this->connection->prepare("SELECT id, login FROM users WHERE `login` = ?");
//        $stmt->execute(["$login"]);
//        $this->user = $stmt->get_result();
//
//        return $this->user->fetch_assoc();
//    }
}