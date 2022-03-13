<?php

namespace Spa\Classes;

class Database
{
    private $pdo;
    private $statement;
    private $isConnected;
    private $params = [];
    protected $config = [];

    public function __construct (array $config)
    {
        $this->config = $config;

        $this->dbConnect();
    }

    private function dbConnect()
    {
        $dsn = 'mysql:host=' . $this->config['server'] . ';dbname=' . $this->config['dbname'];

        try {
            $this->pdo = new \PDO($dsn, $this->config['username'], $this->config['password'], [
                \PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES ' . $this->config['charset']
            ]);

            $this->pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
            $this->pdo->setAttribute(\PDO::ATTR_EMULATE_PREPARES, false);

            $this->isConnected = true;
        } catch (\PDOException $e) {
            exit($e->getMessage());
        }
    }

    public function dbClose()
    {
        $this->pdo = null;
    }

    private function init($query, array $params = [])
    {
        if (!$this->isConnected) {
            $this->dbConnect();
        }

        try {
            $this->statement = $this->pdo->prepare($query);
            $this->bind($params);

            if (!empty($this->params)) {
                foreach ($this->params as $param => $value) {
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
            $this->statement->execute();
        } catch (\PDOException $e) {
            exit($e->getMessage());
        }
        $this->params = [];
    }

    private function bind(array $params)
    {
        if (!empty($params) && is_array($params)) {
            $columns = array_keys($params);

            foreach ($columns as $item => &$column) {
                $this->params[count($this->params)] = [
                    ':' . $column,
                    $params[$column]
                ];
            }
        }
    }

    public function query($query, array $params = [], $mode = \PDO::FETCH_ASSOC)
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

    public function lastInsertId() {
        return $this->pdo->lastInsertId();
    }
}