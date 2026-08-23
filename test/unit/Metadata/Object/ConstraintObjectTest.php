<?php

declare(strict_types=1);

namespace PhpDbTest\Metadata\Object;

use PhpDb\Metadata\Object\ConstraintObject;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

final class ConstraintObjectTest extends TestCase
{
    #[Test]
    public function completeCheckConstraint(): void
    {
        $constraint = new ConstraintObject('chk_users_age', 'users', 'public');
        $constraint->setType('CHECK');
        $constraint->setCheckClause('age >= 18 AND age <= 120');

        // Verify check constraint is configured correctly
        static::assertTrue($constraint->isCheck());
        static::assertFalse($constraint->isPrimaryKey());
        static::assertFalse($constraint->isUnique());
        static::assertFalse($constraint->isForeignKey());
        static::assertSame('age >= 18 AND age <= 120', $constraint->getCheckClause());
    }

    #[Test]
    public function completeForeignKeyConstraint(): void
    {
        $constraint = new ConstraintObject('fk_orders_user', 'orders', 'public');
        $constraint->setType('FOREIGN KEY');
        $constraint->setColumns(['user_id'])
            ->setReferencedTableSchema('public')
            ->setReferencedTableName('users')
            ->setReferencedColumns(['id'])
            ->setMatchOption('SIMPLE')
            ->setUpdateRule('CASCADE')
            ->setDeleteRule('RESTRICT');

        // Verify foreign key constraint is configured correctly
        static::assertSame('fk_orders_user', $constraint->getName());
        static::assertTrue($constraint->isForeignKey());
        static::assertFalse($constraint->isPrimaryKey());
        static::assertFalse($constraint->isUnique());
        static::assertFalse($constraint->isCheck());
        static::assertSame(['user_id'], $constraint->getColumns());
        static::assertSame('public', $constraint->getReferencedTableSchema());
        static::assertSame('users', $constraint->getReferencedTableName());
        static::assertSame(['id'], $constraint->getReferencedColumns());
        static::assertSame('SIMPLE', $constraint->getMatchOption());
        static::assertSame('CASCADE', $constraint->getUpdateRule());
        static::assertSame('RESTRICT', $constraint->getDeleteRule());
    }

    #[Test]
    public function completePrimaryKeyConstraint(): void
    {
        $constraint = new ConstraintObject('pk_users', 'users', 'public');
        $constraint->setType('PRIMARY KEY');
        $constraint->setColumns(['id']);

        // Verify primary key constraint is configured correctly
        static::assertSame('pk_users', $constraint->getName());
        static::assertSame('users', $constraint->getTableName());
        static::assertSame('public', $constraint->getSchemaName());
        static::assertTrue($constraint->isPrimaryKey());
        static::assertFalse($constraint->isUnique());
        static::assertFalse($constraint->isForeignKey());
        static::assertFalse($constraint->isCheck());
        static::assertSame(['id'], $constraint->getColumns());
        static::assertTrue($constraint->hasColumns());
    }

    #[Test]
    public function completeUniqueConstraint(): void
    {
        $constraint = new ConstraintObject('uq_users_email', 'users', 'public');
        $constraint->setType('UNIQUE');
        $constraint->setColumns(['email']);

        // Verify unique constraint is configured correctly
        static::assertTrue($constraint->isUnique());
        static::assertFalse($constraint->isPrimaryKey());
        static::assertFalse($constraint->isForeignKey());
        static::assertFalse($constraint->isCheck());
        static::assertSame(['email'], $constraint->getColumns());
    }

    #[Test]
    public function constructorWithAllParameters(): void
    {
        $constraint = new ConstraintObject('constraint_name', 'table_name', 'schema_name');

        // Verify all constructor parameters are set
        static::assertSame('constraint_name', $constraint->getName());
        static::assertSame('table_name', $constraint->getTableName());
        static::assertSame('schema_name', $constraint->getSchemaName());
    }

    #[Test]
    public function constructorWithNullSchema(): void
    {
        $constraint = new ConstraintObject('constraint_name', 'table_name');

        // Verify schema defaults to null
        static::assertSame('constraint_name', $constraint->getName());
        static::assertSame('table_name', $constraint->getTableName());
        static::assertNull($constraint->getSchemaName());
    }

    #[Test]
    public function hasColumnsReturnsFalseWhenEmpty(): void
    {
        $constraint = new ConstraintObject('name', 'table', 'schema');

        // Verify hasColumns returns false when not set
        static::assertFalse($constraint->hasColumns());
    }

    #[Test]
    public function hasColumnsReturnsTrueWhenPopulated(): void
    {
        $constraint = new ConstraintObject('name', 'table', 'schema');

        // Verify hasColumns returns true after setting columns
        $constraint->setColumns(['col1', 'col2']);
        static::assertTrue($constraint->hasColumns());
    }

    #[Test]
    public function isCheckReturnsFalseForOtherTypes(): void
    {
        $constraint = new ConstraintObject('name', 'table', 'schema');

        // Verify isCheck returns false for PRIMARY KEY
        $constraint->setType('PRIMARY KEY');
        static::assertFalse($constraint->isCheck());

        // Verify isCheck returns false for UNIQUE
        $constraint->setType('UNIQUE');
        static::assertFalse($constraint->isCheck());

        // Verify isCheck returns false for FOREIGN KEY
        $constraint->setType('FOREIGN KEY');
        static::assertFalse($constraint->isCheck());
    }

    #[Test]
    public function isCheckReturnsTrueForCheck(): void
    {
        $constraint = new ConstraintObject('name', 'table', 'schema');

        // Verify isCheck returns true for CHECK type
        $constraint->setType('CHECK');
        static::assertTrue($constraint->isCheck());
    }

    #[Test]
    public function isForeignKeyReturnsFalseForOtherTypes(): void
    {
        $constraint = new ConstraintObject('name', 'table', 'schema');

        // Verify isForeignKey returns false for PRIMARY KEY
        $constraint->setType('PRIMARY KEY');
        static::assertFalse($constraint->isForeignKey());

        // Verify isForeignKey returns false for UNIQUE
        $constraint->setType('UNIQUE');
        static::assertFalse($constraint->isForeignKey());

        // Verify isForeignKey returns false for CHECK
        $constraint->setType('CHECK');
        static::assertFalse($constraint->isForeignKey());
    }

    #[Test]
    public function isForeignKeyReturnsTrueForForeignKey(): void
    {
        $constraint = new ConstraintObject('name', 'table', 'schema');

        // Verify isForeignKey returns true for FOREIGN KEY type
        $constraint->setType('FOREIGN KEY');
        static::assertTrue($constraint->isForeignKey());
    }

    #[Test]
    public function isPrimaryKeyReturnsFalseForOtherTypes(): void
    {
        $constraint = new ConstraintObject('name', 'table', 'schema');

        // Verify isPrimaryKey returns false for UNIQUE
        $constraint->setType('UNIQUE');
        static::assertFalse($constraint->isPrimaryKey());

        // Verify isPrimaryKey returns false for FOREIGN KEY
        $constraint->setType('FOREIGN KEY');
        static::assertFalse($constraint->isPrimaryKey());

        // Verify isPrimaryKey returns false for CHECK
        $constraint->setType('CHECK');
        static::assertFalse($constraint->isPrimaryKey());
    }

    #[Test]
    public function isPrimaryKeyReturnsTrueForPrimaryKey(): void
    {
        $constraint = new ConstraintObject('name', 'table', 'schema');

        // Verify isPrimaryKey returns true for PRIMARY KEY type
        $constraint->setType('PRIMARY KEY');
        static::assertTrue($constraint->isPrimaryKey());
    }

    #[Test]
    public function isUniqueReturnsFalseForOtherTypes(): void
    {
        $constraint = new ConstraintObject('name', 'table', 'schema');

        // Verify isUnique returns false for PRIMARY KEY
        $constraint->setType('PRIMARY KEY');
        static::assertFalse($constraint->isUnique());

        // Verify isUnique returns false for FOREIGN KEY
        $constraint->setType('FOREIGN KEY');
        static::assertFalse($constraint->isUnique());

        // Verify isUnique returns false for CHECK
        $constraint->setType('CHECK');
        static::assertFalse($constraint->isUnique());
    }

    #[Test]
    public function isUniqueReturnsTrueForUnique(): void
    {
        $constraint = new ConstraintObject('name', 'table', 'schema');

        // Verify isUnique returns true for UNIQUE type
        $constraint->setType('UNIQUE');
        static::assertTrue($constraint->isUnique());
    }

    #[Test]
    public function setCheckClauseAndGetCheckClauseWithFluentInterface(): void
    {
        $constraint = new ConstraintObject('name', 'table', 'schema');

        // Verify fluent interface and value update
        $result = $constraint->setCheckClause('age >= 18');
        static::assertSame($constraint, $result);
        static::assertSame('age >= 18', $constraint->getCheckClause());
    }

    #[Test]
    public function setColumnsAndGetColumnsWithFluentInterface(): void
    {
        $constraint = new ConstraintObject('name', 'table', 'schema');
        $columns    = ['column1', 'column2', 'column3'];

        // Verify fluent interface and value update
        $result = $constraint->setColumns($columns);
        static::assertSame($constraint, $result);
        static::assertSame($columns, $constraint->getColumns());
    }

    #[Test]
    public function setColumnsWithEmptyArray(): void
    {
        $constraint = new ConstraintObject('name', 'table', 'schema');
        $constraint->setColumns(['col1']);

        // Set empty array and verify hasColumns reflects change
        $constraint->setColumns([]);
        static::assertSame([], $constraint->getColumns());
        static::assertFalse($constraint->hasColumns());
    }

    #[Test]
    public function setDeleteRuleAndGetDeleteRuleWithFluentInterface(): void
    {
        $constraint = new ConstraintObject('name', 'table', 'schema');

        // Verify fluent interface and value update
        $result = $constraint->setDeleteRule('RESTRICT');
        static::assertSame($constraint, $result);
        static::assertSame('RESTRICT', $constraint->getDeleteRule());
    }

    #[Test]
    public function setMatchOptionAndGetMatchOptionWithFluentInterface(): void
    {
        $constraint = new ConstraintObject('name', 'table', 'schema');

        // Verify fluent interface and value update
        $result = $constraint->setMatchOption('FULL');
        static::assertSame($constraint, $result);
        static::assertSame('FULL', $constraint->getMatchOption());
    }

    #[Test]
    public function setNameAndGetName(): void
    {
        $constraint = new ConstraintObject('initial', 'table', 'schema');

        // Update name and verify change
        $constraint->setName('new_name');
        static::assertSame('new_name', $constraint->getName());
    }

    #[Test]
    public function setReferencedColumnsAndGetReferencedColumnsWithFluentInterface(): void
    {
        $constraint = new ConstraintObject('name', 'table', 'schema');
        $columns    = ['ref_col1', 'ref_col2'];

        // Verify fluent interface and value update
        $result = $constraint->setReferencedColumns($columns);
        static::assertSame($constraint, $result);
        static::assertSame($columns, $constraint->getReferencedColumns());
    }

    #[Test]
    public function setReferencedTableNameAndGetReferencedTableNameWithFluentInterface(): void
    {
        $constraint = new ConstraintObject('name', 'table', 'schema');

        // Verify fluent interface and value update
        $result = $constraint->setReferencedTableName('ref_table');
        static::assertSame($constraint, $result);
        static::assertSame('ref_table', $constraint->getReferencedTableName());
    }

    #[Test]
    public function setReferencedTableSchemaAndGetReferencedTableSchemaWithFluentInterface(): void
    {
        $constraint = new ConstraintObject('name', 'table', 'schema');

        // Verify fluent interface and value update
        $result = $constraint->setReferencedTableSchema('ref_schema');
        static::assertSame($constraint, $result);
        static::assertSame('ref_schema', $constraint->getReferencedTableSchema());
    }

    #[Test]
    public function setSchemaNameAndGetSchemaName(): void
    {
        $constraint = new ConstraintObject('name', 'table', 'initial_schema');

        // Update schema and verify change
        $constraint->setSchemaName('new_schema');
        static::assertSame('new_schema', $constraint->getSchemaName());
    }

    #[Test]
    public function setTableNameAndGetTableNameWithFluentInterface(): void
    {
        $constraint = new ConstraintObject('name', 'initial_table', 'schema');

        // Verify fluent interface and value update
        $result = $constraint->setTableName('new_table');
        static::assertSame($constraint, $result);
        static::assertSame('new_table', $constraint->getTableName());
    }

    #[Test]
    public function setTypeAndGetType(): void
    {
        $constraint = new ConstraintObject('name', 'table', 'schema');

        // Set type and verify retrieval
        $constraint->setType('PRIMARY KEY');
        static::assertSame('PRIMARY KEY', $constraint->getType());

        // Verify mutation to different type
        $constraint->setType('UNIQUE');
        static::assertSame('UNIQUE', $constraint->getType());
    }

    #[Test]
    public function setUpdateRuleAndGetUpdateRuleWithFluentInterface(): void
    {
        $constraint = new ConstraintObject('name', 'table', 'schema');

        // Verify fluent interface and value update
        $result = $constraint->setUpdateRule('CASCADE');
        static::assertSame($constraint, $result);
        static::assertSame('CASCADE', $constraint->getUpdateRule());
    }
}
