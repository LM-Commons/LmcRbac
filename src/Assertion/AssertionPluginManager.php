<?php

declare(strict_types=1);

namespace Lmc\Rbac\Assertion;

use Laminas\ServiceManager\AbstractPluginManager;
use Laminas\ServiceManager\Exception\InvalidServiceException;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;

use function sprintf;

class AssertionPluginManager extends AbstractPluginManager implements AssertionPluginManagerInterface
{
    public function validate(mixed $instance): void
    {
        if ($instance instanceof AssertionInterface) {
            return;
        }
        throw new InvalidServiceException(sprintf(
            'Assertions must implement "Lmc\Rbac\Assertion\AssertionInterface", but "%s" was given',
            $instance::class
        ));
    }

    /**
     * @param string $name
     * @param array|null $options
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function get($name, ?array $options = null): AssertionInterface
    {
        return parent::get($name, $options);
    }
}
