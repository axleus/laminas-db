<?php

declare(strict_types=1);

namespace PhpDb\Sql;

final readonly class TableIdentifier
{
    public const SEPARATOR = '_';

    /**
     * @throws Exception\InvalidArgumentException If $table, $schema, $prefix or $separator is an empty string.
     */
    public function __construct(
        protected string $table,
        protected ?string $schema = null,
        protected ?string $prefix = null,
        protected ?string $separator = self::SEPARATOR,
    ) {
        if ('' === $table) {
            throw new Exception\InvalidArgumentException(
                '$table must be a valid table name, empty string given',
            );
        }

        if ('' === $schema) {
            throw new Exception\InvalidArgumentException(
                '$schema must be a valid schema name or null, empty string given',
            );
        }

        if ('' === $prefix) {
            throw new Exception\InvalidArgumentException(
                '$prefix must be a valid table prefix or null, empty string given',
            );
        }

        if ('' === $separator) {
            throw new Exception\InvalidArgumentException(
                '$separator must be a valid table separator, empty string given',
            );
        }
    }

    public function getPrefix(): ?string
    {
        return $this->prefix;
    }

    public function getSchema(): ?string
    {
        return $this->schema;
    }

    public function getSeparator(): string
    {
        return $this->separator ?? self::SEPARATOR;
    }

    /**
     * Returns the table name with the prefix and separator applied, when a
     * prefix is set.
     */
    public function getTable(): string
    {
        if (null === $this->prefix) {
            return $this->table;
        }

        return $this->prefix . $this->getSeparator() . $this->table;
    }

    /** @return array{0: string, 1: null|string} */
    public function getTableAndSchema(): array
    {
        return [$this->getTable(), $this->schema];
    }

    /**
     * Returns the table name as given, without the prefix applied.
     */
    public function getUnprefixedTable(): string
    {
        return $this->table;
    }
}
