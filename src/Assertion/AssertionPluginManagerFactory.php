<?php

namespace Lmc\Rbac\Assertion;

use Laminas\ServiceManager\Factory\FactoryInterface;
use Psr\Container\ContainerInterface;

class AssertionPluginManagerFactory implements FactoryInterface
{

    /**
     * @inheritDoc
     */
    public function __invoke(ContainerInterface $container, $requestedName, ?array $options = null): AssertionPluginManager
    {
        $config = $container->get('config')['lmc_rbac']['assertion_manager'];

        return new AssertionPluginManager($container, $config);
    }
}
