<?php

declare(strict_types=1);

namespace PhpDb\Sql;

class TableIdentifier
{
    public const SEPARATOR = '_';

    protected string $table;

    protected ?string $schema = null;

    protected ?string $prefix = null;

    protected string $separator = self::SEPARATOR;

    /**
     * @throws Exception\InvalidArgumentException If $table, $schema, $prefix or $separator is an empty string.
     */
    public function __construct(
        string $table,
        ?string $schema = null,
        ?string $prefix = null,
        string $separator = '_',
    ) {
        if ('' === $table) {
            throw new Exception\InvalidArgumentException(
                '$table must be a valid table name, empty string given'
            );
        }

        $this->table = $table;

        if ($schema !== null) {
            if ('' === $schema) {
                throw new Exception\InvalidArgumentException(
                    '$schema must be a valid schema name or null, empty string given'
                );
            }

            $this->schema = $schema;
        }

        if ($prefix !== null) {
            if ('' === $prefix) {
                throw new Exception\InvalidArgumentException(
                    '$prefix must be a valid table prefix or null, empty string given'
                );
            }

            $this->prefix = $prefix;
        }

        if ('' === $separator) {
            throw new Exception\InvalidArgumentException(
                '$separator must be a valid table separator, empty string given'
            );
        }

        $this->separator = $separator;
    }

    /**
     * Returns the table name with the prefix and separator applied, when a
     * prefix is set.
     */
    public function getTable(): string
    {
        if ($this->prefix === null) {
            return $this->table;
        }

        return $this->prefix . $this->separator . $this->table;
    }

    /**
     * Returns the table name as given, without the prefix applied.
     */
    public function getUnprefixedTable(): string
    {
        return $this->table;
    }

    public function getPrefix(): ?string
    {
        return $this->prefix;
    }

    public function getSeparator(): string
    {
        return $this->separator;
    }

    public function getSchema(): ?string
    {
        return $this->schema;
    }

    /** @return array{0: string, 1: null|string} */
    public function getTableAndSchema(): array
    {
        return [$this->getTable(), $this->schema];
    }
}
