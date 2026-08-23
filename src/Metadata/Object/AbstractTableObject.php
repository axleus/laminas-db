<?php

declare(strict_types=1);

namespace PhpDb\Metadata\Object;

/**
 * @api
 */
abstract class AbstractTableObject
{
    protected ?string $name = null;

    protected ?string $type = null;

    /** @var list<ColumnObject>|null */
    protected ?array $columns = null;

    /** @var list<ConstraintObject>|null */
    protected ?array $constraints = null;

    /**
     * Constructor
     */
    public function __construct(?string $name = null)
    {
        if ($name) {
            $this->setName($name);
        }
    }

    /**
     * Get columns
     *
     * @return list<ColumnObject>|null
     */
    public function getColumns(): ?array
    {
        return $this->columns;
    }

    /**
     * Get constraints
     *
     * @return list<ConstraintObject>|null
     */
    public function getConstraints(): ?array
    {
        return $this->constraints;
    }

    /**
     * Get name
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * Set columns
     *
     * @param list<ColumnObject> $columns
     */
    public function setColumns(array $columns): void
    {
        $this->columns = $columns;
    }

    /**
     * Set constraints
     *
     * @param list<ConstraintObject> $constraints
     */
    public function setConstraints(array $constraints): void
    {
        $this->constraints = $constraints;
    }

    /**
     * Set name
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }
}
