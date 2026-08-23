<?php

declare(strict_types=1);

namespace PhpDbTest\Metadata\Object;

use PhpDb\Metadata\Object\AbstractTableObject;
use PhpDb\Metadata\Object\ColumnObject;
use PhpDb\Metadata\Object\ConstraintObject;
use PhpDb\Metadata\Object\ViewObject;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

final class ViewObjectTest extends TestCase
{
    #[Test]
    public function completeViewObjectWithAllProperties(): void
    {
        $view = new ViewObject('active_users');

        $definition = "SELECT id, username, email FROM users WHERE status = 'active'";
        $view->setViewDefinition($definition)
            ->setCheckOption('CASCADED')
            ->setIsUpdatable(false);

        $columns = [
            new ColumnObject('id', 'active_users', 'public'),
            new ColumnObject('username', 'active_users', 'public'),
            new ColumnObject('email', 'active_users', 'public'),
        ];
        $view->setColumns($columns);

        // Verify all properties are set correctly
        static::assertSame('active_users', $view->getName());
        static::assertSame($definition, $view->getViewDefinition());
        static::assertSame('CASCADED', $view->getCheckOption());
        static::assertFalse($view->isUpdatable());
        static::assertFalse($view->getIsUpdatable());
        static::assertCount(3, $view->getColumns());
    }

    #[Test]
    public function constructorWithName(): void
    {
        $view = new ViewObject('user_summary');

        // Verify name is set by constructor
        static::assertSame('user_summary', $view->getName());
    }

    #[Test]
    public function constructorWithNullName(): void
    {
        $view = new ViewObject();

        // Verify name defaults to null when not provided
        static::assertNull($view->getName());
    }

    #[Test]
    public function extendsAbstractTableObject(): void
    {
        $view = new ViewObject('view_name');

        // Verify view extends AbstractTableObject
        static::assertInstanceOf(AbstractTableObject::class, $view);
    }

    #[Test]
    public function inheritedColumnsWork(): void
    {
        $view    = new ViewObject('user_summary');
        $columns = [
            new ColumnObject('id', 'user_summary', 'public'),
            new ColumnObject('username', 'user_summary', 'public'),
        ];

        // Verify inherited setColumns method stores columns
        $view->setColumns($columns);
        static::assertSame($columns, $view->getColumns());
        static::assertCount(2, $view->getColumns());
    }

    #[Test]
    public function inheritedConstraintsWork(): void
    {
        $view        = new ViewObject('user_summary');
        $constraints = [
            new ConstraintObject('uq_summary', 'user_summary', 'public'),
        ];

        // Verify inherited setConstraints method stores constraints
        $view->setConstraints($constraints);
        static::assertSame($constraints, $view->getConstraints());
        static::assertCount(1, $view->getConstraints());
    }

    #[Test]
    public function isUpdatableAlias(): void
    {
        $view = new ViewObject('view');

        // Verify alias returns same value when true
        $view->setIsUpdatable(true);
        static::assertTrue($view->isUpdatable());
        static::assertSame($view->getIsUpdatable(), $view->isUpdatable());

        // Verify alias returns same value when false
        $view->setIsUpdatable(false);
        static::assertFalse($view->isUpdatable());
        static::assertSame($view->getIsUpdatable(), $view->isUpdatable());
    }

    #[Test]
    public function isUpdatableAliasWithNull(): void
    {
        $view = new ViewObject('view');

        // Verify alias returns same value when null
        $view->setIsUpdatable(null);
        static::assertNull($view->isUpdatable());
        static::assertSame($view->getIsUpdatable(), $view->isUpdatable());
    }

    #[Test]
    public function setCheckOptionAndGetCheckOptionWithFluentInterface(): void
    {
        $view = new ViewObject('view');

        // Verify fluent interface and value update
        $result = $view->setCheckOption('CASCADED');
        static::assertSame($view, $result);
        static::assertSame('CASCADED', $view->getCheckOption());
    }

    #[Test]
    public function setCheckOptionWithNull(): void
    {
        $view = new ViewObject('view');
        $view->setCheckOption('LOCAL');

        // Set check option to null and verify
        $view->setCheckOption(null);
        static::assertNull($view->getCheckOption());
    }

    #[Test]
    public function setIsUpdatableAndGetIsUpdatableWithFluentInterface(): void
    {
        $view = new ViewObject('view');

        // Verify fluent interface and value update
        $result = $view->setIsUpdatable(true);
        static::assertSame($view, $result);
        static::assertTrue($view->getIsUpdatable());
    }

    #[Test]
    public function setIsUpdatableWithFalse(): void
    {
        $view = new ViewObject('view');

        // Set updatable to false and verify
        $view->setIsUpdatable(false);
        static::assertFalse($view->getIsUpdatable());
    }

    #[Test]
    public function setIsUpdatableWithNull(): void
    {
        $view = new ViewObject('view');
        $view->setIsUpdatable(true);

        // Set updatable to null and verify
        $view->setIsUpdatable(null);
        static::assertNull($view->getIsUpdatable());
    }

    #[Test]
    public function setViewDefinitionAndGetViewDefinitionWithFluentInterface(): void
    {
        $view       = new ViewObject('view');
        $definition = 'SELECT id, name FROM users WHERE active = 1';

        // Verify fluent interface and value update
        $result = $view->setViewDefinition($definition);
        static::assertSame($view, $result);
        static::assertSame($definition, $view->getViewDefinition());
    }

    #[Test]
    public function setViewDefinitionWithNull(): void
    {
        $view = new ViewObject('view');
        $view->setViewDefinition('SELECT * FROM table');

        // Set definition to null and verify
        $view->setViewDefinition(null);
        static::assertNull($view->getViewDefinition());
    }

    #[Test]
    public function viewObjectWithInheritedSetName(): void
    {
        $view = new ViewObject('initial_view');

        // Verify inherited setName method updates the name
        $view->setName('renamed_view');
        static::assertSame('renamed_view', $view->getName());
    }

    #[Test]
    public function viewObjectWithNullProperties(): void
    {
        $view = new ViewObject('simple_view');

        // Verify all properties default to null
        static::assertNull($view->getViewDefinition());
        static::assertNull($view->getCheckOption());
        static::assertNull($view->getIsUpdatable());
        static::assertNull($view->isUpdatable());
    }
}
