<?php

declare(strict_types=1);

namespace Lmc\Rbac\Role;

use Laminas\Permissions\Rbac\RoleInterface;

interface RoleFactoryInterface
{
    public function createRole(string $roleName): RoleInterface;
}
