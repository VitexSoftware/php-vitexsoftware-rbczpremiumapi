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

class RateLimiter
{
    private RateLimitStoreInterface $store;
    private bool $waitMode;

    public function __construct(RateLimitStoreInterface $store, bool $waitMode = true)
    {
        $this->store = $store;
        $this->waitMode = $waitMode;
    }
    public function isWaitMode(): bool
    {
        return $this->waitMode;
    }

    /**
     * clientId = fingerprint of the certificate (sha1, serial+issuer, etc.)
     * secondLimits/dayLimits are obtained from API response headers.
     */
    public function handleRateLimits(
        string $clientId,
        int $remainingSecond,
        int $remainingDay,
        int $timestamp,
    ): void {
        $this->store->set($clientId, 'second', $remainingSecond, $timestamp);
        $this->store->set($clientId, 'day', $remainingDay, $timestamp);
    }

    /**
     * Verification before the next request.
     */
    public function checkBeforeRequest(string $clientId): void
    {
        $now = time();

        $second = $this->store->get($clientId, 'second');
        $day = $this->store->get($clientId, 'day');

        // second window
        if ($second && $second['remaining'] <= 0) {
            $wait = max(0, 1 - ($now - $second['timestamp']));

            if ($wait > 0) {
                if ($this->waitMode) {
                    error_log(sprintf('Rate-limit (second window) exceeded. Waiting %d seconds', $wait));
                    usleep($wait * 1_000_000);
                } else {
                    throw new RateLimitExceededException('Rate-limit (second window) exceeded');
                }
            }
        }

        // day window
        if ($day && $day['remaining'] <= 0) {
            $wait = max(0, 86400 - ($now - $day['timestamp']));

            if ($wait > 0) {
                if ($this->waitMode) {
                    error_log(sprintf('Rate-limit (day window) exceeded. Waiting %d seconds', $wait));
                    sleep($wait);
                } else {
                    throw new RateLimitExceededException('Rate-limit (day window) exceeded');
                }
            }
        }
    }
}
