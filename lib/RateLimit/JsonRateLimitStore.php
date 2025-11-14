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
     * @param string $filename path to the JSON file used to persist rate limit data
     */
    public function __construct(string $filename)
    {
        $this->filename = $filename;

        if (file_exists($filename)) {
            $this->load();
        }
    }

    /**
     * Retrieve the stored rate-limit entry for a client and window.
     *
     * @param string $clientId the client identifier
     * @param string $window   the rate-limit window identifier
     *
     * @return null|array{remaining:int, timestamp:int} the entry for the specified client and window: an array with keys `remaining` and `timestamp`, or `null` if not found
     */
    public function get(string $clientId, string $window): ?array
    {
        return $this->data[$clientId][$window] ?? null;
    }

    /**
     * Store the remaining quota and associated timestamp for a client's rate-limit window and persist it to the configured JSON file.
     *
     * @param string $clientId  identifier of the client
     * @param string $window    identifier of the rate-limit window
     * @param int    $remaining number of remaining requests for the specified window
     * @param int    $timestamp unix timestamp associated with the stored entry
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
     * @param string $clientId the client identifier
     *
     * @return array an associative array of windows to entries where each entry contains keys `remaining` (int) and `timestamp` (int); returns an empty array if the client has no entries
     */
    public function allForClient(string $clientId): array
    {
        return $this->data[$clientId] ?? [];
    }

    private function load(): void
    {
        $handle = fopen($this->filename, 'c+b');

        if ($handle && flock($handle, \LOCK_SH)) {
            $json = stream_get_contents($handle);

            if ($json === false) {
                error_log("Failed to read rate limit store from {$filename}");

                return;
            }

            $decoded = json_decode($json, true);

            if ($decoded === null && json_last_error() !== \JSON_ERROR_NONE) {
                error_log('Failed to decode rate limit JSON: '.json_last_error_msg());
                $this->data = [];
            } else {
                $this->data = $decoded ?? [];
            }

            flock($handle, \LOCK_UN);
        }

        if ($handle) {
            fclose($handle);
        }
    }

    /**
     * Persist the in-memory rate limit data to the configured JSON file.
     *
     * Writes the current $data as pretty-printed JSON into $this->filename.
     */
    private function save(): void
    {
        $handle = fopen($this->filename, 'cb');

        if ($handle && flock($handle, \LOCK_EX)) {
            ftruncate($handle, 0);
            rewind($handle);
            fwrite($handle, json_encode($this->data, \JSON_PRETTY_PRINT));
            fflush($handle);
            flock($handle, \LOCK_UN);
        }

        if ($handle) {
            fclose($handle);
        }
    }
}
