<?php

use Spa\Classes\Database;
use Spa\Classes\Operations;

require_once __DIR__ . '/vendor/autoload.php';
require_once 'config.php';

$operationRow = new Operations(new Database($config['db']));

if (!empty($_POST['data']['amount']) && !empty($_POST['data']['operation'])) {
    $amount = trim($_POST['data']['amount']);
    $amount = htmlspecialchars($amount);
    $operation = trim($_POST['data']['operation']);
    $operation = htmlspecialchars($operation);
    $comment = null;
    if (!empty($_POST['data']['comment'])) {
        $comment = trim($_POST['data']['comment']);
        $comment = htmlspecialchars($comment);
    }
}

switch ($_POST['key']) {
    case 'add':
        $addOperation = $operationRow->addOperation($amount, $operation, $comment);

        if ($addOperation == 'success') {
            $data = $operationRow->lastInsertOperation();

            $summPhihod = $operationRow->summAllPrihod();
            $summRashod = $operationRow->summAllRashod();

            $html = '<tr id="trBody">' .
                '<td class="td">' . $data[0]['amount'] . '</td>' .
                '<td class="td">' . $data[0]['operation'] . '</td>' .
                '<td class="td">' . $data[0]['comment'] . '</td>' .
                '<td class="tdBtn">' .
                '<button class="deleteOperation" data-id="' . $data[0]['id'] . '">Удалить</button>' .
                '</td>' .
                '</tr>';

            echo json_encode([$html, $summPhihod, $summRashod]);
        }
        break;
    case 'delete':
        $deleteOperation = $operationRow->deleteOperation($_POST['id']);
        $getOperation = $operationRow->getOperations(0, 10);

        $summPhihod = $operationRow->summAllPrihod();
        $summRashod = $operationRow->summAllRashod();

        if (count($getOperation) > 0) {
            for ($i = 0; $i < count($getOperation); $i++) {
                $html .= '<tr id="trBody">' .
                    '<td class="td">' . $getOperation[$i]['amount'] . '</td>' .
                    '<td class="td">' . $getOperation[$i]['operation'] . '</td>' .
                    '<td class="td">' . $getOperation[$i]['comment'] . '</td>' .
                    '<td class="tdBtn">' .
                    '<button class="deleteOperation" data-id="' . $getOperation[$i]['id'] . '">Удалить</button>' .
                    '</td>' .
                    '</tr>';
            }
        }
        echo json_encode([$html, $summPhihod, $summRashod]);
        break;
}