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
use VitexSoftware\Raiffeisenbank\ApiException;
use VitexSoftware\Raiffeisenbank\RateLimit\RateLimitExceededException;

class RateLimitExceededExceptionTest extends TestCase
{
    public function testExtendsApiException(): void
    {
        $exc = new RateLimitExceededException('Rate limit exceeded');
        $this->assertInstanceOf(ApiException::class, $exc);
    }

    public function testDefaultsCodeTo429(): void
    {
        $exc = new RateLimitExceededException('Rate limit exceeded');
        $this->assertSame(429, $exc->getCode());
    }

    public function testCodeCanBeOverridden(): void
    {
        $exc = new RateLimitExceededException('Custom', 123);
        $this->assertSame(123, $exc->getCode());
    }
}
