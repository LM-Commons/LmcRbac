<?php

namespace LmcRbac;

use LmcRbac\Role\RoleInterface;
use Traversable;

interface RbacInterface
{
    /**
     * Determines if access is granted by checking the roles for permission.
     *
     * @param Traversable|RoleInterface|RoleInterface[] $roles
     * @param  string                                    $permission
     * @return bool
     */
    public function isGranted(RoleInterface|Traversable|array $roles, string $permission): bool;

}
