<?php

namespace Lmc\Rbac;

use Lmc\Rbac\Permission\PermissionInterface;
use Lmc\Rbac\Role\RoleInterface;
use Traversable;

interface RbacInterface
{
    /**
     * Determines if access is granted by checking the roles for permission.
     *
     * @param iterable|RoleInterface $roles
     * @param PermissionInterface|string $permission
     * @return bool
     */
    public function isGranted(RoleInterface|iterable $roles, PermissionInterface|string $permission): bool;

}
