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

interface RateLimitStoreInterface
{
    /**
 * Retrieve stored rate-limit data for a client and window.
 *
 * @param string $clientId The client identifier.
 * @param string $window The rate limit window (e.g., "second" or "day").
 * @return array|null An array with keys `remaining` (int) and `timestamp` (int, Unix time) or `null` if no data is stored.
 */
    public function get(string $clientId, string $window): ?array;

    /**
 * Store rate-limit data for a client and time window.
 *
 * Stores the number of remaining requests and the associated Unix timestamp for
 * the specified client identifier and window (e.g., "second" or "day").
 *
 * @param string $clientId Identifier of the client.
 * @param string $window Time window name (for example "second" or "day").
 * @param int $remaining Number of remaining requests for the client in this window.
 * @param int $timestamp Unix timestamp representing when the stored data expires or was recorded.
 */
    public function set(string $clientId, string $window, int $remaining, int $timestamp): void;

    /**
 * Retrieve stored rate-limit data for the given client (intended for debugging).
 *
 * @param string $clientId The client identifier.
 * @return array An associative array keyed by window name (e.g., 'second', 'day') where each value is an array with keys `remaining` (int) and `timestamp` (int, Unix time). Returns an empty array if no data exists for the client.
 */
    public function allForClient(string $clientId): array;
}