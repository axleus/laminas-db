<?php

declare(strict_types=1);

namespace PhpDb\Sql;

class TableIdentifier
{
    protected string $table;

    protected ?string $schema = null;

    public function __construct(string $table, ?string $schema = null)
    {
        if ('' === $table) {
            throw new Exception\InvalidArgumentException(
                '$table must be a valid table name, empty string given',
            );
        }

        $this->table = $table;

        if (null !== $schema) {
            if ('' === $schema) {
                throw new Exception\InvalidArgumentException(
                    '$schema must be a valid schema name or null, empty string given',
                );
            }

            $this->schema = $schema;
        }
    }

    public function getSchema(): ?string
    {
        return $this->schema;
    }

    public function getTable(): string
    {
        return $this->table;
    }

    /** @return array{0: string, 1: null|string} */
    public function getTableAndSchema(): array
    {
        return [$this->table, $this->schema];
    }
}
