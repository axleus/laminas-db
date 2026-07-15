<?php

declare(strict_types=1);

namespace PhpDbTest\Container;

use Laminas\ServiceManager\ServiceManager;
use PhpDb\Container\TableIdentifierFactoryFactory;
use PhpDb\Sql\TableIdentifierFactory;
use PHPUnit\Framework\Attributes\CoversMethod;
use PHPUnit\Framework\Attributes\Group;
use PHPUnit\Framework\TestCase;

#[Group('unit')]
#[CoversMethod(TableIdentifierFactoryFactory::class, '__invoke')]
final class TableIdentifierFactoryFactoryTest extends TestCase
{
    public function testInvokeCreatesFactoryWithoutPrefixWhenContainerHasNoConfig(): void
    {
        $container = new ServiceManager();

        $factory = new TableIdentifierFactoryFactory();
        $result  = $factory($container);

        self::assertNull($result->getPrefix());
    }

    public function testInvokeCreatesFactoryWithoutPrefixWhenConfigIsEmpty(): void
    {
        $container = new ServiceManager();
        $container->setService('config', []);

        $factory = new TableIdentifierFactoryFactory();
        $result  = $factory($container);

        self::assertNull($result->getPrefix());
    }

    public function testInvokeCreatesFactoryWithConfiguredPrefix(): void
    {
        $container = new ServiceManager();
        $container->setService('config', [
            TableIdentifierFactory::class => [
                'prefix' => 'backup',
            ],
        ]);

        $factory = new TableIdentifierFactoryFactory();
        $result  = $factory($container);

        self::assertSame('backup', $result->getPrefix());
        self::assertSame('backup_users', $result('users')->getTable());
    }

    public function testInvokeCreatesFactoryWithConfiguredSeparator(): void
    {
        $container = new ServiceManager();
        $container->setService('config', [
            TableIdentifierFactory::class => [
                'prefix'    => 'backup',
                'separator' => '__',
            ],
        ]);

        $factory = new TableIdentifierFactoryFactory();
        $result  = $factory($container);

        self::assertSame('__', $result->getSeparator());
        self::assertSame('backup__users', $result('users')->getTable());
    }

    public function testInvokeCreatesFactoryWithoutPrefixWhenPrefixKeyIsAbsent(): void
    {
        $container = new ServiceManager();
        $container->setService('config', [
            TableIdentifierFactory::class => [],
        ]);

        $factory = new TableIdentifierFactoryFactory();
        $result  = $factory($container);

        self::assertNull($result->getPrefix());
    }
}
