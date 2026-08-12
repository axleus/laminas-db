<?php

declare(strict_types=1);

namespace PhpDb\Adapter\Driver;

use Countable;
use Iterator;
use PhpDb\Adapter\Exception;
use PhpDb\ResultSet\ResultSetInterface;

interface ResultInterface extends
    Countable,
    Iterator
{
    /**
     * Force buffering
     */
    public function buffer(): void;

    /**
     * Check if is buffered
     */
    public function isBuffered(): ?bool;

    /**
     * Is query result?
     */
    public function isQueryResult(): bool;

    /**
     * Get the seeded query result set, cloned from $resultPrototype (or a
     * default prototype if none is given) and initialized from this result.
     *
     * @throws Exception\RuntimeException When isQueryResult() is false.
     */
    public function getQueryResult(?ResultSetInterface $resultPrototype = null): ResultSetInterface;

    /**
     * Get affected rows
     */
    public function getAffectedRows(): int;

    /**
     * Get generated value
     */
    public function getGeneratedValue(): string|int|false|null;

    /**
     * Get the resource
     */
    public function getResource(): mixed;

    /**
     * Get field count
     */
    public function getFieldCount(): int;
}
