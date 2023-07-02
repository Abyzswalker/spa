<?php
ini_set("display_errors", 1);
error_reporting(E_ALL);

use Abyzs\Spa\Classes\DB\Connection;
use Abyzs\Spa\Classes\DB\Database;
use Abyzs\Spa\Classes\Operations;

require_once 'vendor/autoload.php';

$operationsRow = new Operations(new Database((new Connection())->getConnection()));
$operations = $operationsRow->getOperations(0, 10);

?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Project</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="style/style.css?v=<?=rand(1,1000)?>" />
</head>
<body>

<div style="overflow-x: hidden;">
    <?php

    if (empty($_COOKIE['user'])) {
        include "pages/form.php";
    } elseif (!empty($_COOKIE['user'])) {
        include "pages/main.php";
    }

    ?>
</div>

<script src="jquery-3.6.0.min.js"></script>
<script src="scripts/ajax_validationForm.js"></script>
<script src="scripts/ajax_operations.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM"
        crossorigin="anonymous"></script>
</body>
</html>
