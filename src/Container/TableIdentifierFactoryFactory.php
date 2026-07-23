<?php

declare(strict_types=1);

namespace PhpDb\Container;

use PhpDb\Sql\TableIdentifier;
use PhpDb\Sql\TableIdentifierFactory;
use Psr\Container\ContainerInterface;

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
