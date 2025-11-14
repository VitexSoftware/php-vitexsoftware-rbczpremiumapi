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

    public function __construct(string $path)
    {
        $this->path = $path;

        if (!file_exists($path)) {
            file_put_contents($path, json_encode([]));
        }
    }

    abstract public function get(string $key): array;
    abstract public function increment(string $key, string $field, int $ttlSeconds): int;

    protected function read(): array
    {
        $data = file_get_contents($this->path);

        return $data ? json_decode($data, true) : [];
    }

    protected function write(array $data): void
    {
        file_put_contents($this->path, json_encode($data, \JSON_PRETTY_PRINT));
    }
}
