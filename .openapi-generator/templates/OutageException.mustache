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

namespace VitexSoftware\Raiffeisenbank\Outage;

use VitexSoftware\Raiffeisenbank\ApiException;

/**
 * Thrown when the RB API gateway itself reports being down, rather than
 * rejecting the individual request. Raiffeisenbank's gateway signals this by
 * returning HTTP 500 together with an `outage: yes` response header (seen on
 * every endpoint, regardless of account/certificate/client) - distinct from a
 * per-request 500 caused by bad input or a transient backend error. Extends
 * ApiException (rather than plain \Exception) so that callers who already
 * `catch (ApiException $exc)` around API calls catch this too, without
 * needing a separate catch block, while still being able to catch this
 * specifically to skip retries or surface a clearer "RB is down" message.
 */
class OutageException extends ApiException
{
    public function __construct($message = '', $code = 500, $responseHeaders = [], $responseBody = null)
    {
        parent::__construct($message, $code, $responseHeaders, $responseBody);
    }

    /**
     * Detect the RB gateway's outage signal on a raw HTTP response: HTTP 500
     * with an `outage: yes` response header (header names are matched
     * case-insensitively per PSR-7; the value is compared case-insensitively
     * too, since it has been observed simply as `yes`).
     */
    public static function isOutageResponse(\Psr\Http\Message\ResponseInterface $response): bool
    {
        return 500 === $response->getStatusCode()
            && 'yes' === mb_strtolower(trim($response->getHeaderLine('outage')));
    }
}
