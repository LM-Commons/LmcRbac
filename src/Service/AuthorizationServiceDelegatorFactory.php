<?php

declare(strict_types=1);

namespace Lmc\Rbac\Service;

use Lmc\Rbac\Exception\ServiceNotCreatedException;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\ContainerInterface;
use Psr\Container\NotFoundExceptionInterface;

use function call_user_func;

class AuthorizationServiceDelegatorFactory
{
    /**
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function __invoke(
        ContainerInterface $container,
        string $name,
        callable $callback
    ): AuthorizationServiceAwareInterface {
        $instance = call_user_func($callback);
        if (! $instance instanceof AuthorizationServiceAwareInterface) {
            throw new ServiceNotCreatedException("The service $name must implement 
            Laminas\Authorization\Service\AuthorizationServiceAwareInterface");
        }
        /** @var AuthorizationServiceInterface $authorizationService */
        $authorizationService = $container->get(AuthorizationServiceInterface::class);
        $instance->setAuthorizationService($authorizationService);
        return $instance;
    }
}
