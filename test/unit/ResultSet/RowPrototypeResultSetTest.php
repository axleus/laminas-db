<?php

declare(strict_types=1);

namespace PhpDbTest\ResultSet;

use ArrayIterator;
use PhpDb\ResultSet\RowPrototypeInterface;
use PhpDb\ResultSet\RowPrototypeResultSet;
use PHPUnit\Framework\Attributes\CoversMethod;
use PHPUnit\Framework\Attributes\Group;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

#[CoversMethod(RowPrototypeResultSet::class, 'current')]
#[CoversMethod(RowPrototypeResultSet::class, 'toArray')]
#[Group('unit')]
final class RowPrototypeResultSetTest extends TestCase
{
    #[Test]
    public function currentReturnsDataUnchangedWhenNotArray(): void
    {
        $prototype = $this->createRowPrototype();
        $resultSet = new RowPrototypeResultSet($prototype);
        $resultSet->initialize(new ArrayIterator([null]));

        static::assertNull($resultSet->current());
    }

    #[Test]
    public function currentReturnsPopulatedCloneOfPrototypeForArrayRow(): void
    {
        $prototype = $this->createRowPrototype();
        $resultSet = new RowPrototypeResultSet($prototype);
        $resultSet->initialize(new ArrayIterator([
            ['id' => 1, 'name' => 'one'],
        ]));

        $current = $resultSet->current();

        static::assertInstanceOf(RowPrototypeInterface::class, $current);
        static::assertNotSame($prototype, $current);
        static::assertSame(['id' => 1, 'name' => 'one'], $current->toArray());
    }

    #[Test]
    public function toArrayConvertsPrototypeRowsToArrays(): void
    {
        $prototype = $this->createRowPrototype();
        $resultSet = new RowPrototypeResultSet($prototype);
        $resultSet->initialize(new ArrayIterator([
            ['id' => 1],
            ['id' => 2],
        ]));

        static::assertSame(
            [
                ['id' => 1],
                ['id' => 2],
            ],
            $resultSet->toArray(),
        );
    }

    private function createRowPrototype(): RowPrototypeInterface
    {
        return new class implements RowPrototypeInterface {
            private array $data = [];

            public function populate(array $data): RowPrototypeInterface
            {
                $this->data = $data;

                return $this;
            }

            public function toArray(): array
            {
                return $this->data;
            }
        };
    }
}
