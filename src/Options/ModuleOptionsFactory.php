<?php

declare(strict_types=1);

namespace Lmc\Rbac\Options;

use Lmc\Rbac\Exception\ServiceNotCreatedException;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\ContainerInterface;
use Psr\Container\NotFoundExceptionInterface;

use function assert;
use function is_array;

/**
 * Factory for the module options
 */
class ModuleOptionsFactory
{
    /**
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function __invoke(ContainerInterface $container): ModuleOptions
    {
        $config = $container->get('config');

        if (! isset($config['lmc_rbac']) || ! is_array($config['lmc_rbac'])) {
            throw new ServiceNotCreatedException('No lmc_rbac config found.');
        }

        assert(is_array($config['lmc_rbac']));
        return new ModuleOptions($config['lmc_rbac']);
    }
}
