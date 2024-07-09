<?php

namespace LmcRbac;

use LmcRbac\Permission\PermissionInterface;
use LmcRbac\Role\RoleInterface;
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
