<?php

/*
 * THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS
 * "AS IS" AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT
 * LIMITED TO, THE IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS FOR
 * A PARTICULAR PURPOSE ARE DISCLAIMED. IN NO EVENT SHALL THE COPYRIGHT
 * OWNER OR CONTRIBUTORS BE LIABLE FOR ANY DIRECT, INDIRECT, INCIDENTAL,
 * SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES (INCLUDING, BUT NOT
 * LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES; LOSS OF USE,
 * DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER CAUSED AND ON ANY
 * THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY, OR TORT
 * (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF THE USE
 * OF THIS SOFTWARE, EVEN IF ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.
 *
 * This software consists of voluntary contributions made by many individuals
 * and is licensed under the MIT license.
 */

declare(strict_types=1);

namespace LmcRbac\Service;

use LmcRbac\Identity\IdentityInterface;
use LmcRbac\Identity\IdentityProviderInterface;
use LmcRbac\Role\RoleInterface;
use LmcRbac\Role\RoleProviderInterface;
use Traversable;

/**
 * Role service
 *
 * @author  Michaël Gallego <mic.gallego@gmail.com>
 * @licence MIT
 */
class RoleService implements RoleServiceInterface
{
    protected IdentityProviderInterface $identityProvider;

    protected RoleProviderInterface $roleProvider;

    protected string $guestRole = '';

    public function __construct(
        IdentityProviderInterface $identityProvider,
        RoleProviderInterface $roleProvider,
        string $guestRole
    ) {
        $this->identityProvider = $identityProvider;
        $this->roleProvider = $roleProvider;
        $this->guestRole = $guestRole;
    }

    /**
     * Get the current identity from the identity provider
     *
     * @return IdentityInterface|null
     */
    public function getIdentity(): ?IdentityInterface
    {
        return $this->identityProvider->getIdentity();
    }

    /**
     * Get the identity roles from the current identity, applying some more logic
     *
     * @param IdentityInterface|null $identity
     * @param mixed|null $context
     * @return RoleInterface[]
     */
    public function getIdentityRoles(IdentityInterface $identity = null, mixed $context = null): iterable
    {
        // If no identity is provided, get it from the identity provider
        if (null === $identity) {
            $identity = $this->identityProvider->getIdentity();
            if (null === $identity) {
                return $this->convertRoles([$this->guestRole]);
            }
        }

        return $this->convertRoles($identity->getRoles());
    }

    /**
     * Convert the roles (potentially strings) to concrete RoleInterface objects using role provider
     *
     * @param  array|Traversable $roles
     * @return RoleInterface[]
     */
    private function convertRoles(iterable $roles): iterable
    {
        $collectedRoles = [];
        $toCollect = [];

        foreach ($roles as $role) {
            // If it's already a RoleInterface, nothing to do as a RoleInterface contains everything already
            if ($role instanceof RoleInterface) {
                $collectedRoles[] = $role;
                continue;
            }

            // Otherwise, it's a string and hence we need to collect it
            $toCollect[] = (string) $role;
        }

        // Nothing to collect, we don't even need to hit the (potentially) costly role provider
        if (empty($toCollect)) {
            return $collectedRoles;
        }

        return array_merge($collectedRoles, $this->roleProvider->getRoles($toCollect));
    }
}
