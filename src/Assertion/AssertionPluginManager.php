<?php

declare(strict_types=1);

namespace Lmc\Rbac\Assertion;

use Laminas\ServiceManager\AbstractPluginManager;
use Laminas\ServiceManager\Exception\InvalidServiceException;

class AssertionPluginManager extends AbstractPluginManager implements AssertionPluginManagerInterface
{
    /**
     * @param mixed $instance
     * @return void
     */
    public function validate(mixed $instance): void
    {
        if ($instance instanceof AssertionInterface) {
            return;
        }
        throw new InvalidServiceException(sprintf(
            'Assertions must implement "Lmc\Rbac\Assertion\AssertionInterface", but "%s" was given',
            get_class($instance)
        ));
    }

    /**
     * @param $name
     * @param array|null $options
     * @return AssertionInterface
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public function get($name, array $options = null): AssertionInterface
    {
        return parent::get($name, $options);
    }
}
