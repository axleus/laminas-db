<?php

declare(strict_types=1);

namespace PhpDb\Sql;

/**
 * Callable factory producing {@see TableIdentifier} instances with a
 * preconfigured table prefix and separator.
 *
 * Register via {@see \PhpDb\ConfigProvider} and configure the prefix once
 * (e.g. in application config) to have every identifier created through the
 * factory share the same prefix — convenient for creating backup_* tables
 * during a migration.
 */
final class TableIdentifierFactory
{
    private readonly ?string $prefix;

    public function __construct(
        ?string $prefix = null,
        private readonly string $separator = '_',
    ) {
        if ('' === $prefix) {
            throw new Exception\InvalidArgumentException(
                '$prefix must be a valid table prefix or null, empty string given'
            );
        }

        $this->prefix = $prefix;
    }

    public function getPrefix(): ?string
    {
        return $this->prefix;
    }

    public function getSeparator(): string
    {
        return $this->separator;
    }

    /**
     * Creates a TableIdentifier carrying the configured prefix and separator.
     *
     * A prefix or separator passed at call time takes precedence over the
     * configured one.
     */
    public function __invoke(
        string $table,
        ?string $schema = null,
        ?string $prefix = null,
        ?string $separator = null,
    ): TableIdentifier {
        return new TableIdentifier($table, $schema, $prefix ?? $this->prefix, $separator ?? $this->separator);
    }
}
