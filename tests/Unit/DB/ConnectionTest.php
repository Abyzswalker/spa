<?php

namespace Abyzs\Spa\Unit\DB;

use PHPUnit\Framework\TestCase;
use Abyzs\Spa\Classes\DB\Connection;

class ConnectionTest extends TestCase
{
    protected function setUp(): void {}

    public function testGetConnection(): void
    {
        $conn = new Connection();

        $this->assertInstanceOf(\PDO::class, $conn->getConnection());
    }
}