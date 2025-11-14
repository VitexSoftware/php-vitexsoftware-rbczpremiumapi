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

    public function __construct(\PDO $pdo)
    {
        $this->pdo = $pdo;
        $this->init();
    }

    public function get(string $clientId, string $window): ?array
    {
        $stmt = $this->pdo->prepare(<<<'EOD'

            SELECT remaining, timestamp
            FROM rate_limits
            WHERE client_id = ? AND window = ?

EOD);
        $stmt->execute([$clientId, $window]);
        $row = $stmt->fetch(\PDO::FETCH_ASSOC);

        return $row ?: null;
    }

    public function set(string $clientId, string $window, int $remaining, int $timestamp): void
    {
        $stmt = $this->pdo->prepare(<<<'EOD'

            REPLACE INTO rate_limits (client_id, window, remaining, timestamp)
            VALUES (?, ?, ?, ?)

EOD);
        $stmt->execute([$clientId, $window, $remaining, $timestamp]);
    }

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
