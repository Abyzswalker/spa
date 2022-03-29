<?php

namespace Spa\Classes;

class Operations
{
    private $pdo;
    private $msg = [];

    public function __construct(Database $pdo)
    {
        $this->pdo = $pdo;
    }

    public function getOperations($start = 0, $limit = 99999)
    {
        return $this->pdo->query("SELECT * FROM operations WHERE id > 0 ORDER BY date DESC LIMIT :start, :limit",
            ['start' => $start, 'limit' => $limit]
        );
    }

    public function addOperation($amount, $operation, $comment = null)
    {
        $today = date("Y-m-d H:i:s");
        $insert = $this->pdo->query("INSERT INTO operations (amount, operation, comment, date)
            VALUES (:amount, :operation, :comment, :date)", [
            'amount' => $amount,
            'operation' => $operation,
            'comment' => $comment,
            'date' => $today
        ]);

        if ($insert > 0) {
            return $this->msg['msg'] = 'success';
        } else {
            return $this->msg['msg'] = 'error';
        }
    }

    public function deleteOperation($id)
    {
        return $this->pdo->query("DELETE FROM operations WHERE id = :id",
            ['id' => $id]);
    }


    public function lastInsertOperation()
    {
        $lastId = $this->pdo->lastInsertId();

        return $this->pdo->query("SELECT * FROM operations WHERE id = :id",
            ['id' => $lastId]);
    }

    public function summAllPrihod()
    {
        $summ = $this->pdo->query("SELECT SUM(amount) FROM operations WHERE operation = :operation", ['operation' => 'Приход']);
        return $summ[0]['SUM(amount)'];
    }

    public function summAllRashod()
    {
        $summ = $this->pdo->query("SELECT SUM(amount) FROM operations WHERE operation = :operation", ['operation' => 'Расход']);
        return $summ[0]['SUM(amount)'];
    }
}