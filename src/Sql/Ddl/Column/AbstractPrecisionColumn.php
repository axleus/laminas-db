<?php

declare(strict_types=1);

namespace PhpDb\Sql\Ddl\Column;

use Override;

abstract class AbstractPrecisionColumn extends AbstractLengthColumn
{
    protected ?int $decimal;

    public function __construct(
        string $name,
        ?int $digits = null,
        ?int $decimal = null,
        bool $nullable = false,
        mixed $default = null,
        array $options = [],
    ) {
        $this->setDecimal($decimal);

        parent::__construct($name, $digits, $nullable, $default, $options);
    }

    public function getDecimal(): ?int
    {
        return $this->decimal;
    }

    public function getDigits(): ?int
    {
        return $this->getLength();
    }

    public function setDecimal(?int $decimal): static
    {
        $this->decimal = $decimal;

        return $this;
    }

    public function setDigits(?int $digits): static
    {
        return $this->setLength($digits);
    }

    #[Override]
    protected function getLengthExpression(): string
    {
        if (null !== $this->decimal) {
            return "{$this->length},{$this->decimal}";
        }

        return (string) $this->length;
    }
}
