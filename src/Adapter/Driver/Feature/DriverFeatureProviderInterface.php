<?php

declare(strict_types=1);

namespace PhpDb\Adapter\Driver\Feature;

use PhpDb\Adapter\Driver\DriverInterface;

/**
 * @property array<class-string, DriverInterface> $features
 */
interface DriverFeatureProviderInterface
{
    public function addFeature(DriverFeatureInterface $feature): self;

    /** @param DriverFeatureInterface[] $features */
    public function addFeatures(array $features): self;

    /** Get feature by class FQCN. */
    public function getFeature(string $name): DriverFeatureInterface|false;
}
