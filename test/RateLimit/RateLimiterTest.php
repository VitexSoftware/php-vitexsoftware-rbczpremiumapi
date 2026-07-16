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

    public function testAcquireLockSerializesSameClient(): void
    {
        $mockStore = $this->createMock(RateLimitStoreInterface::class);
        $lockDir = sys_get_temp_dir();
        $limiter = new RateLimiter($mockStore, false, $lockDir);

        $clientId = 'test-client-'.uniqid('', true);
        $lockFile = $lockDir.'/rbczpremiumapi_'.$clientId.'.lock';

        $handle = $limiter->acquireLock($clientId);

        try {
            $this->assertFileExists($lockFile);

            $secondHandle = fopen($lockFile, 'c');
            $this->assertFalse(
                flock($secondHandle, \LOCK_EX | \LOCK_NB),
                'A second exclusive lock for the same client must fail while the first is held',
            );
            fclose($secondHandle);
        } finally {
            $limiter->releaseLock($handle);
        }

        $thirdHandle = fopen($lockFile, 'c');
        $this->assertTrue(
            flock($thirdHandle, \LOCK_EX | \LOCK_NB),
            'The lock must become acquirable again once released',
        );
        flock($thirdHandle, \LOCK_UN);
        fclose($thirdHandle);

        @unlink($lockFile);
    }

    public function testAcquireLockSanitizesClientIdIntoFilename(): void
    {
        $mockStore = $this->createMock(RateLimitStoreInterface::class);
        $lockDir = sys_get_temp_dir();
        $limiter = new RateLimiter($mockStore, false, $lockDir);

        $clientId = '../../etc/passwd:'.uniqid('', true);
        $handle = $limiter->acquireLock($clientId);
        $limiter->releaseLock($handle);

        $matches = glob($lockDir.'/rbczpremiumapi_*etc_passwd*.lock');
        $this->assertNotEmpty($matches, 'Lock file must be created inside the configured lock directory');
        $this->assertFileDoesNotExist('/etc/passwd.lock');

        foreach ($matches as $match) {
            @unlink($match);
        }
    }
}
