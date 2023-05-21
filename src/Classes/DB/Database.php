<?php

namespace Abyzs\Spa\Classes\DB;

class Database
{
    private \PDO $pdo;
    private \PDOStatement $statement;
    private array $params = [];

    public function __construct (\PDO $pdo)
    {
        try {
            $this->pdo = $pdo;
            $this->pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
            $this->pdo->setAttribute(\PDO::ATTR_EMULATE_PREPARES, false);
        } catch (\PDOException $ex) {
            throw new \InvalidArgumentException($ex->getMessage());
        }
    }

    public function query(string $query, array $params = [], $mode = \PDO::FETCH_ASSOC)
    {
        $query = trim(str_replace('\r', '', $query));
        $this->init($query, $params);
        $rowStatement = explode(' ', preg_replace("/\s+|\t+|\n+/", " ", $query));
        $statement = strtolower($rowStatement[0]);

        if ($statement === 'select' || $statement === 'show') {
            return $this->statement->fetchAll($mode);
        } elseif ($statement === 'insert' || $statement === 'update' || $statement === 'delete') {
            return $this->statement->rowCount();
        } else {
            return null;
        }
    }

    private function init(string $query, array $params = []): void
    {
        try {
            $this->statement = $this->pdo->prepare($query);

            $this->bindParams($params);

            $this->statement->execute();
        } catch (\PDOException $e) {
            exit($e->getMessage());
        }
        $this->params = [];
    }

    private function bindParams(array $params): void
    {
        if (!empty($params) && is_array($params)) {
            $columns = array_keys($params);

            foreach ($columns as &$column) {
                $this->params[count($this->params)] = [
                    ':' . $column,
                    $params[$column]
                ];
            }

            $this->bindValue($this->params);
        }
    }

    private function bindValue(array $params): void
    {
        if (!empty($params)) {
            foreach ($params as $value) {
                if (is_int($value[1])) {
                    $type = \PDO::PARAM_INT;
                } elseif (is_bool($value[1])) {
                    $type = \PDO::PARAM_BOOL;
                } elseif (is_null($value[1])) {
                    $type = \PDO::PARAM_NULL;
                } else {
                    $type = \PDO::PARAM_STR;
                }
                $this->statement->bindValue($value[0], $value[1], $type);
            }
        }
    }

    public function dbClose()
    {
        $this->pdo = null;
    }

    public function lastInsertId() {
        return $this->pdo->lastInsertId();
    }
}