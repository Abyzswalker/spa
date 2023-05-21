<?php

namespace Abyzs\Spa\Classes\DB;

class Connection
{
    private array $config = [];

    public function __construct()
    {
        $this->initConfig();
    }

    public function getConnection(): \PDO
    {
        try {
            if (!empty($this->config && !empty($this->getDsn()))) {
                return new \PDO($this->getDsn(), $this->config['username'], $this->config['password']);
            }
        } catch (\PDOException $e) {
            exit($e->getMessage());
        }
    }

    private function getDsn(): string
    {
        if (!empty($this->config)) {
            return 'mysql:host=' . $this->config['server'] . ';dbname=' . $this->config['dbname'] . ';charset=' . $this->config['charset'] . ';port=3306';
        } else {
            return '';
        }
    }

    private function initConfig(): void
    {
        if (is_array(Config::get())) {
            $this->config = Config::get();
        }
    }
}