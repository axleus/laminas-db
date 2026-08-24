<?php

declare(strict_types=1);

namespace PhpDb\ResultSet;

use Countable;
use Iterator;

interface ResultSetInterface extends Iterator, Countable
{
    /**
     * Field terminology is more correct as information coming back
     * from the database might be a column, and/or the result of an
     * operation or intersection of some data
     */
    public function getFieldCount(): int;

    /**
     * Can be anything iterable|array
     */
    public function initialize(iterable $dataSource): ResultSetInterface;

    /**
     * Get all rows as an array
     */
    public function toArray(): array;
}
