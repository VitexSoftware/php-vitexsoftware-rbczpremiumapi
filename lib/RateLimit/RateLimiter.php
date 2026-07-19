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
    private string $lockDir;

    /**
     * Create a RateLimiter configured with a storage backend and a handling mode for exceeded limits.
     *
     * @param RateLimitStoreInterface $store    storage backend for per-client rate-limit state
     * @param bool                    $waitMode if true, the limiter will wait until the limit window resets; if false, it will throw a RateLimitExceededException when limits are exceeded
     * @param string                  $lockDir  directory used to store per-client lock files that serialize concurrent requests (defaults to the system temp directory)
     */
    public function __construct(RateLimitStoreInterface $store, bool $waitMode = true, ?string $lockDir = null)
    {
        $this->store = $store;
        $this->waitMode = $waitMode;
        $this->lockDir = $lockDir ?? sys_get_temp_dir();
    }

    /**
     * Acquire an exclusive, cross-process lock for the given client so that concurrent
     * processes sharing the same client (e.g. the same certificate) serialize their
     * check-send-update cycle instead of racing past each other's stale counters.
     *
     * The lock is released with {@see releaseLock()}; it is also released automatically
     * by the OS if the process dies while holding it.
     *
     * @param string $clientId identifier of the client to lock (used to derive the lock file name)
     *
     * @return resource the open, locked file handle to pass to releaseLock()
     */
    public function acquireLock(string $clientId)
    {
        $safeId = preg_replace('/[^a-zA-Z0-9_.-]/', '_', $clientId);
        $handle = fopen($this->lockDir.'/rbczpremiumapi_'.$safeId.'.lock', 'c');

        if ($handle === false) {
            throw new \RuntimeException('Unable to open rate-limit lock file for client '.$clientId);
        }

        flock($handle, \LOCK_EX);

        return $handle;
    }

    /**
     * Release a lock previously acquired with {@see acquireLock()}.
     *
     * @param resource $handle the file handle returned by acquireLock()
     */
    public function releaseLock($handle): void
    {
        flock($handle, \LOCK_UN);
        fclose($handle);
    }
    /**
     * Indicates whether the limiter is configured to wait when a rate limit is exceeded.
     *
     * @return bool `true` if the limiter waits until the rate-limit window expires, `false` otherwise
     */
    public function isWaitMode(): bool
    {
        return $this->waitMode;
    }

    /**
     * Stores remaining rate-limit counts for a client for both the one-second and 24-hour windows.
     *
     * @param string $clientId        Fingerprint identifying the client (e.g., certificate SHA1, serial+issuer).
     * @param int    $remainingSecond remaining requests in the current one-second window
     * @param int    $remainingDay    remaining requests in the current 24-hour window
     * @param int    $timestamp       UNIX timestamp (seconds) when the limits were observed
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
     * Ensures the client is allowed to make the next request by enforcing per-second and per-day rate limits.
     *
     * If a window is exhausted and wait mode is enabled, pauses execution for the required seconds to clear the window;
     * otherwise throws a RateLimitExceededException.
     *
     * @param string $clientId identifier of the client whose rate limits are checked
     *
     * @throws RateLimitExceededException if a rate limit is exceeded and wait mode is disabled
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
                error_log(sprintf('Rate-limit (second window) exceeded. Waiting %d seconds', $wait));
                usleep($wait * 1_000_000);
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
