<?php

namespace Abyzs\Spa\Unit;

use PHPUnit\Framework\TestCase;
use PHPUnit\Framework\MockObject\MockObject;
use Abyzs\Spa\Classes\DB\Database;
use Abyzs\Spa\Classes\Users;

class UsersTest extends TestCase
{
    /**
     * @var MockObject|Database
     */
    private MockObject $database;

    private $users;

    protected function setUp(): void
    {
        $this->database = $this->getMockBuilder(Database::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->users = new Users($this->database);
    }

    public function testAddUser(): void
    {
        $this->database->expects($this->once())
            ->method('query')
            ->willReturn(1);

        $this->assertTrue($this->users->addUser('login', 'pass', 'email@email.com'));
    }

    public function testFailedAddUser(): void
    {
        $this->database->expects($this->once())
            ->method('query')
            ->willThrowException(new \PDOException());

        $this->assertFalse($this->users->addUser('login', 'pass', 'email@email.com'));
    }

    public function testValidateUser(): void
    {
        $this->database->expects($this->once())
            ->method('query')
            ->willReturn(true);

        $this->assertTrue($this->users->validateUser('login', 'pass'));
    }

    public function testFailedValidateUser(): void
    {
        $this->database->expects($this->once())
            ->method('query')
            ->willReturn(false);

        $this->assertFalse($this->users->validateUser('login', 'pass'));
    }
}