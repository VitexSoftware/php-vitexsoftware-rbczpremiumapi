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

namespace VitexSoftware\Raiffeisenbank\RateLimit;

use VitexSoftware\Raiffeisenbank\ApiException;

/**
 * Thrown when a client's request rate has exceeded the API's or the local
 * self-tracked limit. Extends ApiException (rather than plain \Exception) so
 * that callers who already `catch (ApiException $exc)` around API calls
 * catch this too, without needing a separate catch block. Defaults to code
 * 429 (HTTP "Too Many Requests") unless the caller passes a different code.
 */
class RateLimitExceededException extends ApiException
{
    public function __construct($message = '', $code = 429, $responseHeaders = [], $responseBody = null)
    {
        parent::__construct($message, $code, $responseHeaders, $responseBody);
    }
}
