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

abstract class RateLimitStore
{
    protected string $path;

    /**
     * Initialize the store with the backing file path and ensure the file exists.
     *
     * If the file at the provided path does not exist, creates it containing an empty JSON array.
     *
     * @param string $path Filesystem path to the JSON file used to persist rate-limit data.
     */
    public function __construct(string $path)
    {
        $this->path = $path;

        if (!file_exists($path)) {
            file_put_contents($path, json_encode([]));
        }
    }

    /**
 * Retrieve stored rate-limit entries for the specified key.
 *
 * @param string $key The identifier of the rate-limit bucket or resource.
 * @return array An array of rate-limit records for the key, or an empty array if none exist.
 */
abstract public function get(string $key): array;
    /**
 * Increment the numeric counter for a rate-limited key and field, applying a time-to-live.
 *
 * @param string $key The identifier for the rate-limited entity.
 * @param string $field The specific counter field to increment.
 * @param int $ttlSeconds Time to live for the counter in seconds.
 * @return int The counter value after the increment.
 */
abstract public function increment(string $key, string $field, int $ttlSeconds): int;

    /**
     * Read and decode the JSON contents of the store file.
     *
     * Decodes the file contents as an associative array; returns an empty array if the file is empty.
     *
     * @return array The decoded data as an associative array, or an empty array when the file has no content.
     */
    protected function read(): array
    {
        $data = file_get_contents($this->path);

        return $data ? json_decode($data, true) : [];
    }

    /**
     * Writes the provided data to the storage file as pretty-printed JSON.
     *
     * Encodes `$data` to JSON using `JSON_PRETTY_PRINT` and overwrites the file at `$this->path`.
     *
     * @param array $data The data to encode and store.
     */
    protected function write(array $data): void
    {
        file_put_contents($this->path, json_encode($data, \JSON_PRETTY_PRINT));
    }
}