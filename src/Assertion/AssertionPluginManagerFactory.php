<?php

namespace Lmc\Rbac\Assertion;

use Laminas\ServiceManager\Factory\FactoryInterface;
use Lmc\Rbac\Options\ModuleOptions;
use Psr\Container\ContainerInterface;

class AssertionPluginManagerFactory implements FactoryInterface
{

    /**
     * @inheritDoc
     */
    public function __invoke(ContainerInterface $container, $requestedName, ?array $options = null): AssertionPluginManager
    {
        /** @var ModuleOptions $config */
        $config = $container->get(ModuleOptions::class);

        return new AssertionPluginManager($container, $config->getAssertionManager());
    }
}
