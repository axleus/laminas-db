<?php

declare(strict_types=1);

namespace PhpDb\RowGateway\Feature;

use PhpDb\RowGateway\AbstractRowGateway;

use function method_exists;

/**
 * @final
 */
class FeatureSet
{
    final public const APPLY_HALT = 'halt';

    protected ?AbstractRowGateway $rowGateway = null;

    /** @var FeatureInterface[] */
    protected array $features = [];

    protected array $magicSpecifications = [];

    public function __construct(array $features = [])
    {
        if ([] !== $features) {
            $this->addFeatures($features);
        }
    }

    public function addFeature(FeatureInterface $feature): static
    {
        $this->features[] = $feature;
        if (null !== $this->rowGateway) {
            $feature->setRowGateway($this->rowGateway);
        }
        return $this;
    }

    public function addFeatures(array $features): static
    {
        foreach ($features as $feature) {
            $this->addFeature($feature);
        }
        return $this;
    }

    public function apply(string $method, array $args): void
    {
        foreach ($this->features as $feature) {
            if (! method_exists($feature, $method)) {
                continue;
            }

            $return = $feature->$method(...$args);
            if (self::APPLY_HALT === $return) {
                break;
            }
        }
    }

    public function callMagicCall(string $method, array $arguments): mixed
    {
        return null;
    }

    public function callMagicGet(string $property): mixed
    {
        return null;
    }

    public function callMagicSet(string $property, mixed $value): mixed
    {
        return null;
    }

    public function canCallMagicCall(string $method): bool
    {
        return false;
    }

    public function canCallMagicGet(string $property): false
    {
        return false;
    }

    public function canCallMagicSet(string $property): false
    {
        return false;
    }

    public function getFeatureByClassName(string $featureClassName): ?FeatureInterface
    {
        $feature = null;
        foreach ($this->features as $potentialFeature) {
            if (! $potentialFeature instanceof $featureClassName) {
                continue;
            }

            $feature = $potentialFeature;
            break;
        }
        return $feature;
    }

    public function setRowGateway(AbstractRowGateway $rowGateway): static
    {
        $this->rowGateway = $rowGateway;
        foreach ($this->features as $feature) {
            $feature->setRowGateway($this->rowGateway);
        }
        return $this;
    }
}
