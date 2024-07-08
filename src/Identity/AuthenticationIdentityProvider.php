<?php

declare(strict_types=1);

namespace LmcRbac\Identity;

use Laminas\Authentication\AuthenticationServiceInterface;

class AuthenticationIdentityProvider implements IdentityProviderInterface
{
    public function __construct(
        protected AuthenticationServiceInterface $authenticationService
    ) {
    }

    /**
     * @inheritDoc
     */
    public function getIdentity(): ?IdentityInterface
    {
        return $this->authenticationService->getIdentity();
    }
}
