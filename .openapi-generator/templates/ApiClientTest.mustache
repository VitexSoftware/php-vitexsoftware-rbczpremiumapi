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

namespace VitexSoftware\Raiffeisenbank\Test;

use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\TestCase;
use VitexSoftware\Raiffeisenbank\ApiClient;
use VitexSoftware\Raiffeisenbank\RateLimit\RateLimitExceededException;

class ApiClientTest extends TestCase
{
    private function makeClient(HandlerStack $stack, bool $waitMode): ApiClient
    {
        return new ApiClient([
            'cert' => [\dirname(__DIR__).'/examples/test_cert_ssl3.p12', 'test12345678'],
            'clientid' => 'test-client-id',
            'handler' => $stack,
            'rate_limit_wait' => $waitMode,
            'rate_limit_path' => sys_get_temp_dir().'/apiclienttest_rates_'.uniqid('', true).'.json',
            'rate_limit_lock_dir' => sys_get_temp_dir(),
        ]);
    }

    /**
     * Guzzle's default http_errors behavior throws a ClientException for a 429
     * response before send() gets a chance to inspect the status code. This must
     * be recovered internally and translated into RateLimitExceededException
     * instead of leaking the raw Guzzle exception.
     */
    public function testWaitModeDisabledThrowsRateLimitExceededExceptionOn429(): void
    {
        $mock = new MockHandler([
            new Response(429, ['x-ratelimit-remaining-second' => '0', 'x-ratelimit-remaining-day' => '100'], json_encode(['message' => 'API rate limit exceeded'])),
        ]);
        $client = $this->makeClient(HandlerStack::create($mock), false);

        $this->expectException(RateLimitExceededException::class);
        $client->send(new Request('POST', 'https://api.rb.cz/rbcz/premium/api/accounts/statements/download'));
    }

    /**
     * In wait mode, a 429 must be retried once (after the rate limiter's wait)
     * and the successful retry response returned to the caller.
     */
    public function testWaitModeRetriesAfter429AndReturnsSuccessfulResponse(): void
    {
        $mock = new MockHandler([
            new Response(429, ['x-ratelimit-remaining-second' => '0', 'x-ratelimit-remaining-day' => '100'], json_encode(['message' => 'API rate limit exceeded'])),
            new Response(200, ['x-ratelimit-remaining-second' => '9', 'x-ratelimit-remaining-day' => '99'], 'ok'),
        ]);
        $client = $this->makeClient(HandlerStack::create($mock), true);

        $response = $client->send(new Request('POST', 'https://api.rb.cz/rbcz/premium/api/accounts/statements/download'));

        $this->assertSame(200, $response->getStatusCode());
        $this->assertSame('ok', (string) $response->getBody());
    }

    /**
     * A connection-level failure (no HTTP response at all) must still propagate,
     * since there is nothing to recover a status code or rate-limit headers from.
     */
    public function testConnectExceptionWithoutResponseIsRethrown(): void
    {
        $mock = new MockHandler([
            new \GuzzleHttp\Exception\ConnectException(
                'Connection refused',
                new Request('POST', 'https://api.rb.cz/rbcz/premium/api/accounts/statements/download'),
            ),
        ]);
        $client = $this->makeClient(HandlerStack::create($mock), false);

        $this->expectException(\GuzzleHttp\Exception\ConnectException::class);
        $client->send(new Request('POST', 'https://api.rb.cz/rbcz/premium/api/accounts/statements/download'));
    }
}
