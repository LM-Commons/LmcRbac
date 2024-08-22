<?php

declare(strict_types=1);

namespace Lmc\Rbac;

use Lmc\Rbac\Role\RoleInterface;

interface RbacInterface
{
    /**
     * Determines if access is granted by checking the roles for permission.
     */
    public function isGranted(RoleInterface|iterable $roles, string $permission): bool;
}
