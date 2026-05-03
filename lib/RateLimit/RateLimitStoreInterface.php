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
     * Returns stored data for the given client identifier and window (second/day).
     * Array:
     *   remaining => int
     *   timestamp => int (unix time when the value was received).
     */
    public function get(string $clientId, string $window): ?array;

    /**
     * Stores data for the client and window (second/day).
     */
    public function set(string $clientId, string $window, int $remaining, int $timestamp): void;

    /**
     * Returns all data for one client (for debugging).
     */
    public function allForClient(string $clientId): array;
}
