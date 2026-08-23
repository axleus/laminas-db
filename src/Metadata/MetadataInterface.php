<?php

declare(strict_types=1);

namespace PhpDb\Metadata;

use PhpDb\Metadata\Object\ColumnObject;
use PhpDb\Metadata\Object\ConstraintKeyObject;
use PhpDb\Metadata\Object\ConstraintObject;
use PhpDb\Metadata\Object\TableObject;
use PhpDb\Metadata\Object\TriggerObject;
use PhpDb\Metadata\Object\ViewObject;

/**
 * @api
 *
 * @mago-expect lint:too-many-methods
 */
interface MetadataInterface
{
    public function getColumn(string $columnName, string $table, ?string $schema = null): ColumnObject;

    /**
     * @return list<string>
     */
    public function getColumnNames(string $table, ?string $schema = null): array;

    /**
     * @return list<ColumnObject>
     */
    public function getColumns(string $table, ?string $schema = null): array;

    public function getConstraint(
        string $constraintName,
        string $table,
        ?string $schema = null,
    ): ConstraintObject;

    /**
     * @return list<ConstraintKeyObject>
     */
    public function getConstraintKeys(string $constraint, string $table, ?string $schema = null): array;

    /**
     * @return list<ConstraintObject>
     */
    public function getConstraints(string $table, ?string $schema = null): array;

    /**
     * @return list<string>
     */
    public function getSchemas(): array;

    public function getTable(string $tableName, ?string $schema = null): TableObject|ViewObject;

    /**
     * @return list<string>
     *
     * @mago-expect lint:no-boolean-flag-parameter
     */
    public function getTableNames(?string $schema = null, bool $includeViews = false): array;

    /**
     * @return list<TableObject|ViewObject>
     *
     * @mago-expect lint:no-boolean-flag-parameter
     */
    public function getTables(?string $schema = null, bool $includeViews = false): array;

    public function getTrigger(string $triggerName, ?string $schema = null): TriggerObject;

    /**
     * @return list<string>
     */
    public function getTriggerNames(?string $schema = null): array;

    /**
     * @return list<TriggerObject>
     */
    public function getTriggers(?string $schema = null): array;

    public function getView(string $viewName, ?string $schema = null): ViewObject|TableObject;

    /**
     * @return list<string>
     */
    public function getViewNames(?string $schema = null): array;

    /**
     * @return list<TableObject|ViewObject>
     */
    public function getViews(?string $schema = null): array;
}
