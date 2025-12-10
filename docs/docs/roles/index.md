---
sidebar_label: Roles, permissions and Role providers
title: Roles, Permissions and Role providers
sidebar_position: 4
---

## Roles

A role is an object that returns a list of permissions that the role has.

LmcRbac uses the Role class defined by [laminas-permissions-rbac](https://github.com/laminas/laminas-permissions-rbac). Roles
are defined using the `\Laminas\Permissions\Rbac\Role` class or by a class
implementing `\Laminas\Permissions\Rbac\RoleInterface`.

Roles can have child roles and therefore provides a hierarchy of roles where a role inherit the permissions of all its
child roles.

For example, a 'user' role may have the 'read' and 'write' permissions, and a 'admin' role
may inherit the permissions of the 'user' role plus an additional 'delete' role. In this structure,
the 'admin' role will have 'user' as its child role.


:::tip[Flat roles]
Previous version of LmcRbac used to make a distinction between flat roles and hierarchical roles.
A flat role is just a simplification of a hierarchical role, i.e. a hierarchical role without children.

In `laminas-permissions-rbac`, roles are hierarchical.
:::

## Permissions

A permission in `laminas-permissions-rbac` is simply a string that represents the permission such as 'read', 'write' or 'delete'.
But it can also be more precise like 'article.read' or 'article.write'.

A permission can also be an object as long as it can be cast to a string. This could be the
case, for example, when permissions are stored in a database where they could
also have a identifier and a description.

:::tip
An object can be cast to a string by implementing the `__toString()` method.
:::

## Role Service

LmcRbac provides a role service that will use a role providers to fetch the
roles and their permissions associated with a given identity.

It can be retrieved from the container be requesting the `Lmc\Rbac\Service\RoleServiceInterface` service.

`Lmc\Rbac\Service\RoleServiceInterface` defines the following method:

- `getIdentityRoles(object|null $identity = null): iterable`

| Parameter   | Description                                                                                                                                                                  |
|-------------|------------------------------------------------------------------------------------------------------------------------------------------------------------------------------|
| `$identity` | The identity whose roles to retrieve. <br/>If `$identity` is null, then the `guest` is used. <br/>The `guest` role is definable via configuration and defaults to `'guest'`. |

:::warning
The `$identity` parameter must be an object that either implements the `Lmc\Rbac\Identity\IdentityInterface`
interface or has a `getRoles()` method that returns an array of strings or an array of objects
implementing the `Laminas\Permissions\Rbac\RoleInterface` interface.


:::


## Role Providers
A role provider is an object that returns a list of roles. A role provider must implement the
`Lmc\Rbac\Role\RoleProviderInterface` interface. The only required method is `getRoles`, and must return an array
of `Laminas\Permissions\Rbac\RoleInterface` objects.

```php
use Laminas\Permissions\Rbac\RoleInterface;

interface RoleProviderInterface
{
    /**
     * Get the roles from the provider
     *
     * @param  string[] $roleNames
     * @return RoleInterface[]
     */
    public function getRoles(iterable $roleNames): iterable;
}
```

Roles can come from one of many sources: in memory, from a file, from a database, etc. However, you can specify only one role provider per application.

LmcRbac comes with two built-in role providers: 
- [`Lmc\Rbac\Role\InMemoryRoleProvider`](/docs/roles/in-memory-provider)
- [`Lmc\Rbac\Role\ObjectRepositoryRoleProvider`](/docs/roles/object-repository-role-provider). **(deprecated as of v2.3)**

A role provider must be added to the `role_provider` subkey in the
configuration file. For example:

```php
return [
    'lmc_rbac' => [
        'role_provider' => [
            Lmc\Rbac\Role\InMemoryRoleProvider::class => [
                // configuration
            ],
        ]
    ]
];
```
