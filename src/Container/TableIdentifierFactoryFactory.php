<?php

declare(strict_types=1);

namespace PhpDb\Container;

use PhpDb\Sql\Exception\InvalidArgumentException;
use PhpDb\Sql\TableIdentifier;
use PhpDb\Sql\TableIdentifierFactory;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\ContainerInterface;
use Psr\Container\NotFoundExceptionInterface;

/**
 * Creates a {@see TableIdentifierFactory} configured from the application
 * config service.
 *
 * Expected configuration:
 *
 * <code>
 * return [
 *     TableIdentifierFactory::class => [
 *         'prefix'    => 'backup',
 *         'separator' => '_',
 *     ],
 * ];
 * </code>
 *
 * When no configuration is present the factory is created without a prefix.
 * The separator defaults to '_' when not configured.
 */
final class TableIdentifierFactoryFactory
{
    /**
     * @throws InvalidArgumentException If the configured prefix or separator is an empty string.
     * @throws NotFoundExceptionInterface If the config service cannot be resolved.
     * @throws ContainerExceptionInterface If retrieving the config service fails.
     */
    public function __invoke(ContainerInterface $container): TableIdentifierFactory
    {
        /** @var array<string, mixed> $config */
        $config = $container->has('config') ? $container->get('config') ?? [] : [];

        /** @var array{prefix?: string|null, separator?: string} $factoryConfig */
        $factoryConfig = $config[TableIdentifierFactory::class] ?? [];

        return new TableIdentifierFactory(
            $factoryConfig['prefix'] ?? null,
            $factoryConfig['separator'] ?? TableIdentifier::SEPARATOR,
        );
    }
}
