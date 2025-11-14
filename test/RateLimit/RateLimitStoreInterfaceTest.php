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
use VitexSoftware\Raiffeisenbank\RateLimit\RateLimitStoreInterface;

class RateLimitStoreInterfaceTest extends TestCase
{
    public function testGetReturnsArrayOrNull(): void
    {
        $mock = $this->getMockForAbstractClass(RateLimitStoreInterface::class);
        $result = $mock->get('client', 'second');
        $this->assertTrue(\is_array($result) || null === $result);
    }

    public function testSetDoesNotThrow(): void
    {
        $mock = $this->getMockForAbstractClass(RateLimitStoreInterface::class);
        $this->expectNotToPerformAssertions();
        $mock->set('client', 'second', 10, time());
    }

    public function testAllForClientReturnsArray(): void
    {
        $mock = $this->getMockForAbstractClass(RateLimitStoreInterface::class);
        $result = $mock->allForClient('client');
        $this->assertIsArray($result);
    }
}
