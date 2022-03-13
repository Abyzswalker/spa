<?php

use Spa\Classes\Database;
use Spa\Classes\Users;

require_once __DIR__ . '/vendor/autoload.php';
require_once 'config.php';

//spl_autoload_register(function ($class_name) {
//    include 'includes/Classes/' . $class_name . '.php';
//});

//$db = new Users(new Database($config['db']));

//var_dump($db->allUsers());

//$insert = $db->query("INSERT INTO users (login, pass, email)
//     VALUES (:login, :pass, :email)", [
//    'login' => 'Admin',
//    'pass' => 123456,
//    'email' => 'admin$gmail.com'
//]);

//if ($insert > 0) {
//    print '1233333';
//}

//var_dump($_POST);


?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Базовая разметка HTML</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="style/style.css?v=<?=rand(1,1000)?>" />
</head>
<body>
<?php
include "pages/form.php";
?>

<script src="jquery-3.6.0.min.js"></script>
<script src="scripts/ajax_validationForm.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM"
        crossorigin="anonymous"></script>
</body>
</html>
