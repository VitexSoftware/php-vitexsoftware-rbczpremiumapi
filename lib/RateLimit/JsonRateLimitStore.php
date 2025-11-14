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

    public function __construct(string $filename)
    {
        $this->filename = $filename;

        if (file_exists($filename)) {
            $json = file_get_contents($filename);
            $this->data = json_decode($json, true) ?? [];
        }
    }

    public function get(string $clientId, string $window): ?array
    {
        return $this->data[$clientId][$window] ?? null;
    }

    public function set(string $clientId, string $window, int $remaining, int $timestamp): void
    {
        $this->data[$clientId][$window] = [
            'remaining' => $remaining,
            'timestamp' => $timestamp,
        ];

        $this->save();
    }

    public function allForClient(string $clientId): array
    {
        return $this->data[$clientId] ?? [];
    }

    private function save(): void
    {
        file_put_contents($this->filename, json_encode($this->data, \JSON_PRETTY_PRINT));
    }
}
