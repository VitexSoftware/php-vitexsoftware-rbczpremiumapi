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

class PdoRateLimitStore implements RateLimitStoreInterface
{
    private \PDO $pdo;

    /**
     * Store the PDO connection and ensure the rate_limits table exists.
     *
     * Initializes the store by saving the provided PDO instance and creating the
     * `rate_limits` table if it does not already exist.
     */
    public function __construct(\PDO $pdo)
    {
        $this->pdo = $pdo;
        $this->init();
    }

    /**
     * Fetches the remaining token count and expiry timestamp for a client's rate-limit window.
     *
     * @param string $clientId identifier of the client
     * @param string $window   identifier of the rate-limit window
     *
     * @return null|array{remaining:int, timestamp:int} the row for the specified client and window with integer `remaining` and `timestamp`, or `null` if no record exists
     */
    public function get(string $clientId, string $window): ?array
    {
        $stmt = $this->pdo->prepare(<<<'EOD'

            SELECT remaining, timestamp
            FROM rate_limits
            WHERE client_id = ? AND window = ?

EOD);
        $stmt->execute([$clientId, $window]);
        $row = $stmt->fetch(\PDO::FETCH_ASSOC);

        if (!$row) {
            return null;
        }
        
        return [
            'remaining' => (int) $row['remaining'],
            'timestamp' => (int) $row['timestamp'],
        ];
    }
    }

    /**
     * Store or update the rate-limit record for a client and window.
     *
     * @param string $clientId  identifier of the client
     * @param string $window    Identifier of the rate-limit window (e.g., "1m", "hourly").
     * @param int    $remaining number of remaining allowed requests for the window
     * @param int    $timestamp UNIX timestamp associated with the record (seconds since epoch)
     */
    public function set(string $clientId, string $window, int $remaining, int $timestamp): void
    {
        $stmt = $this->pdo->prepare(<<<'EOD'

            REPLACE INTO rate_limits (client_id, window, remaining, timestamp)
            VALUES (?, ?, ?, ?)

EOD);
        $stmt->execute([$clientId, $window, $remaining, $timestamp]);
    }

    /**
     * Fetches all rate-limit entries for a client, indexed by window.
     *
     * @param string $clientId the client identifier
     *
     * @return array<string, array{remaining:int, timestamp:int}> associative array keyed by window name; each value contains `remaining` (int) and `timestamp` (int)
     */
    public function allForClient(string $clientId): array
    {
        $stmt = $this->pdo->prepare(<<<'EOD'

            SELECT window, remaining, timestamp
            FROM rate_limits
            WHERE client_id = ?

EOD);
        $stmt->execute([$clientId]);

        $results = [];

        while ($row = $stmt->fetch(\PDO::FETCH_ASSOC)) {
            $results[$row['window']] = [
                'remaining' => (int) $row['remaining'],
                'timestamp' => (int) $row['timestamp'],
            ];
        }

        return $results;
    }

    /**
     * Ensure the `rate_limits` table exists in the connected PDO database.
     *
     * Creates a table with columns: `client_id` (TEXT), `window` (TEXT), `remaining` (INTEGER),
     * `timestamp` (INTEGER) and a composite primary key on (`client_id`, `window`).
     */
    private function init(): void
    {
        $this->pdo->exec(<<<'EOD'

            CREATE TABLE IF NOT EXISTS rate_limits (
                client_id TEXT NOT NULL,
                window TEXT NOT NULL,
                remaining INTEGER NOT NULL,
                timestamp INTEGER NOT NULL,
                PRIMARY KEY (client_id, window)
            )

EOD);
    }
}
