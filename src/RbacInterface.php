<?php

declare(strict_types=1);

namespace Lmc\Rbac;

use Lmc\Rbac\Permission\PermissionInterface;
use Lmc\Rbac\Role\RoleInterface;

interface RbacInterface
{
    /**
     * Determines if access is granted by checking the roles for permission.
     */
    public function isGranted(RoleInterface|iterable $roles, PermissionInterface|string $permission): bool;
}
