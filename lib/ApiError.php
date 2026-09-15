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

namespace VitexSoftware\Raiffeisenbank;

use Psr\Http\Message\ResponseInterface;
use VitexSoftware\Raiffeisenbank\Model\GetBalance401Response;
use VitexSoftware\Raiffeisenbank\Model\GetBalance403Response;
use VitexSoftware\Raiffeisenbank\Model\GetBalance404Response;
use VitexSoftware\Raiffeisenbank\Model\GetBalance429Response;
use VitexSoftware\Raiffeisenbank\Model\GetStatements400Response;
use VitexSoftware\Raiffeisenbank\Model\GetTransactionList400Response;

/**
 * Turn RB Premium API error HTTP responses / deserialized error models into
 * ApiException instances whose message includes both `error` and
 * `error_description` (e.g. UNAUTHORISED / Certificate is terminated).
 */
final class ApiError
{
    /**
     * HTTP status associated with generated error-model classes.
     *
     * @var array<class-string, int>
     */
    private const MODEL_STATUS = [
        GetBalance401Response::class => 401,
        GetBalance403Response::class => 403,
        GetBalance404Response::class => 404,
        GetBalance429Response::class => 429,
        GetStatements400Response::class => 400,
        GetTransactionList400Response::class => 400,
    ];

    /**
     * Build an ApiException from a raw HTTP error response.
     */
    public static function fromHttpResponse(ResponseInterface $response): ApiException
    {
        $statusCode = $response->getStatusCode();
        $body = (string) $response->getBody();
        $decoded = self::decodeBody($body);
        $error = self::extractError($decoded);
        $description = self::extractDescription($decoded);
        $message = self::formatMessage($statusCode, $error, $description, $body);

        return new ApiException($message, $statusCode, $response->getHeaders(), $body);
    }

    /**
     * Build an ApiException from a deserialized OpenAPI error model.
     */
    public static function fromResponseModel(object $result, int $statusCode = 0): ApiException
    {
        $code = $statusCode > 0 ? $statusCode : (self::MODEL_STATUS[$result::class] ?? 0);
        $error = method_exists($result, 'getError')
            ? $result->getError()
            : (isset($result->error) && \is_string($result->error) ? $result->error : null);
        $description = method_exists($result, 'getErrorDescription')
            ? $result->getErrorDescription()
            : (isset($result->error_description) && \is_string($result->error_description) ? $result->error_description : null);
        $body = json_encode($result, \JSON_UNESCAPED_UNICODE | \JSON_UNESCAPED_SLASHES) ?: '';
        $message = self::formatMessage($code, $error, $description, $body);
        $exception = new ApiException($message, $code, [], $body);
        $exception->setResponseObject($result);

        return $exception;
    }

    /**
     * Throw unless $result is an instance of the expected success class.
     *
     * @param class-string $successClass
     *
     * @throws ApiException
     */
    public static function assertSuccess(object $result, string $successClass): void
    {
        if ($result instanceof $successClass) {
            return;
        }

        throw self::fromResponseModel($result);
    }

    /**
     * Human-readable one-line error for logs and JSON reports.
     */
    public static function formatMessage(int $statusCode, ?string $error, ?string $description, string $fallbackBody = ''): string
    {
        $error = ($error !== null && $error !== '') ? $error : null;
        $description = ($description !== null && $description !== '') ? $description : null;

        if ($error !== null && $description !== null) {
            return sprintf('Raiffeisenbank API HTTP %d %s: %s', $statusCode > 0 ? $statusCode : 0, $error, $description);
        }

        if ($description !== null) {
            return sprintf('Raiffeisenbank API HTTP %d: %s', $statusCode > 0 ? $statusCode : 0, $description);
        }

        if ($error !== null) {
            return sprintf('Raiffeisenbank API HTTP %d %s', $statusCode > 0 ? $statusCode : 0, $error);
        }

        $snippet = trim($fallbackBody);

        if ($snippet !== '') {
            return sprintf('Raiffeisenbank API HTTP %d: %s', $statusCode > 0 ? $statusCode : 0, mb_substr($snippet, 0, 500));
        }

        return sprintf('Raiffeisenbank API HTTP %d', $statusCode > 0 ? $statusCode : 0);
    }

    /**
     * @return null|array<string, mixed>|\stdClass
     */
    private static function decodeBody(string $body)
    {
        if ($body === '') {
            return null;
        }

        try {
            return json_decode($body, false, 512, \JSON_THROW_ON_ERROR);
        } catch (\JsonException) {
            return null;
        }
    }

    private static function extractError(mixed $decoded): ?string
    {
        if (\is_object($decoded) && isset($decoded->error) && \is_string($decoded->error)) {
            return $decoded->error;
        }

        if (\is_array($decoded) && isset($decoded['error']) && \is_string($decoded['error'])) {
            return $decoded['error'];
        }

        return null;
    }

    private static function extractDescription(mixed $decoded): ?string
    {
        if (!\is_object($decoded) && !\is_array($decoded)) {
            return null;
        }

        $candidates = \is_object($decoded)
            ? [$decoded->error_description ?? null, $decoded->errorDescription ?? null, $decoded->message ?? null]
            : [$decoded['error_description'] ?? null, $decoded['errorDescription'] ?? null, $decoded['message'] ?? null];

        foreach ($candidates as $candidate) {
            if (\is_string($candidate) && $candidate !== '') {
                return $candidate;
            }
        }

        return null;
    }
}
