<?php

declare(strict_types=1);

namespace Lmc\Rbac\Assertion;

use Lmc\Rbac\Options\ModuleOptions;
use Psr\Container\ContainerInterface;

final class AssertionPluginManagerFactory
{
    public function __invoke(ContainerInterface $container): AssertionPluginManager
    {
        /** @var ModuleOptions $config */
        $config = $container->get(ModuleOptions::class);

        /** @psalm-suppress MixedArgumentTypeCoercion */
        return new AssertionPluginManager($container, $config->getAssertionManager());
    }
}
