<?php

namespace Abyzs\Spa\Unit\DB;

use Abyzs\Spa\Classes\DB\Connection;
use PHPUnit\Framework\TestCase;

class ConnectionTest extends TestCase
{
    private Connection $conn;

    protected function setUp(): void
    {
        $this->conn = new Connection();
    }

    public function testGetConnection(): void
    {
        $this->assertInstanceOf(\PDO::class, $this->conn->getConnection());
    }
}