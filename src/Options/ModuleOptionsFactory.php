<?php

declare(strict_types=1);

namespace Lmc\Rbac\Options;

use Laminas\ServiceManager\Exception\ServiceNotCreatedException;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\ContainerInterface;
use Psr\Container\NotFoundExceptionInterface;

use function is_array;
use function PHPUnit\Framework\assertIsArray;

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

        assertIsArray($config['lmc_rbac']);
        return new ModuleOptions($config['lmc_rbac']);
    }
}
