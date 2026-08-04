<?php

declare(strict_types=1);

namespace PhpDb\RowGateway\Feature;

use PhpDb\RowGateway\AbstractRowGateway;
use PhpDb\RowGateway\Exception;
use PhpDb\RowGateway\Exception\RuntimeException;

abstract class AbstractFeature extends AbstractRowGateway implements FeatureInterface
{
    protected AbstractRowGateway $rowGateway;

    protected array $sharedData = [];

    /** @return array<string, string[]> */
    public function getMagicMethodSpecifications(): array
    {
        return [];
    }

    public function getName(): string
    {
        return static::class;
    }

    /**
     * @throws RuntimeException
     */
    public function initialize(): void
    {
        throw new Exception\RuntimeException('This method is not intended to be called on this object.');
    }

    public function setRowGateway(AbstractRowGateway $rowGateway): void
    {
        $this->rowGateway = $rowGateway;
    }
}
