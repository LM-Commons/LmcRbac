<?php

declare(strict_types=1);

namespace Lmc\Rbac\Service;

use Laminas\ServiceManager\Factory\DelegatorFactoryInterface;
use Lmc\Rbac\Exception\ServiceNotCreatedException;
use Psr\Container\ContainerInterface;

use function call_user_func;

class AuthorizationServiceDelegatorFactory implements DelegatorFactoryInterface
{
    /**
     * @inheritDoc
     */
    public function __invoke(
        ContainerInterface $container,
        $name,
        callable $callback,
        ?array $options = null
    ): AuthorizationServiceAwareInterface {
        $instance = call_user_func($callback);
        if (! $instance instanceof AuthorizationServiceAwareInterface) {
            throw new ServiceNotCreatedException("The service $name must implement 
            Laminas\Authorization\Service\AuthorizationServiceAwareInterface");
        }

        $authorizationService = $container->get(AuthorizationServiceInterface::class);
        $instance->setAuthorizationService($authorizationService);
        return $instance;
    }
}
