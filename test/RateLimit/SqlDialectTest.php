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
use VitexSoftware\Raiffeisenbank\RateLimit\SqlDialect;

class SqlDialectTest extends TestCase
{
    public function testNowReturnsInt(): void
    {
        $mock = $this->createMock(SqlDialect::class);
        $mock->method('now')->willReturn(time());
        $this->assertIsInt($mock->now());
    }

    public function testPlaceholderReturnsString(): void
    {
        $mock = $this->createMock(SqlDialect::class);
        $mock->method('placeholder')->willReturn(':test');
        $this->assertIsString($mock->placeholder('test'));
    }
}
