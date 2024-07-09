<?php

namespace LmcRbac\Permission;

/**
 * Interface that permissions must implement to be used with services using permissions
 * @author Eric Richer <eric.richer@vistoconsulting.com>
 */

interface PermissionInterface
{
    /**
     * Get the permission name
     * @return string
     */
    public function __toString(): string;
}
