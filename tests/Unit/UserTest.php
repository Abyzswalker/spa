<?php

namespace Abyzs\Spa\Unit;

use Abyzs\Spa\Classes\Users;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class UserTest extends TestCase
{
    /**
     * @var MockObject|Users
     */
    private MockObject $users;

    protected function setUp(): void
    {
        $this->users = $this->getMockBuilder(Users::class)
            ->disableOriginalConstructor()
            ->getMock();
    }

    public function testAddUser(): void
    {
        $this->users->expects($this->any())
            ->method('addUser')
            ->willReturn('signUp');

        $result = $this->users->addUser('login', 123, 'email@gmail.com');

        $this->assertEquals('signUp', $result);
    }

    public function testCheckUserLogin(): void
    {
        $this->users->expects($this->any())
            ->method('checkUserLogin')
            ->willReturn(['login' => 'admin']);

        $result = $this->users->checkUserLogin('admin');

        $this->assertEquals('admin', $result['login']);
    }

    public function testValidateUser(): void
    {
        $this->users->expects($this->any())
            ->method('validateUser')
            ->willReturn('signIn');

        $result = $this->users->validateUser('admin', 123456);

        $this->assertEquals('signIn', $result);
    }
}