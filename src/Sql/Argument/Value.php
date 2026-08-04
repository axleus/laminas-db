<?php

declare(strict_types=1);

namespace PhpDb\Sql\Argument;

use PhpDb\Sql\ArgumentInterface;
use PhpDb\Sql\ArgumentType;

/**
 * Represents a bound parameter value in SQL.
 * Used for values that will be sent as bound parameters to the database,
 * providing protection against SQL injection.
 */
final readonly class Value implements ArgumentInterface
{
    /**
     * @param null|string|int|float|bool $value Scalar value, or null
     */
    public function __construct(
        private string|int|float|bool|null $value,
    ) {}

    public function getSpecification(): string
    {
        return '%s';
    }

    public function getType(): ArgumentType
    {
        return ArgumentType::Value;
    }

    public function getValue(): string|int|float|bool|null
    {
        return $this->value;
    }
}
