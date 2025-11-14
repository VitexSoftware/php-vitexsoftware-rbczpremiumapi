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

interface SqlDialect
{
    /**
     * Get the current time as a Unix timestamp.
     *
     * @return int the current Unix timestamp (seconds since the Unix epoch)
     */
    public function now(): int; /**
 * Generate a SQL parameter placeholder for the given parameter name.
 *
 * @param string $name logical parameter name (without any placeholder prefix characters)
 *
 * @return string the SQL placeholder string to use in queries (for example `:name`, `?`, or `@name` depending on the dialect)
 */
    public function placeholder(string $name): string; // :name, ?, @name ...
}
