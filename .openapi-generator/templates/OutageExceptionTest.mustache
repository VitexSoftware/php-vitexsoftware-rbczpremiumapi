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

use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\TestCase;
use VitexSoftware\Raiffeisenbank\ApiException;
use VitexSoftware\Raiffeisenbank\Outage\OutageException;

class OutageExceptionTest extends TestCase
{
    public function testExtendsApiException(): void
    {
        $exc = new OutageException('RB gateway outage');
        $this->assertInstanceOf(ApiException::class, $exc);
    }

    public function testDefaultsCodeTo500(): void
    {
        $exc = new OutageException('RB gateway outage');
        $this->assertSame(500, $exc->getCode());
    }

    public function testCodeCanBeOverridden(): void
    {
        $exc = new OutageException('Custom', 123);
        $this->assertSame(123, $exc->getCode());
    }

    public function testIsOutageResponseTrueForStatus500WithOutageHeader(): void
    {
        $response = new Response(500, ['outage' => 'yes']);
        $this->assertTrue(OutageException::isOutageResponse($response));
    }

    public function testIsOutageResponseIsCaseInsensitiveOnHeaderValue(): void
    {
        $response = new Response(500, ['outage' => 'YES']);
        $this->assertTrue(OutageException::isOutageResponse($response));
    }

    public function testIsOutageResponseFalseForStatus500WithoutOutageHeader(): void
    {
        $response = new Response(500);
        $this->assertFalse(OutageException::isOutageResponse($response));
    }

    public function testIsOutageResponseFalseForOtherStatusWithOutageHeader(): void
    {
        $response = new Response(503, ['outage' => 'yes']);
        $this->assertFalse(OutageException::isOutageResponse($response));
    }

    public function testIsOutageResponseFalseForOutageHeaderNo(): void
    {
        $response = new Response(500, ['outage' => 'no']);
        $this->assertFalse(OutageException::isOutageResponse($response));
    }
}
