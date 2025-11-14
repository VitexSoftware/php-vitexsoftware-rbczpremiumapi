<?php

declare(strict_types=1);

/**
 * This file is part of the MultiFlexi package
 *
 * https://github.com/VitexSoftware/php-vitexsoftware-rbczpremiumapi
 *
 * (c) Vítězslav Dvořák <http://vitexsoftware.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

use PHPUnit\Framework\TestCase;
use VitexSoftware\Raiffeisenbank\RateLimit\RateLimiter;
use VitexSoftware\Raiffeisenbank\RateLimit\RateLimitStoreInterface;

class RateLimiterTest extends TestCase
{
    public function testIsWaitModeDefaultTrue(): void
    {
        $mockStore = $this->createMock(RateLimitStoreInterface::class);
        $limiter = new RateLimiter($mockStore);
        $this->assertTrue($limiter->isWaitMode());
    }

    public function testIsWaitModeFalse(): void
    {
        $mockStore = $this->createMock(RateLimitStoreInterface::class);
        $limiter = new RateLimiter($mockStore, false);
        $this->assertFalse($limiter->isWaitMode());
    }

    public function testHandleRateLimitsCallsStoreSet(): void
    {
        $mockStore = $this->createMock(RateLimitStoreInterface::class);
        $mockStore->expects($this->exactly(2))
            ->method('set');
        $limiter = new RateLimiter($mockStore);
        $limiter->handleRateLimits('client', 1, 2, time());
    }

    public function testCheckBeforeRequestDoesNotThrow(): void
    {
        $mockStore = $this->createMock(RateLimitStoreInterface::class);
        $mockStore->method('get')->willReturn(['remaining' => 1, 'timestamp' => time()]);
        $limiter = new RateLimiter($mockStore);
        $this->expectNotToPerformAssertions();
        $limiter->checkBeforeRequest('client');
    }
}
