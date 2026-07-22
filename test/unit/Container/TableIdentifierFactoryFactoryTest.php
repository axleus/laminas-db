<?php

declare(strict_types=1);

namespace PhpDbTest\Container;

use Laminas\ServiceManager\ServiceManager;
use PhpDb\Container\TableIdentifierFactoryFactory;
use PhpDb\Sql\Exception\InvalidArgumentException;
use PhpDb\Sql\TableIdentifierFactory;
use PHPUnit\Framework\Attributes\CoversMethod;
use PHPUnit\Framework\Attributes\Group;
use PHPUnit\Framework\TestCase;
use Psr\Container\ContainerInterface;

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
    }

    public function testInvokeCreatesFactoryWithoutPrefixWhenConfigServiceIsNull(): void
    {
        $container = $this->createMock(ContainerInterface::class);
        $container->method('has')->with('config')->willReturn(true);
        $container->method('get')->with('config')->willReturn(null);

        $factory = new TableIdentifierFactoryFactory();
        $result  = $factory($container);

        self::assertNull($result->getPrefix());
    }

    public function testInvokeCreatesFactoryWithConfiguredSeparatorWithoutPrefix(): void
    {
        $container = new ServiceManager();
        $container->setService('config', [
            TableIdentifierFactory::class => [
                'separator' => '__',
            ],
        ]);

        $factory = new TableIdentifierFactoryFactory();
        $result  = $factory($container);

        self::assertNull($result->getPrefix());
        self::assertSame('__', $result->getSeparator());
    }

    public function testInvokeUsesDefaultSeparatorWhenSeparatorKeyIsAbsent(): void
    {
        $container = new ServiceManager();
        $container->setService('config', [
            TableIdentifierFactory::class => [
                'prefix' => 'backup',
            ],
        ]);

        $factory = new TableIdentifierFactoryFactory();
        $result  = $factory($container);

        self::assertSame('_', $result->getSeparator());
    }

    public function testInvokeRejectsEmptyStringSeparatorFromConfig(): void
    {
        $container = new ServiceManager();
        $container->setService('config', [
            TableIdentifierFactory::class => [
                'separator' => '',
            ],
        ]);

        $factory = new TableIdentifierFactoryFactory();

        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('$separator must be a valid table separator, empty string given');
        $factory($container);
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
