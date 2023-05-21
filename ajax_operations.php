<?php

use Abyzs\Spa\Classes\Operations;

require_once __DIR__ . '/vendor/autoload.php';

$operationsRow = new Operations();

switch ($_POST['action']) {
    case 'add':
        if (!empty($_POST['data']['amount']) && $_POST['data']['amount'] != 0 && !empty($_POST['data']['operation'])) {
            $amount = htmlspecialchars(trim($_POST['data']['amount']));
            $operation = htmlspecialchars(trim($_POST['data']['operation']));
            $comment = $_POST['data']['comment'] ? htmlspecialchars(trim($_POST['data']['comment'])) : '';

            $addOperation = $operationsRow->addOperation((float) $amount, $operation, $comment);

            if ($addOperation == 'success') {
                $lastOperaon = $operationsRow->lastInsertOperation();

                $html = '<tr id="trBody">' .
                    '<td class="td">' . $lastOperaon[0]['amount'] . '</td>' .
                    '<td class="td">' . $lastOperaon[0]['operation'] . '</td>' .
                    '<td class="td">' . $lastOperaon[0]['comment'] . '</td>' .
                    '<td class="tdBtn">' .
                    '<button class="deleteOperation" data-id="' . $lastOperaon[0]['id'] . '">Удалить</button>' .
                    '</td>' .
                    '</tr>';

                $data = [
                    'html' => $html,
                    'summPrihod' => $operationsRow->summAllPrihod(),
                    'summRashod' => $operationsRow->summAllRashod()
                ];

                echo json_encode($data);
            }
        }
        break;
    case 'delete':
        if ($operationsRow->deleteOperation($_POST['id'])) {
            $operations = $operationsRow->getOperations(0, 10);

            if (count($operations) > 0) {
                for ($i = 0; $i < count($operations); $i++) {
                    $html .= '<tr id="trBody">' .
                        '<td class="td">' . $operations[$i]['amount'] . '</td>' .
                        '<td class="td">' . $operations[$i]['operation'] . '</td>' .
                        '<td class="td">' . $operations[$i]['comment'] . '</td>' .
                        '<td class="tdBtn">' .
                        '<button class="deleteOperation" data-id="' . $operations[$i]['id'] . '">Удалить</button>' .
                        '</td>' .
                        '</tr>';
                }
            }

            $data = [
                'html' => $html,
                'summPrihod' => $operationsRow->summAllPrihod(),
                'summRashod' => $operationsRow->summAllRashod()
            ];

            echo json_encode($data);
        }
        break;
}