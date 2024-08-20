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

namespace Lmc\Rbac\Service;

use Lmc\Rbac\Assertion\AssertionInterface;
use Lmc\Rbac\Assertion\AssertionPluginManagerInterface;
use Lmc\Rbac\Assertion\AssertionSet;
use Lmc\Rbac\Identity\IdentityInterface;
use Lmc\Rbac\Permission\PermissionInterface;
use Lmc\Rbac\RbacInterface;

use function array_merge;
use function is_array;

/**
 * Authorization service is a simple service that internally uses Rbac to check if identity is
 * granted a permission
 */
class AuthorizationService implements AuthorizationServiceInterface
{
    protected RbacInterface $rbac;

    protected RoleServiceInterface $roleService;

    private AssertionPluginManagerInterface $assertionPluginManager;

    /** @var array */
    private array $assertions;

    public function __construct(
        RbacInterface $rbac,
        RoleServiceInterface $roleService,
        AssertionPluginManagerInterface $assertionPluginManager,
        array $assertions = []
    ) {
        $this->rbac                   = $rbac;
        $this->roleService            = $roleService;
        $this->assertionPluginManager = $assertionPluginManager;
        $this->assertions             = $assertions;
    }

    /**
     * Set assertions, either merging or replacing (default)
     *
     * @param array $assertions
     */
    public function setAssertions(array $assertions, bool $merge = false): void
    {
        $this->assertions = $merge ?
            array_merge($this->assertions, $assertions) :
            $assertions;
    }

    /**
     * Set assertion for a given permission
     */
    public function setAssertion(
        PermissionInterface|string $permission,
        AssertionInterface|callable|string $assertion
    ): void {
        $this->assertions[(string) $permission] = $assertion;
    }

    /**
     * Check if there are assertions for the permission
     */
    public function hasAssertion(PermissionInterface|string $permission): bool
    {
        return isset($this->assertions[(string) $permission]);
    }

    /**
     * Get the assertions
     *
     * @return array
     */
    public function getAssertions(): array
    {
        return $this->assertions;
    }

    /**
     * Get the assertions for the given permission
     */
    public function getAssertion(PermissionInterface|string $permission): AssertionInterface|callable|string|null
    {
        return $this->hasAssertion($permission) ? $this->assertions[(string) $permission] : null;
    }

    public function isGranted(
        IdentityInterface|null $identity,
        string|PermissionInterface $permission,
        mixed $context = null
    ): bool {
        $roles = $this->roleService->getIdentityRoles($identity, $context);

        if (empty($roles)) {
            return false;
        }

        if (! $this->rbac->isGranted($roles, $permission)) {
            return false;
        }

        if (empty($this->assertions[(string) $permission])) {
            return true;
        }

        if (is_array($this->assertions[(string) $permission])) {
            $permissionAssertions = $this->assertions[(string) $permission];
        } else {
            $permissionAssertions = [$this->assertions[(string) $permission]];
        }

        $assertionSet = new AssertionSet($this->assertionPluginManager, $permissionAssertions);

        return $assertionSet->assert($permission, $identity, $context);
    }
}
