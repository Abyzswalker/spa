<?php

namespace Abyzs\Spa\Unit\DB;

use PHPUnit\Framework\TestCase;
use Abyzs\Spa\Classes\DB\Connection;
use Abyzs\Spa\Classes\DB\Database;
use PDO;

class DatabaseTest extends TestCase
{
    protected function setUp(): void {}

    public function testQuery(): void
    {
        $expectedResult = [];
        $connection = $this->createMock(Connection::class);
        $pdo = $this->createMock(PDO::class);
        $pdoStatement = $this->createMock(\PDOStatement::class);

        $connection->expects($this->any())
            ->method('getConnection')
            ->willReturn($pdo);

        $pdo->expects($this->once())
            ->method('prepare')
            ->willReturn($pdoStatement);

        $pdoStatement->expects($this->once())
            ->method('execute');

        $pdoStatement->expects($this->once())
            ->method('fetchAll')
            ->willReturn($expectedResult);

        $database = new Database($connection->getConnection());
        $result = $database->query("SELECT login FROM users WHERE `login` = 'admin'");

        $this->assertEmpty($result);
    }
}