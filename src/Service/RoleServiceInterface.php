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
use LmcRbac\Role\RoleInterface;

/**
 * Role service
 *
 * @author  Michaël Gallego <mic.gallego@gmail.com>
 * @licence MIT
 */
interface RoleServiceInterface
{
    /**
     * Get the identity roles from the current identity, applying some more logic
     *
     * @param null|IdentityInterface $identity
     * @param mixed|null $context
     * @return RoleInterface[]
     */
    public function getIdentityRoles(IdentityInterface $identity = null, mixed $context = null): iterable;

    /**
     * Get the current identity from the identity provider
     *
     * @return IdentityInterface|null
     */
    public function getIdentity(): ?IdentityInterface;

    /**
     * Check if the given roles match one of the identity's roles
     * @param RoleInterface[] $roles
     * @param IdentityInterface|null $identity
     * @return bool
     */
    public function matchIdentityRoles(array $roles, IdentityInterface $identity = null): bool;

}
