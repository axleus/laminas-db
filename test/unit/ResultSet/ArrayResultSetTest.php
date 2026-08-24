<?php

declare(strict_types=1);

namespace PhpDbTest\ResultSet;

use PhpDb\ResultSet\ArrayResultSet;
use PHPUnit\Framework\Attributes\CoversMethod;
use PHPUnit\Framework\Attributes\Group;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

#[CoversMethod(ArrayResultSet::class, 'toArray')]
#[Group('unit')]
final class ArrayResultSetTest extends TestCase
{
    #[Test]
    public function toArrayReturnsRowsAsProvided(): void
    {
        $resultSet = new ArrayResultSet();
        $resultSet->initialize([
            ['id' => 1, 'name' => 'one'],
            ['id' => 2, 'name' => 'two'],
        ]);

        static::assertSame(
            [
                ['id' => 1, 'name' => 'one'],
                ['id' => 2, 'name' => 'two'],
            ],
            $resultSet->toArray(),
        );
    }
}
