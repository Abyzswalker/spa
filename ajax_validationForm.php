<?php

use Abyzs\Spa\Classes\DB\Connection;
use Abyzs\Spa\Classes\DB\Database;
use Abyzs\Spa\Classes\Users;

require_once __DIR__ . '/vendor/autoload.php';

$msg = [];
$usersRow = new Users(new Database((new Connection())->getConnection()));

if ($_POST['data']['login'] && $_POST['data']['password']) {
    $login = filter_var(trim($_POST['data']['login']), FILTER_SANITIZE_STRING);
    $pass = filter_var(trim($_POST['data']['password']), FILTER_SANITIZE_STRING);
    $pass = md5($pass."test12345");

    $user = $usersRow->checkUserLogin($login);

    if (!empty($_POST['data']['email'])) {
        $email = filter_var(trim($_POST['data']['email']), FILTER_SANITIZE_STRING);
    }
}

switch ($_POST['key']) {
    case 'up':
        if (!empty($user)) {
            $msg['msg'] = 'error';
            echo json_encode($msg);
        } elseif (empty($user)) {
            $addUser = $usersRow->addUser($login, $pass, $email);

            if ($addUser) {
                setcookie('user', $login, time() + 3600, '/');
                $msg['msg'] = 'signUp';
                echo json_encode($msg);
            } else {
                echo json_encode($msg['msg'] == 'error');
            }
        }
        break;
    case 'in':
        if (!empty($user)) {
            $validateUser = $usersRow->validateUser($login, $pass);

            if ($validateUser) {
                setcookie('user', $login, time() + 3600, '/');
                $msg['msg'] = 'signIn';
                echo json_encode($msg);
            } elseif (!$validateUser) {
                $msg['msg'] = 'error';
                echo json_encode($msg);
            }
        }
        break;
    case 'logout':
        unset($_COOKIE['user']);
        setcookie('user', null, -1, '/');
        break;
}