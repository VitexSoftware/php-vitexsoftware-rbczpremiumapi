<?php

use PHPUnit\Framework\TestCase;
use VitexSoftware\Raiffeisenbank\RateLimit\RateLimiter;
use VitexSoftware\Raiffeisenbank\RateLimit\RateLimitStoreInterface;

class RateLimiterTest extends TestCase
{
    public function testIsWaitModeDefaultTrue()
    {
        $mockStore = $this->createMock(RateLimitStoreInterface::class);
        $limiter = new RateLimiter($mockStore);
        $this->assertTrue($limiter->isWaitMode());
    }

    public function testIsWaitModeFalse()
    {
        $mockStore = $this->createMock(RateLimitStoreInterface::class);
        $limiter = new RateLimiter($mockStore, false);
        $this->assertFalse($limiter->isWaitMode());
    }

    public function testHandleRateLimitsCallsStoreSet()
    {
        $mockStore = $this->createMock(RateLimitStoreInterface::class);
        $mockStore->expects($this->exactly(2))
            ->method('set');
        $limiter = new RateLimiter($mockStore);
        $limiter->handleRateLimits('client', 1, 2, time());
    }

    public function testCheckBeforeRequestDoesNotThrow()
    {
        $mockStore = $this->createMock(RateLimitStoreInterface::class);
        $mockStore->method('get')->willReturn(['remaining' => 1, 'timestamp' => time()]);
        $limiter = new RateLimiter($mockStore);
        $this->expectNotToPerformAssertions();
        $limiter->checkBeforeRequest('client');
    }
}
