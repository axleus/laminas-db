<?php

declare(strict_types=1);

namespace PhpDbTest\TestAsset;

use Override;
use PDO;

class PdoStubDriver extends PDO
{
    public function __construct()
    {
        parent::__construct('sqlite::memory:');
    }

    #[Override]
    public function beginTransaction(): bool
    {
        return true;
    }

    #[Override]
    public function commit(): bool
    {
        return true;
    }

    #[Override]
    public function rollBack(): bool
    {
        return true;
    }
}
