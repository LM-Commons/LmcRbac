<?php

namespace LmcRbac\Identity;

interface IdentityProviderInterface
{
    /**
     * Get the identity
     * @return IdentityInterface|null
     */
    public function getIdentity(): ?IdentityInterface;
}
