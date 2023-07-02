<?php

namespace Abyzs\Spa\Unit;

use PHPUnit\Framework\TestCase;
use PHPUnit\Framework\MockObject\MockObject;
use Abyzs\Spa\Classes\DB\Database;
use Abyzs\Spa\Classes\Operations;

class OperationsTest extends TestCase
{
    /**
     * @var MockObject|Database
     */
    private MockObject $database;

    private $operations;

    protected function setUp(): void
    {
        $this->database = $this->getMockBuilder(Database::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->operations = new Operations($this->database);
    }

    public function testGetOperations(): void
    {
        $this->database->expects($this->once())
            ->method('query')
            ->willReturn([]);

        $this->assertIsArray($this->operations->getOperations(1, 10));
    }

    public function testAddOperation(): void
    {
        $this->database->expects($this->once())
            ->method('query')
            ->willReturn(1);

        $this->assertEquals(true, $this->operations->addOperation(100, 'Приход'));
    }

    public function testFailedAddOperation(): void
    {
        $this->database->expects($this->once())
            ->method('query')
            ->willThrowException(new \PDOException());

        $this->assertEquals(false, $this->operations->addOperation(100, 'Приход'));
    }

    public function testDeleteOperation()
    {
        $this->database->expects($this->once())
            ->method('query')
            ->willReturn(1);

        $this->assertTrue($this->operations->deleteOperation(1));
    }

    public function testFailedDeleteOperation()
    {
        $this->database->expects($this->once())
            ->method('query')
            ->willThrowException(new \PDOException());

        $this->assertFalse($this->operations->deleteOperation(1));
    }

    public function testSummAllPrihod()
    {
        $this->database->expects($this->once())
            ->method('query')
            ->willReturn([
                ["SUM(amount)" => 157.776666666]
            ]);

        $this->assertEquals(157.777, $this->operations->summAllPrihod());
    }

    public function testSummAllRashod()
    {
        $this->database->expects($this->once())
            ->method('query')
            ->willReturn([
                ["SUM(amount)" => 157.776666666]
            ]);

        $this->assertEquals(157.777, $this->operations->summAllRashod());
    }
}