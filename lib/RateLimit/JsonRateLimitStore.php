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

class JsonRateLimitStore implements RateLimitStoreInterface
{
    private string $filename;
    private array $data = [];

    /**
     * Create a JsonRateLimitStore backed by the given file and load any existing data.
     *
     * If the file exists, its JSON contents are decoded into the in-memory store; decoding failures result in an empty dataset.
     *
     * @param string $filename Path to the JSON file used to persist rate limit data.
     */
    public function __construct(string $filename)
    {
        $this->filename = $filename;

        if (file_exists($filename)) {
            $json = file_get_contents($filename);
            $this->data = json_decode($json, true) ?? [];
        }
    }

    /**
     * Retrieve the stored rate-limit entry for a client and window.
     *
     * @param string $clientId The client identifier.
     * @param string $window The rate-limit window identifier.
     * @return array{remaining:int,timestamp:int}|null The entry for the specified client and window: an array with keys `remaining` and `timestamp`, or `null` if not found.
     */
    public function get(string $clientId, string $window): ?array
    {
        return $this->data[$clientId][$window] ?? null;
    }

    /**
     * Store the remaining quota and associated timestamp for a client's rate-limit window and persist it to the configured JSON file.
     *
     * @param string $clientId Identifier of the client.
     * @param string $window Identifier of the rate-limit window.
     * @param int $remaining Number of remaining requests for the specified window.
     * @param int $timestamp Unix timestamp associated with the stored entry.
     */
    public function set(string $clientId, string $window, int $remaining, int $timestamp): void
    {
        $this->data[$clientId][$window] = [
            'remaining' => $remaining,
            'timestamp' => $timestamp,
        ];

        $this->save();
    }

    /**
     * Retrieve all rate-limit window entries for a client.
     *
     * @param string $clientId The client identifier.
     * @return array An associative array of windows to entries where each entry contains keys `remaining` (int) and `timestamp` (int); returns an empty array if the client has no entries.
     */
    public function allForClient(string $clientId): array
    {
        return $this->data[$clientId] ?? [];
    }

    /**
     * Persist the in-memory rate limit data to the configured JSON file.
     *
     * Writes the current $data as pretty-printed JSON into $this->filename.
     */
    private function save(): void
    {
        file_put_contents($this->filename, json_encode($this->data, \JSON_PRETTY_PRINT));
    }
}