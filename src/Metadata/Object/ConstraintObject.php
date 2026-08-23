<?php

declare(strict_types=1);

namespace PhpDb\Metadata\Object;

final class ConstraintObject
{
    /**
     * One of "PRIMARY KEY", "UNIQUE", "FOREIGN KEY", or "CHECK"
     */
    private ?string $type = null;

    /** @var string[] */
    private array $columns = [];

    private ?string $referencedTableSchema = null;

    private ?string $referencedTableName = null;

    /** @var string[]|null */
    private ?array $referencedColumns = null;

    private ?string $matchOption = null;

    private ?string $updateRule = null;

    private ?string $deleteRule = null;

    private ?string $checkClause = null;

    /**
     * Constructor
     */
    public function __construct(
        private string $name,
        private string $tableName,
        private ?string $schemaName = null,
    ) {}

    /**
     * Get Check Clause.
     */
    public function getCheckClause(): ?string
    {
        return $this->checkClause;
    }

    /**
     * Get Columns.
     *
     * @return string[]
     */
    public function getColumns(): array
    {
        return $this->columns;
    }

    /**
     * Get Delete Rule.
     */
    public function getDeleteRule(): ?string
    {
        return $this->deleteRule;
    }

    /**
     * Get Match Option.
     */
    public function getMatchOption(): ?string
    {
        return $this->matchOption;
    }

    /**
     * Get name
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * Get Referenced Columns.
     *
     * @return string[]|null
     */
    public function getReferencedColumns(): ?array
    {
        return $this->referencedColumns;
    }

    /**
     * Get Referenced Table Name.
     */
    public function getReferencedTableName(): ?string
    {
        return $this->referencedTableName;
    }

    /**
     * Get Referenced Table Schema.
     */
    public function getReferencedTableSchema(): ?string
    {
        return $this->referencedTableSchema;
    }

    /**
     * Get schema name
     */
    public function getSchemaName(): ?string
    {
        return $this->schemaName;
    }

    /**
     * Get table name
     */
    public function getTableName(): string
    {
        return $this->tableName;
    }

    /**
     * Get type
     */
    public function getType(): ?string
    {
        return $this->type;
    }

    /**
     * Get Update Rule.
     */
    public function getUpdateRule(): ?string
    {
        return $this->updateRule;
    }

    public function hasColumns(): bool
    {
        return [] !== $this->columns;
    }

    /**
     * Is foreign key
     */
    public function isCheck(): bool
    {
        return 'CHECK' === $this->type;
    }

    /**
     * Is foreign key
     */
    public function isForeignKey(): bool
    {
        return 'FOREIGN KEY' === $this->type;
    }

    /**
     * Is primary key
     */
    public function isPrimaryKey(): bool
    {
        return 'PRIMARY KEY' === $this->type;
    }

    /**
     * Is unique key
     */
    public function isUnique(): bool
    {
        return 'UNIQUE' === $this->type;
    }

    /**
     * Set Check Clause.
     */
    public function setCheckClause(string $checkClause): static
    {
        $this->checkClause = $checkClause;
        return $this;
    }

    /**
     * Set Columns.
     *
     * @param string[] $columns
     */
    public function setColumns(array $columns): static
    {
        $this->columns = $columns;
        return $this;
    }

    /**
     * Set Delete Rule.
     */
    public function setDeleteRule(string $deleteRule): static
    {
        $this->deleteRule = $deleteRule;
        return $this;
    }

    /**
     * Set Match Option.
     */
    public function setMatchOption(string $matchOption): static
    {
        $this->matchOption = $matchOption;
        return $this;
    }

    /**
     * Set name
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }

    /**
     * Set Referenced Columns.
     *
     * @param string[] $referencedColumns
     */
    public function setReferencedColumns(array $referencedColumns): static
    {
        $this->referencedColumns = $referencedColumns;
        return $this;
    }

    /**
     * Set Referenced Table Name.
     */
    public function setReferencedTableName(string $referencedTableName): static
    {
        $this->referencedTableName = $referencedTableName;
        return $this;
    }

    /**
     * Set Referenced Table Schema.
     */
    public function setReferencedTableSchema(string $referencedTableSchema): static
    {
        $this->referencedTableSchema = $referencedTableSchema;
        return $this;
    }

    /**
     * Set schema name
     */
    public function setSchemaName(string $schemaName): void
    {
        $this->schemaName = $schemaName;
    }

    /**
     * Set table name
     */
    public function setTableName(string $tableName): static
    {
        $this->tableName = $tableName;
        return $this;
    }

    /**
     * Set type
     */
    public function setType(string $type): void
    {
        $this->type = $type;
    }

    /**
     * Set Update Rule.
     */
    public function setUpdateRule(string $updateRule): static
    {
        $this->updateRule = $updateRule;
        return $this;
    }
}
