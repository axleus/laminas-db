<?php

declare(strict_types=1);

namespace PhpDbTest\Sql;

use PhpDb\Sql\Exception\InvalidArgumentException;
use PhpDb\Sql\TableIdentifier;
use PhpDbTest\TestAsset\ObjectToString;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Group;
use PHPUnit\Framework\TestCase;
use stdClass;
use TypeError;

use function array_merge;

/**
 * Tests for {@see TableIdentifier}
 */
#[CoversClass(TableIdentifier::class)]
#[Group('unit')]
class TableIdentifierTest extends TestCase
{
    public function testGetTable(): void
    {
        $tableIdentifier = new TableIdentifier('foo');

        self::assertSame('foo', $tableIdentifier->getTable());
    }

    public function testGetDefaultSchema(): void
    {
        $tableIdentifier = new TableIdentifier('foo');

        self::assertNull($tableIdentifier->getSchema());
    }

    public function testGetSchema(): void
    {
        $tableIdentifier = new TableIdentifier('foo', 'bar');

        self::assertSame('bar', $tableIdentifier->getSchema());
    }

    public function testGetTableFromObjectStringCast(): void
    {
        $table           = new ObjectToString('castResult');
        $tableIdentifier = new TableIdentifier((string) $table);

        self::assertSame('castResult', $tableIdentifier->getTable());
        self::assertSame('castResult', $tableIdentifier->getTable());
    }

    /**
     * @todo Review test to see if relevant?
     */
    public function testGetSchemaFromObjectStringCast(): void
    {
        $schema          = new ObjectToString('castResult');
        $tableIdentifier = new TableIdentifier('foo', (string) $schema);

        self::assertSame('castResult', $tableIdentifier->getSchema());
        self::assertSame('castResult', $tableIdentifier->getSchema());
    }

    public function testGetDefaultPrefix(): void
    {
        $tableIdentifier = new TableIdentifier('foo');

        self::assertNull($tableIdentifier->getPrefix());
    }

    public function testGetPrefix(): void
    {
        $tableIdentifier = new TableIdentifier('foo', null, 'backup');

        self::assertSame('backup', $tableIdentifier->getPrefix());
    }

    public function testGetDefaultSeparator(): void
    {
        $tableIdentifier = new TableIdentifier('foo');

        self::assertSame('_', $tableIdentifier->getSeparator());
    }

    public function testGetSeparator(): void
    {
        $tableIdentifier = new TableIdentifier('foo', null, 'backup', '__');

        self::assertSame('__', $tableIdentifier->getSeparator());
    }

    public function testGetTableAppliesPrefixWithDefaultSeparator(): void
    {
        $tableIdentifier = new TableIdentifier('foo', null, 'backup');

        self::assertSame('backup_foo', $tableIdentifier->getTable());
    }

    public function testGetTableAppliesPrefixWithCustomSeparator(): void
    {
        $tableIdentifier = new TableIdentifier('foo', null, 'backup', '__');

        self::assertSame('backup__foo', $tableIdentifier->getTable());
    }

    public function testGetTableAppliesPrefixWithEmptySeparator(): void
    {
        $tableIdentifier = new TableIdentifier('foo', null, 'backup', '');

        self::assertSame('backupfoo', $tableIdentifier->getTable());
    }

    public function testGetTableIgnoresSeparatorWithoutPrefix(): void
    {
        $tableIdentifier = new TableIdentifier('foo', null, null, '__');

        self::assertSame('foo', $tableIdentifier->getTable());
    }

    public function testGetUnprefixedTableReturnsTableAsGiven(): void
    {
        $tableIdentifier = new TableIdentifier('foo', null, 'backup');

        self::assertSame('foo', $tableIdentifier->getUnprefixedTable());
    }

    public function testGetTableAndSchemaAppliesPrefix(): void
    {
        $tableIdentifier = new TableIdentifier('foo', 'bar', 'backup');

        self::assertSame(['backup_foo', 'bar'], $tableIdentifier->getTableAndSchema());
    }

    public function testGetTableAndSchemaWithoutPrefix(): void
    {
        $tableIdentifier = new TableIdentifier('foo', 'bar');

        self::assertSame(['foo', 'bar'], $tableIdentifier->getTableAndSchema());
    }

    #[DataProvider('invalidTableProvider')]
    public function testRejectsInvalidTable(mixed $invalidTable): void
    {
        $this->expectException($invalidTable === '' ? InvalidArgumentException::class : TypeError::class);
        /** @psalm-suppress MixedArgument */
        new TableIdentifier($invalidTable);
    }

    #[DataProvider('invalidNameArgumentProvider')]
    public function testRejectsInvalidSchema(mixed $invalidSchema): void
    {
        $this->expectException($invalidSchema === '' ? InvalidArgumentException::class : TypeError::class);
        /** @psalm-suppress MixedArgument */
        new TableIdentifier('foo', $invalidSchema);
    }

    #[DataProvider('invalidNameArgumentProvider')]
    public function testRejectsInvalidPrefix(mixed $invalidPrefix): void
    {
        $this->expectException($invalidPrefix === '' ? InvalidArgumentException::class : TypeError::class);
        /** @psalm-suppress MixedArgument */
        new TableIdentifier('foo', 'bar', $invalidPrefix);
    }

    /**
     * Data provider
     *
     * @return array[]
     */
    public static function invalidTableProvider(): array
    {
        return array_merge(
            ['null' => [null]],
            self::invalidNameArgumentProvider()
        );
    }

    /**
     * Data provider
     *
     * @return array[]
     */
    public static function invalidNameArgumentProvider(): array
    {
        return [
            'empty string' => [''],
            'object'       => [new stdClass()],
            'array'        => [[]],
        ];
    }
}
