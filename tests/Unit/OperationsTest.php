<?php

namespace Abyzs\Spa\Unit;

use Abyzs\Spa\Classes\Operations;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class OperationsTest extends TestCase
{
    /**
     * @var MockObject|Operations
     */
    private MockObject $operations;

    protected function setUp(): void
    {
        $this->operations = $this->getMockBuilder(Operations::class)
            ->disableOriginalConstructor()
            ->getMock();
    }

    public function testGetOperations(): void
    {
        $this->operations->expects($this->any())
            ->method('getOperations')
            ->willReturn([]);

        $result = $this->operations->getOperations(1, 10);

        $this->assertIsArray($result);
    }

    public function testAddOperation(): void
    {
        $this->operations->expects($this->any())
            ->method('addOperation')
            ->willReturn('success');

        $result = $this->operations->addOperation(100, '', '');

        $this->assertEquals('success', $result);
    }

    public function testDeleteOperation(): void
    {
        $this->operations->expects($this->any())
            ->method('deleteOperation')
            ->willReturn(true);

        $result = $this->operations->deleteOperation(7);

        $this->assertTrue($result);
    }

    public function testLastInsertOperation(): void
    {
        $this->operations->expects($this->any())
            ->method('lastInsertOperation')
            ->willReturn([]);

        $result = $this->operations->lastInsertOperation();

        $this->assertIsArray($result);
    }

    public function testSummAllPrihod(): void
    {
        $this->operations->expects($this->any())
            ->method('summAllPrihod')
            ->willReturn(451.1);

        $result = $this->operations->summAllPrihod();

        $this->assertIsFloat($result);
    }

    public function testSummAllRashod(): void
    {
        $this->operations->expects($this->any())
            ->method('summAllRashod')
            ->willReturn(451.1);

        $result = $this->operations->summAllRashod();

        $this->assertIsFloat($result);
    }
}