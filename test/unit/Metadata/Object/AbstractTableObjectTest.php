<?php

declare(strict_types=1);

namespace PhpDbTest\Metadata\Object;

use PhpDb\Metadata\Object\AbstractTableObject;
use PhpDb\Metadata\Object\ColumnObject;
use PhpDb\Metadata\Object\ConstraintObject;
use PhpDbTest\Metadata\Object\TestAsset\ConcreteTableObject;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

final class AbstractTableObjectTest extends TestCase
{
    #[Test]
    public function completeTableObjectWithAllProperties(): void
    {
        $table = $this->createConcreteTableObject('users');

        $columns = [
            new ColumnObject('id', 'users', 'public'),
            new ColumnObject('username', 'users', 'public'),
            new ColumnObject('email', 'users', 'public'),
        ];

        $constraints = [
            new ConstraintObject('pk_users', 'users', 'public'),
            new ConstraintObject('uq_users_email', 'users', 'public'),
        ];

        $table->setColumns($columns);
        $table->setConstraints($constraints);

        // Verify all properties are set correctly
        static::assertSame('users', $table->getName());
        static::assertSame($columns, $table->getColumns());
        static::assertCount(3, $table->getColumns());
        static::assertSame($constraints, $table->getConstraints());
        static::assertCount(2, $table->getConstraints());
    }

    #[Test]
    public function constructorWithEmptyString(): void
    {
        $table = $this->createConcreteTableObject('');

        // Verify empty string is converted to null
        static::assertNull($table->getName());
    }

    #[Test]
    public function constructorWithName(): void
    {
        $table = $this->createConcreteTableObject('table_name');

        // Verify name is set correctly
        static::assertSame('table_name', $table->getName());
    }

    #[Test]
    public function constructorWithNullName(): void
    {
        $table = $this->createConcreteTableObject(null);

        // Verify null name is preserved
        static::assertNull($table->getName());
    }

    #[Test]
    public function getColumnsReturnsNullWhenNotSet(): void
    {
        $table = $this->createConcreteTableObject('table');

        // Verify columns return null when not set
        static::assertNull($table->getColumns());
    }

    #[Test]
    public function getConstraintsReturnsNullWhenNotSet(): void
    {
        $table = $this->createConcreteTableObject('table');

        // Verify constraints return null when not set
        static::assertNull($table->getConstraints());
    }

    #[Test]
    public function setColumnsAndGetColumns(): void
    {
        $table   = $this->createConcreteTableObject('table');
        $columns = [
            new ColumnObject('id', 'table', 'schema'),
            new ColumnObject('name', 'table', 'schema'),
        ];

        // Set columns and verify retrieval
        $table->setColumns($columns);
        static::assertSame($columns, $table->getColumns());
    }

    #[Test]
    public function setColumnsWithEmptyArray(): void
    {
        $table = $this->createConcreteTableObject('table');

        // Set empty columns array and verify
        $table->setColumns([]);
        static::assertSame([], $table->getColumns());
    }

    #[Test]
    public function setConstraintsAndGetConstraints(): void
    {
        $table       = $this->createConcreteTableObject('table');
        $constraints = [
            new ConstraintObject('pk_table', 'table', 'schema'),
            new ConstraintObject('fk_table', 'table', 'schema'),
        ];

        // Set constraints and verify retrieval
        $table->setConstraints($constraints);
        static::assertSame($constraints, $table->getConstraints());
    }

    #[Test]
    public function setConstraintsWithEmptyArray(): void
    {
        $table = $this->createConcreteTableObject('table');

        // Set empty constraints array and verify
        $table->setConstraints([]);
        static::assertSame([], $table->getConstraints());
    }

    #[Test]
    public function setNameAndGetName(): void
    {
        $table = $this->createConcreteTableObject('initial_name');

        // Update name and verify change
        $table->setName('new_name');
        static::assertSame('new_name', $table->getName());
    }

    private function createConcreteTableObject(?string $name): AbstractTableObject
    {
        return new ConcreteTableObject($name);
    }
}
