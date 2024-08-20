<?php

declare(strict_types=1);

namespace Lmc\Rbac\Permission;

/**
 * Interface that permissions must implement to be used with services using permissions
 */

interface PermissionInterface
{
    /**
     * Get the permission name
     */
    public function __toString(): string;
}
