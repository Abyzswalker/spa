<?php

namespace DB;

use PHPUnit\Framework\TestCase;
use Abyzs\Spa\Classes\DB\Config;

class ConfigTest extends TestCase
{
    protected function setUp(): void {}
    protected function tearDown(): void {}

    public function testGet(): void
    {
        $this->assertIsArray(Config::get());
    }
}