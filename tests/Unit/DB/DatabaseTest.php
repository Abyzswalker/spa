<?php

namespace Abyzs\Spa\Unit\DB;

use PDO;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Abyzs\Spa\Classes\DB\Connection;
use Abyzs\Spa\Classes\DB\Database;

class DatabaseTest extends TestCase
{
    private Database $database;

    /**
     * @var MockObject|PDO
     */
    private  MockObject $pdo;

    /**
     * @var MockObject|Connection
     */
    private MockObject $connection;

    protected function setUp(): void
    {
        $this->connection = $this->createMock(Connection::class);
        $this->pdo = $this->createMock(PDO::class);


        $this->connection->expects($this->any())
            ->method('getConnection')
            ->willReturn($this->pdo);
    }

    public function testQuery(): void
    {
        $expectedResult = [];
        $pdoStatement = $this->createMock(\PDOStatement::class);

        $this->pdo->expects($this->once())
            ->method('prepare')
            ->willReturn($pdoStatement);

        $pdoStatement->expects($this->once())
            ->method('execute');

        $pdoStatement->expects($this->once())
            ->method('fetchAll')
            ->willReturn($expectedResult);


        $this->database = new Database($this->connection->getConnection());
        $result = $this->database->query("SELECT login FROM users WHERE `login` = 'admin'");

        $this->assertEmpty($result);
    }
}