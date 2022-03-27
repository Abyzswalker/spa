<?php

use Spa\Classes\Database;
use Spa\Classes\Users;

require_once __DIR__ . '/vendor/autoload.php';
require_once 'config.php';

$msg = [];
$usersRow = new Users(new Database($config['db']));

if ($_POST['data']['login'] && $_POST['data']['password']) {
    $login = filter_var(trim($_POST['data']['login']), FILTER_SANITIZE_STRING);
    $pass = filter_var(trim($_POST['data']['password']), FILTER_SANITIZE_STRING);
    $pass = md5($pass."test12345");
    $email = filter_var(trim($_POST['data']['email']), FILTER_SANITIZE_STRING);
}

$user = $usersRow->checkUser($login);

switch ($_POST['key']) {
    case 'up':
        if (!empty($user)) {
            $msg['error'] = 'This user already exists.';
            echo json_encode($msg);
        } elseif (empty($user)) {
            $usersRow->addUser($login, $pass, $email);
            if ($usersRow->msg['msg']) {
                echo json_encode($usersRow->msg);
            }
        }
        break;
    case 'in':
        if (!empty($user)) {
            //3600
            setcookie('user', $user[0]['login'], time() + 3600, '/');
            $msg['msg'] = 'signIn';
            echo json_encode($msg);
        } elseif (!$user) {
            if (empty($user)) {
                $msg['error'] = 'error';
                echo json_encode($msg);
            }
        }
        break;
//    case 'logout':
//        //var_dump('kuki', $_COOKIE['user']);
//        unset($_COOKIE['user']);
//        setcookie('user', null, -1, '/');
//        //header("Location: http://blog/index.php");
//        break;
}