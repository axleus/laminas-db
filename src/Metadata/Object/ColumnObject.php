<?php

declare(strict_types=1);

namespace PhpDb\Metadata\Object;

use function array_key_exists;

final class ColumnObject
{
    private ?int $ordinalPosition = null;

    private string|int|bool|null $columnDefault = null;

    private ?bool $isNullable = null;

    private ?string $dataType = null;

    private ?int $characterMaximumLength = null;

    private ?int $characterOctetLength = null;

    private ?int $numericPrecision = null;

    private ?int $numericScale = null;

    private ?bool $numericUnsigned = null;

    /** @var array<string, mixed> */
    private array $errata = [];

    public function __construct(
        private string $name,
        private string $tableName,
        private ?string $schemaName = null,
    ) {}

    /**
     * @return int|null the $characterMaximumLength
     */
    public function getCharacterMaximumLength(): ?int
    {
        return $this->characterMaximumLength;
    }

    /**
     * @return int|null the $characterOctetLength
     */
    public function getCharacterOctetLength(): ?int
    {
        return $this->characterOctetLength;
    }

    /**
     * @return string|int|bool|null the $columnDefault
     */
    public function getColumnDefault(): string|int|bool|null
    {
        return $this->columnDefault;
    }

    /**
     * @return null|string the $dataType
     */
    public function getDataType(): ?string
    {
        return $this->dataType;
    }

    public function getErrata(string $errataName): mixed
    {
        if (array_key_exists($errataName, $this->errata)) {
            return $this->errata[$errataName];
        }

        return null;
    }

    /**
     * @return array<string, mixed> the $errata
     */
    public function getErratas(): array
    {
        return $this->errata;
    }

    /**
     * @return bool|null $isNullable
     */
    public function getIsNullable(): ?bool
    {
        return $this->isNullable;
    }

    /**
     * Get name
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return int|null the $numericPrecision
     */
    public function getNumericPrecision(): ?int
    {
        return $this->numericPrecision;
    }

    /**
     * @return int|null the $numericScale
     */
    public function getNumericScale(): ?int
    {
        return $this->numericScale;
    }

    public function getNumericUnsigned(): ?bool
    {
        return $this->numericUnsigned;
    }

    /**
     * @return int|null $ordinalPosition
     */
    public function getOrdinalPosition(): ?int
    {
        return $this->ordinalPosition;
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

    public function isNumericUnsigned(): ?bool
    {
        return $this->numericUnsigned;
    }

    public function setCharacterMaximumLength(?int $characterMaximumLength): static
    {
        $this->characterMaximumLength = $characterMaximumLength;
        return $this;
    }

    public function setCharacterOctetLength(?int $characterOctetLength): static
    {
        $this->characterOctetLength = $characterOctetLength;
        return $this;
    }

    public function setColumnDefault(string|int|bool|null $columnDefault): static
    {
        $this->columnDefault = $columnDefault;
        return $this;
    }

    public function setDataType(string $dataType): static
    {
        $this->dataType = $dataType;
        return $this;
    }

    public function setErrata(string $errataName, mixed $errataValue): static
    {
        $this->errata[$errataName] = $errataValue;
        return $this;
    }

    /**
     * @param array<string, mixed> $erratas
     */
    public function setErratas(array $erratas): static
    {
        $this->errata = [...$this->errata, ...$erratas];

        return $this;
    }

    public function setIsNullable(?bool $isNullable): static
    {
        $this->isNullable = $isNullable;
        return $this;
    }

    /**
     * Set name
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function setNumericPrecision(?int $numericPrecision): static
    {
        $this->numericPrecision = $numericPrecision;
        return $this;
    }

    public function setNumericScale(?int $numericScale): static
    {
        $this->numericScale = $numericScale;
        return $this;
    }

    public function setNumericUnsigned(?bool $numericUnsigned): static
    {
        $this->numericUnsigned = $numericUnsigned;
        return $this;
    }

    public function setOrdinalPosition(?int $ordinalPosition): static
    {
        $this->ordinalPosition = $ordinalPosition;
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
}
