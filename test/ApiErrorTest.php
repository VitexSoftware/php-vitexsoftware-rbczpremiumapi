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
use VitexSoftware\Raiffeisenbank\ApiError;
use VitexSoftware\Raiffeisenbank\ApiException;
use VitexSoftware\Raiffeisenbank\Model\GetBalance401Response;
use VitexSoftware\Raiffeisenbank\Model\GetStatements200Response;

class ApiErrorTest extends TestCase
{
    public function testFormatMessageIncludesErrorAndDescription(): void
    {
        $message = ApiError::formatMessage(401, 'UNAUTHORISED', 'Certificate is terminated');

        $this->assertSame('Raiffeisenbank API HTTP 401 UNAUTHORISED: Certificate is terminated', $message);
    }

    public function testFromHttpResponseParsesTerminatedCertificateBody(): void
    {
        $response = new Response(
            401,
            ['Content-Type' => 'application/json'],
            '{"error":"UNAUTHORISED","error_description":"Certificate is terminated"}',
        );

        $exception = ApiError::fromHttpResponse($response);

        $this->assertInstanceOf(ApiException::class, $exception);
        $this->assertSame(401, $exception->getCode());
        $this->assertSame('Raiffeisenbank API HTTP 401 UNAUTHORISED: Certificate is terminated', $exception->getMessage());
        $this->assertStringContainsString('Certificate is terminated', (string) $exception->getResponseBody());
    }

    public function testFromResponseModelUses401Model(): void
    {
        $model = new GetBalance401Response([
            'error' => 'UNAUTHORISED',
            'errorDescription' => 'Certificate is terminated',
        ]);

        $exception = ApiError::fromResponseModel($model);

        $this->assertSame(401, $exception->getCode());
        $this->assertSame('Raiffeisenbank API HTTP 401 UNAUTHORISED: Certificate is terminated', $exception->getMessage());
        $this->assertSame($model, $exception->getResponseObject());
    }

    public function testAssertSuccessPasses200Model(): void
    {
        $this->expectNotToPerformAssertions();
        ApiError::assertSuccess(new GetStatements200Response(), GetStatements200Response::class);
    }

    public function testAssertSuccessThrowsOn401Model(): void
    {
        $model = new GetBalance401Response([
            'error' => 'UNAUTHORISED',
            'errorDescription' => 'Certificate is terminated',
        ]);

        $this->expectException(ApiException::class);
        $this->expectExceptionCode(401);
        $this->expectExceptionMessage('Certificate is terminated');
        ApiError::assertSuccess($model, GetStatements200Response::class);
    }

    public function testApiClientSendThrowsReadableExceptionOn401(): void
    {
        $mock = new MockHandler([
            new Response(
                401,
                [
                    'x-ratelimit-remaining-second' => '9',
                    'x-ratelimit-remaining-day' => '4851',
                    'Content-Type' => 'application/json',
                ],
                '{"error":"UNAUTHORISED","error_description":"Certificate is terminated"}',
            ),
        ]);
        $client = new ApiClient([
            'cert' => [\dirname(__DIR__).'/examples/test_cert_ssl3.p12', 'test12345678'],
            'clientid' => 'test-client-id',
            'handler' => HandlerStack::create($mock),
            'rate_limit_wait' => false,
            'rate_limit_path' => sys_get_temp_dir().'/apierrortest_rates_'.uniqid('', true).'.json',
            'rate_limit_lock_dir' => sys_get_temp_dir(),
        ]);

        try {
            $client->send(new Request('POST', 'https://api.rb.cz/rbcz/premium/api/accounts/statements'));
            $this->fail('Expected ApiException was not thrown');
        } catch (ApiException $exception) {
            $this->assertSame(401, $exception->getCode());
            $this->assertSame('Raiffeisenbank API HTTP 401 UNAUTHORISED: Certificate is terminated', $exception->getMessage());
        }
    }
}
