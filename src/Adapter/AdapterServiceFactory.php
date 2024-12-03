<?php

namespace Laminas\Db\Adapter;

use Laminas\ServiceManager\Factory\FactoryInterface;
use Laminas\ServiceManager\ServiceLocatorInterface;
use Psr\Container\ContainerInterface;

class AdapterServiceFactory implements FactoryInterface
{
    /**
     * Create db adapter service
     *
     * @param string $requestedName
     * @param array $options
     * @return Adapter
     */
    public function __invoke(ContainerInterface $container, $requestedName, ?array $options = null)
    {
        $config = $container->get('config');
        return new Adapter($config['db']);
    }

    /**
     * Create db adapter service (v2)
     *
     * @return Adapter
     */
    public function createService(ServiceLocatorInterface $container)
    {
        return $this($container, Adapter::class);
    }
}
