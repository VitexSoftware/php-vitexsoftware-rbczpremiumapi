<?php

use PHPUnit\Framework\TestCase;
use VitexSoftware\Raiffeisenbank\RateLimit\RateLimitStoreInterface;

class RateLimitStoreInterfaceTest extends TestCase
{
    public function testGetReturnsArrayOrNull()
    {
        $mock = $this->getMockForAbstractClass(RateLimitStoreInterface::class);
        $result = $mock->get('client', 'second');
        $this->assertTrue(is_array($result) || is_null($result));
    }

    public function testSetDoesNotThrow()
    {
        $mock = $this->getMockForAbstractClass(RateLimitStoreInterface::class);
        $this->expectNotToPerformAssertions();
        $mock->set('client', 'second', 10, time());
    }

    public function testAllForClientReturnsArray()
    {
        $mock = $this->getMockForAbstractClass(RateLimitStoreInterface::class);
        $result = $mock->allForClient('client');
        $this->assertIsArray($result);
    }
}
