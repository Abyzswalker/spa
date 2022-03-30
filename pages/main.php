<div class="inputBlock">
    <div class="logoutBlock"><h3><?=$_COOKIE['user'] ?></h3><button class="btn btn-primary" id="logoutBtn">Logout</button></div>
    <form class="inputForm" id="inputForm">
        <div class="form-floating" id="blockSumma">
            <input type="number" class="form-control" name="formAmount" id="formAmount" placeholder="Сумма">
            <label for="formAmount">Сумма</label>
        </div>
        <div class="mb-3" id="blockSelect">
            <select class="form-select" id="formSelect" aria-label="Default select example">
                <option selected value="Приход">Приход</option>
                <option value="Расход">Расход</option>
            </select>
        </div>
        <div class="form-floating" id="blockComment">
            <textarea class="form-control" id="formComment" placeholder="Leave a comment here" style="height: 100px"></textarea>
            <label for="floatingTextarea2">Comments</label>
        </div>
        <button id="submitBtn" type="submit" class="btn btn-primary">Добавить</button>
    </form>
</div>


<div class="tableOperationBlock" id="tableOperationBlock">
    <table class="operationTable" id="operationTable">
        <caption><h3>Операции</h3></caption>

        <thead>
            <tr>
                <td class="td">Сумма</td>
                <td class="td">Операция</td>
                <td class="td">Комментарий</td>
                <td class="td">Действие</td>
            </tr>
        </thead>

        <tbody id="operationBody">
        <?php foreach ($getOperations as $item) { ?>
            <tr id="trBody">
                <td class="td"><?= $item['amount'] ?></td>
                <td class="td"><?= $item['operation'] ?></td>
                <td class="td"><?= $item['comment'] ?></td>
                <td class="tdBtn">
                    <button class="deleteOperation" data-id="<?= $item['id'] ?>">Удалить</button>
                </td>
            </tr>
        <?php } ?>
        </tbody>
    </table>


    <table class="summTable">
        <tbody id="summBody">
        <tr>
            <td>Итого Приход</td>
            <?php
            $summPhihod = $operationsRow->summAllPrihod();
            if ($summPhihod < 1) { ?>
                <td id="tdSummPrihod" colspan="2">0</td>
            <?php } else { ?>
                <td id="tdSummPrihod" colspan="2"><?= $summPhihod ?></td>
            <?php } ?>
        </tr>
        <tr>
            <td>Итого Расход</td>
            <?php
            $summRashod = $operationsRow->summAllRashod();
            if ($summRashod < 1) { ?>
                <td id="tdSummRashod" colspan="2">0</td>
            <?php } else { ?>
                <td id="tdSummRashod" colspan="2"><?= $summRashod ?></td>
            <?php } ?>
        </tr>
        </tbody>
    </table>
</div>

