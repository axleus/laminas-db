<?php

declare(strict_types=1);

namespace PhpDb\Feature;

interface FeatureInterface
{
    /** @return array<string, string[]> */
    public function getMagicMethodSpecifications(): array;

    public function getName(): string;
}
