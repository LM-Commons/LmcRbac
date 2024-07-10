<?php

declare(strict_types=1);

namespace LmcRbac\Identity;

use Laminas\Authentication\AuthenticationService;
use Laminas\ServiceManager\Factory\FactoryInterface;
use Psr\Container\ContainerInterface;

/**
 * Factory to create the authentication identity provide
 * @author Eric Richer <eric.richer@vistoconsulting.com>
 */
class AuthenticationIdentityProviderFactory implements FactoryInterface
{
    /**
     * @inheritDoc
     */
    public function __invoke(ContainerInterface $container, $requestedName, ?array $options = null): AuthenticationIdentityProvider
    {
        // Get the Authentication provider
        return new AuthenticationIdentityProvider($container->get(AuthenticationService::class));

    }
}
