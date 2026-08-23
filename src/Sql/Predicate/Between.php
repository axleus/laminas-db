<?php

declare(strict_types=1);

namespace PhpDb\Sql\Predicate;

use LogicException;
use Override;
use PhpDb\Sql\AbstractExpression;
use PhpDb\Sql\Argument\Identifier;
use PhpDb\Sql\Argument\Value;
use PhpDb\Sql\ArgumentInterface;

class Between extends AbstractExpression implements PredicateInterface
{
    protected string $operator = 'BETWEEN';

    protected ?ArgumentInterface $identifier = null;

    protected ?ArgumentInterface $minValue = null;

    protected ?ArgumentInterface $maxValue = null;

    /**
     * Constructor
     */
    public function __construct(
        string|ArgumentInterface|null $identifier = null,
        int|float|string|ArgumentInterface|null $minValue = null,
        int|float|string|ArgumentInterface|null $maxValue = null,
    ) {
        if (null !== $identifier) {
            $this->setIdentifier($identifier);
        }

        if (null !== $minValue) {
            $this->setMinValue($minValue);
        }

        if (null !== $maxValue) {
            $this->setMaxValue($maxValue);
        }
    }

    /** @inheritDoc */
    #[Override]
    public function getExpressionData(): array
    {
        if (! $this->identifier instanceof ArgumentInterface) {
            throw new LogicException('Identifier must be specified');
        }

        if (! $this->minValue instanceof ArgumentInterface) {
            throw new LogicException('minValue must be specified');
        }

        if (! $this->maxValue instanceof ArgumentInterface) {
            throw new LogicException('maxValue must be specified');
        }

        $identifierSpec = $this->identifier->getSpecification();
        $minValueSpec   = $this->minValue->getSpecification();
        $maxValueSpec   = $this->maxValue->getSpecification();
        $spec           = "{$identifierSpec} {$this->operator} {$minValueSpec} AND {$maxValueSpec}";

        return [
            'spec'   => $this->specification ?? $spec,
            'values' => [$this->identifier, $this->minValue, $this->maxValue],
        ];
    }

    /**
     * Get identifier for comparison
     */
    public function getIdentifier(): ?ArgumentInterface
    {
        return $this->identifier;
    }

    /**
     * Get maximum value for comparison
     */
    public function getMaxValue(): ?ArgumentInterface
    {
        return $this->maxValue;
    }

    /**
     * Get minimum value for comparison
     */
    public function getMinValue(): ?ArgumentInterface
    {
        return $this->minValue;
    }

    /**
     * Set identifier for comparison
     */
    public function setIdentifier(string|ArgumentInterface $identifier): static
    {
        $this->identifier = $identifier instanceof ArgumentInterface
            ? $identifier
            : new Identifier($identifier);

        return $this;
    }

    /**
     * Set maximum value for comparison
     */
    public function setMaxValue(int|float|string|bool|ArgumentInterface|null $maxValue): static
    {
        $this->maxValue = $maxValue instanceof ArgumentInterface
            ? $maxValue
            : new Value($maxValue);

        return $this;
    }

    /**
     * Set minimum value for comparison
     */
    public function setMinValue(int|float|string|bool|ArgumentInterface|null $minValue): static
    {
        $this->minValue = $minValue instanceof ArgumentInterface
            ? $minValue
            : new Value($minValue);

        return $this;
    }
}
