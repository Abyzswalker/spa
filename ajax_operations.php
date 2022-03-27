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
    if (!empty($_POST['data']['comment'])) {
        $comment = trim($_POST['data']['comment']);
        $comment = htmlspecialchars($comment);
    } else {
        $comment = null;
    }
}


switch ($_POST['key']) {
    case 'add':
        $addOperation = $operationRow->addOperation($amount, $operation, $comment);
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
        break;
    case 'delete':
        $deleteOperation = $operationRow->deleteOperation($_POST['id']);
        $allOperation = $operationRow->allOperations(0, 10);

        $summPhihod = $operationRow->summAllPrihod();
        $summRashod = $operationRow->summAllRashod();

        $html = '';

        if (count($allOperation) > 0) {
            for ($i = 0; $i < count($allOperation); $i++) {
                $html .= '<tr id="trBody">' .
                    '<td class="td">' . $allOperation[$i]['amount'] . '</td>' .
                    '<td class="td">' . $allOperation[$i]['operation'] . '</td>' .
                    '<td class="td">' . $allOperation[$i]['comment'] . '</td>' .
                    '<td class="tdBtn">' .
                    '<button class="deleteOperation" data-id="' . $allOperation[$i]['id'] . '">Удалить</button>' .
                    '</td>' .
                    '</tr>';
            }
        }
        echo json_encode([$html, $summPhihod, $summRashod]);
        break;
}






//$articlesRow = new Articles($connection);
//$allArticles = $articlesRow->allArticles(0, 2);
//$countArticles = $articlesRow->countArticles();
//
//$count = ceil($countArticles[0] / 2);




//    <div class="afterPosts" style="text-align: center">
//    <a id="loadMore" type="button" name="loadMore" class="btn btn-outline-secondary loadMore" data-page="1"
/*    data-max="<?php echo $count; ?>">*/
//    Load more
//    <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
//    <span class="visually-hidden">Loading...</span>
//    </a>
//    </div>
//


//$limit = 2;
//$page = intval(@$_GET['page']);
//$page = (empty($page)) ? 1 : $page;
//$start = ($page != 1) ? $page * $limit - $limit : 0;
//$articlesRow = new Articles($connection);
//if (!empty($_GET['catId'])) {
//$nextPageArticle = $articlesRow->articleOnCategory($_GET['catId'], $start, $limit);
//} else {
//    $nextPageArticle = $articlesRow->allArticles($start, $limit);
//}