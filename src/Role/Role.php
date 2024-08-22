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

namespace Lmc\Rbac\Role;

/**
 * Simple implementation for a role without hierarchy
 * and using strings as permissions
 */
class Role implements RoleInterface
{
    private string $name;

    /** @var string[] */
    private array $permissions = [];

    /** @var array|RoleInterface[] */
    private array $children = [];

    public function __construct(string $name)
    {
        $this->name = $name;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getPermissions(): array
    {
        return $this->permissions;
    }

    public function addPermission(string $permission): void
    {
        $this->permissions[$permission] = $permission;
    }

    public function hasPermission(string $permission): bool
    {
        if (isset($this->permissions[$permission])) {
            return true;
        }

        foreach ($this->children as $child) {
            if ($child->hasPermission($permission)) {
                return true;
            }
        }

        return false;
    }

    public function hasChildren(): bool
    {
        return ! empty($this->children);
    }

    public function getChildren(): iterable
    {
        return $this->children;
    }

    public function addChild(RoleInterface $role): void
    {
        $this->children[$role->getName()] = $role;
    }
}
