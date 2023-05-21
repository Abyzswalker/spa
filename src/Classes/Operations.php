<?php

namespace Abyzs\Spa\Classes;

use Abyzs\Spa\Classes\DB\Connection;
use Abyzs\Spa\Classes\DB\Database;

class Operations
{
    private Database $pdo;
    private $msg = [];

    public function __construct()
    {
        $this->pdo = new Database((new Connection())->getConnection());
    }

    public function getOperations(int $start = 0, int $limit = 99999): array
    {
        return $this->pdo->query("SELECT * FROM `operations` WHERE id > 0 ORDER BY date DESC LIMIT :start, :limit",
            ['start' => $start, 'limit' => $limit]
        );
    }

    public function addOperation(float $amount, string $operation, string $comment = null): string
    {
        try {
            $today = date("Y-m-d H:i:s");

            $insert = $this->pdo->query("INSERT INTO `operations` (amount, operation, comment, date)
            VALUES (:amount, :operation, :comment, :date)", [
                'amount' => $amount,
                'operation' => $operation,
                'comment' => $comment,
                'date' => $today
            ]);

            if ($insert > 0) {
                return $this->msg['msg'] = 'success';
            }

            $this->pdo->dbClose();
        } catch (\PDOException $e) {
            return $this->msg['msg'] = 'error';
        }
    }

    public function deleteOperation(int $id): bool
    {
        try {
            $this->pdo->query("DELETE FROM operations WHERE id = :id",
                ['id' => $id]);

            return true;
        } catch (\PDOException $e) {
            return false;
        }
    }

    public function lastInsertOperation(): array
    {
        $lastId = $this->pdo->lastInsertId();

        return $this->pdo->query("SELECT * FROM operations WHERE id = :id",
            ['id' => $lastId]);
    }

    public function summAllPrihod(): float
    {
        $summ = $this->pdo->query("SELECT SUM(amount) FROM operations WHERE operation = :operation",
            ['operation' => 'Приход']);

        return $summ[0]['SUM(amount)'] != null ? round($summ[0]['SUM(amount)'], 3) : 0;
    }

    public function summAllRashod(): float
    {
        $summ = $this->pdo->query("SELECT SUM(amount) FROM operations WHERE operation = :operation",
            ['operation' => 'Расход']);

        return $summ[0]['SUM(amount)'] != null ? round($summ[0]['SUM(amount)'], 3) : 0;
    }
}