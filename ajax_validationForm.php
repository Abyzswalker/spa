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

    if (!empty($_POST['data']['email'])) {
        $email = filter_var(trim($_POST['data']['email']), FILTER_SANITIZE_STRING);
    }

}

$user = $usersRow->checkUserLogin($login);

switch ($_POST['key']) {
    case 'up':
        if (!empty($user)) {
            $msg['msg'] = 'error';
            echo json_encode($msg);
        } elseif (empty($user)) {
            $addUser = $usersRow->addUser($login, $pass, $email);

            if ($addUser = 'signUp') {
                setcookie('user', $login, time() + 3600, '/');
                $msg['msg'] = $addUser;
                echo json_encode($msg);
            } else {
                echo json_encode($msg['msg'] == 'error');
            }
        }
        break;
    case 'in':
        if (!empty($user)) {
            $validateUser = $usersRow->validateUser($login, $pass);

            if ($validateUser == 'signIn') {
                setcookie('user', $login, time() + 3600, '/');
                $msg['msg'] = $validateUser;
                echo json_encode($msg);
            } elseif ($validateUser == 'error') {
                $msg['msg'] = $validateUser;
                echo json_encode($msg);
            }
        }
        break;
    case 'logout':
        unset($_COOKIE['user']);
        setcookie('user', null, -1, '/');
        break;
}