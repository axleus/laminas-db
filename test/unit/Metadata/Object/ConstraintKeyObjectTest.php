<?php

declare(strict_types=1);

namespace PhpDbTest\Metadata\Object;

use PhpDb\Metadata\Object\ConstraintKeyObject;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

final class ConstraintKeyObjectTest extends TestCase
{
    #[Test]
    public function completeConstraintKeyObject(): void
    {
        $constraintKey = new ConstraintKeyObject('user_id');

        $constraintKey->setOrdinalPosition(1)
            ->setPositionInUniqueConstraint(false)
            ->setReferencedTableSchema('public')
            ->setReferencedTableName('users')
            ->setReferencedColumnName('id');
        $constraintKey->setForeignKeyUpdateRule(ConstraintKeyObject::FK_CASCADE);
        $constraintKey->setForeignKeyDeleteRule(ConstraintKeyObject::FK_RESTRICT);

        // Verify all properties are set correctly
        static::assertSame('user_id', $constraintKey->getColumnName());
        static::assertSame(1, $constraintKey->getOrdinalPosition());
        static::assertFalse($constraintKey->getPositionInUniqueConstraint());
        static::assertSame('public', $constraintKey->getReferencedTableSchema());
        static::assertSame('users', $constraintKey->getReferencedTableName());
        static::assertSame('id', $constraintKey->getReferencedColumnName());
        static::assertSame('CASCADE', $constraintKey->getForeignKeyUpdateRule());
        static::assertSame('RESTRICT', $constraintKey->getForeignKeyDeleteRule());
    }

    #[Test]
    public function constructorSetsColumnName(): void
    {
        $constraintKey = new ConstraintKeyObject('column_name');

        // Verify column name is set by constructor
        static::assertSame('column_name', $constraintKey->getColumnName());
    }

    #[Test]
    public function foreignKeyConstants(): void
    {
        // Verify all foreign key constants are defined correctly
        static::assertSame('CASCADE', ConstraintKeyObject::FK_CASCADE);
        static::assertSame('SET NULL', ConstraintKeyObject::FK_SET_NULL);
        static::assertSame('NO ACTION', ConstraintKeyObject::FK_NO_ACTION);
        static::assertSame('RESTRICT', ConstraintKeyObject::FK_RESTRICT);
        static::assertSame('SET DEFAULT', ConstraintKeyObject::FK_SET_DEFAULT);
    }

    #[Test]
    public function setColumnNameAndGetColumnNameWithFluentInterface(): void
    {
        $constraintKey = new ConstraintKeyObject('initial');

        // Verify fluent interface and value update
        $result = $constraintKey->setColumnName('new_column');
        static::assertSame($constraintKey, $result);
        static::assertSame('new_column', $constraintKey->getColumnName());
    }

    #[Test]
    public function setForeignKeyDeleteRuleAndGetForeignKeyDeleteRule(): void
    {
        $constraintKey = new ConstraintKeyObject('column');

        // Set delete rule and verify retrieval
        $constraintKey->setForeignKeyDeleteRule(ConstraintKeyObject::FK_RESTRICT);
        static::assertSame('RESTRICT', $constraintKey->getForeignKeyDeleteRule());

        // Verify mutation by changing to different value
        $constraintKey->setForeignKeyDeleteRule(ConstraintKeyObject::FK_CASCADE);
        static::assertSame('CASCADE', $constraintKey->getForeignKeyDeleteRule());
    }

    #[Test]
    public function setForeignKeyDeleteRuleWithAllConstants(): void
    {
        $constraintKey = new ConstraintKeyObject('column');

        // Verify CASCADE constant
        $constraintKey->setForeignKeyDeleteRule(ConstraintKeyObject::FK_CASCADE);
        static::assertSame('CASCADE', $constraintKey->getForeignKeyDeleteRule());

        // Verify SET NULL constant
        $constraintKey->setForeignKeyDeleteRule(ConstraintKeyObject::FK_SET_NULL);
        static::assertSame('SET NULL', $constraintKey->getForeignKeyDeleteRule());

        // Verify NO ACTION constant
        $constraintKey->setForeignKeyDeleteRule(ConstraintKeyObject::FK_NO_ACTION);
        static::assertSame('NO ACTION', $constraintKey->getForeignKeyDeleteRule());

        // Verify RESTRICT constant
        $constraintKey->setForeignKeyDeleteRule(ConstraintKeyObject::FK_RESTRICT);
        static::assertSame('RESTRICT', $constraintKey->getForeignKeyDeleteRule());

        // Verify SET DEFAULT constant
        $constraintKey->setForeignKeyDeleteRule(ConstraintKeyObject::FK_SET_DEFAULT);
        static::assertSame('SET DEFAULT', $constraintKey->getForeignKeyDeleteRule());
    }

    #[Test]
    public function setForeignKeyUpdateRuleAndGetForeignKeyUpdateRule(): void
    {
        $constraintKey = new ConstraintKeyObject('column');

        // Set update rule and verify retrieval
        $constraintKey->setForeignKeyUpdateRule(ConstraintKeyObject::FK_CASCADE);
        static::assertSame('CASCADE', $constraintKey->getForeignKeyUpdateRule());

        // Verify mutation by changing to different value
        $constraintKey->setForeignKeyUpdateRule(ConstraintKeyObject::FK_RESTRICT);
        static::assertSame('RESTRICT', $constraintKey->getForeignKeyUpdateRule());
    }

    #[Test]
    public function setForeignKeyUpdateRuleWithAllConstants(): void
    {
        $constraintKey = new ConstraintKeyObject('column');

        // Verify CASCADE constant
        $constraintKey->setForeignKeyUpdateRule(ConstraintKeyObject::FK_CASCADE);
        static::assertSame('CASCADE', $constraintKey->getForeignKeyUpdateRule());

        // Verify SET NULL constant
        $constraintKey->setForeignKeyUpdateRule(ConstraintKeyObject::FK_SET_NULL);
        static::assertSame('SET NULL', $constraintKey->getForeignKeyUpdateRule());

        // Verify NO ACTION constant
        $constraintKey->setForeignKeyUpdateRule(ConstraintKeyObject::FK_NO_ACTION);
        static::assertSame('NO ACTION', $constraintKey->getForeignKeyUpdateRule());

        // Verify RESTRICT constant
        $constraintKey->setForeignKeyUpdateRule(ConstraintKeyObject::FK_RESTRICT);
        static::assertSame('RESTRICT', $constraintKey->getForeignKeyUpdateRule());

        // Verify SET DEFAULT constant
        $constraintKey->setForeignKeyUpdateRule(ConstraintKeyObject::FK_SET_DEFAULT);
        static::assertSame('SET DEFAULT', $constraintKey->getForeignKeyUpdateRule());
    }

    #[Test]
    public function setOrdinalPositionAndGetOrdinalPositionWithFluentInterface(): void
    {
        $constraintKey = new ConstraintKeyObject('column');

        // Verify fluent interface and value update
        $result = $constraintKey->setOrdinalPosition(3);
        static::assertSame($constraintKey, $result);
        static::assertSame(3, $constraintKey->getOrdinalPosition());
    }

    #[Test]
    public function setPositionInUniqueConstraintAndGetPositionInUniqueConstraintWithFluentInterface(): void
    {
        $constraintKey = new ConstraintKeyObject('column');

        // Verify fluent interface and value update
        $result = $constraintKey->setPositionInUniqueConstraint(true);
        static::assertSame($constraintKey, $result);
        static::assertTrue($constraintKey->getPositionInUniqueConstraint());
    }

    #[Test]
    public function setReferencedColumnNameAndGetReferencedColumnNameWithFluentInterface(): void
    {
        $constraintKey = new ConstraintKeyObject('column');

        // Verify fluent interface and value update
        $result = $constraintKey->setReferencedColumnName('ref_column');
        static::assertSame($constraintKey, $result);
        static::assertSame('ref_column', $constraintKey->getReferencedColumnName());
    }

    #[Test]
    public function setReferencedTableNameAndGetReferencedTableNameWithFluentInterface(): void
    {
        $constraintKey = new ConstraintKeyObject('column');

        // Verify fluent interface and value update
        $result = $constraintKey->setReferencedTableName('ref_table');
        static::assertSame($constraintKey, $result);
        static::assertSame('ref_table', $constraintKey->getReferencedTableName());
    }

    #[Test]
    public function setReferencedTableSchemaAndGetReferencedTableSchemaWithFluentInterface(): void
    {
        $constraintKey = new ConstraintKeyObject('column');

        // Verify fluent interface and value update
        $result = $constraintKey->setReferencedTableSchema('ref_schema');
        static::assertSame($constraintKey, $result);
        static::assertSame('ref_schema', $constraintKey->getReferencedTableSchema());
    }
}
