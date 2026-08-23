<?php

declare(strict_types=1);

namespace PhpDbTest\Metadata\Object;

use PhpDb\Metadata\Object\AbstractTableObject;
use PhpDb\Metadata\Object\ColumnObject;
use PhpDb\Metadata\Object\ConstraintObject;
use PhpDb\Metadata\Object\TableObject;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

final class TableObjectTest extends TestCase
{
    #[Test]
    public function canBeInstantiated(): void
    {
        $table = new TableObject('test_table');

        // Verify object can be instantiated directly
        static::assertInstanceOf(TableObject::class, $table);
        static::assertSame('test_table', $table->getName());
    }

    #[Test]
    public function completeTableObjectWithAllInheritedFunctionality(): void
    {
        $table = new TableObject('orders');

        $columns = [
            new ColumnObject('id', 'orders', 'public'),
            new ColumnObject('user_id', 'orders', 'public'),
            new ColumnObject('total', 'orders', 'public'),
            new ColumnObject('created_at', 'orders', 'public'),
        ];

        $constraints = [
            new ConstraintObject('pk_orders', 'orders', 'public'),
            new ConstraintObject('fk_orders_user', 'orders', 'public'),
        ];

        $table->setColumns($columns);
        $table->setConstraints($constraints);

        // Verify all inherited functionality works correctly
        static::assertSame('orders', $table->getName());
        static::assertCount(4, $table->getColumns());
        static::assertCount(2, $table->getConstraints());
        static::assertInstanceOf(AbstractTableObject::class, $table);
    }

    #[Test]
    public function constructorWithName(): void
    {
        $table = new TableObject('users');

        // Verify name is set by constructor
        static::assertSame('users', $table->getName());
    }

    #[Test]
    public function constructorWithNullName(): void
    {
        $table = new TableObject();

        // Verify name defaults to null when not provided
        static::assertNull($table->getName());
    }

    #[Test]
    public function extendsAbstractTableObject(): void
    {
        $table = new TableObject('table_name');

        // Verify table extends AbstractTableObject
        static::assertInstanceOf(AbstractTableObject::class, $table);
    }

    #[Test]
    public function inheritedSetColumnsWorks(): void
    {
        $table   = new TableObject('users');
        $columns = [
            new ColumnObject('id', 'users', 'public'),
            new ColumnObject('name', 'users', 'public'),
        ];

        // Verify inherited setColumns method stores columns
        $table->setColumns($columns);
        static::assertSame($columns, $table->getColumns());
        static::assertCount(2, $table->getColumns());
    }

    #[Test]
    public function inheritedSetConstraintsWorks(): void
    {
        $table       = new TableObject('users');
        $constraints = [
            new ConstraintObject('pk_users', 'users', 'public'),
        ];

        // Verify inherited setConstraints method stores constraints
        $table->setConstraints($constraints);
        static::assertSame($constraints, $table->getConstraints());
        static::assertCount(1, $table->getConstraints());
    }

    #[Test]
    public function inheritedSetNameWorks(): void
    {
        $table = new TableObject('initial');

        // Verify inherited setName method updates the name
        $table->setName('updated');
        static::assertSame('updated', $table->getName());
    }
}
