<?php

declare(strict_types=1);

namespace Lmc\Rbac\Assertion;

use Laminas\ServiceManager\AbstractPluginManager;
use Laminas\ServiceManager\Exception\InvalidServiceException;

use function sprintf;

final class AssertionPluginManager extends AbstractPluginManager implements AssertionPluginManagerInterface
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
}
