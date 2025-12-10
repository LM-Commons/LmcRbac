---
title: Lmc\Rbac\Role\ObjectRepositoryRoleProvider
sidebar_position: 2
---

:::warning
Deprecated since v2.3
You should use `Lmc\Rbac\Role\Doctrine\ObjectRepositoryRoleProvider` instead
:::

### `Lmc\Rbac\Role\ObjectRepositoryRoleProvider` (built-in)

This builtin provider fetches roles from a database using
`Doctrine\Common\Persistence\ObjectRepository` interface.

You can configure this provider by giving an object repository service name that is fetched from the service manager
using the `object_repository` key:

```php
return [
    'lmc_rbac' => [
        'role_provider' => [
            Lmc\Rbac\Role\ObjectRepositoryRoleProvider::class => [
                'object_repository'  => 'App\Repository\RoleRepository',
                'role_name_property' => 'name'
            ],
        ],
    ],
];
```

Or you can specify the `object_manager` and `class_name` options:

```php
return [
    'lmc_rbac' => [
        'role_provider' => [
            Lmc\Rbac\Role\ObjectRepositoryRoleProvider::class => [
                'object_manager'     => 'doctrine.entitymanager.orm_default',
                'class_name'         => 'App\Entity\Role',
                'role_name_property' => 'name'
            ],
        ],
    ],
];
```

In both cases, you need to specify the `role_name_property` value, which is the name of the entity's property
that holds the actual role name. This is used internally to only load the identity roles, instead of loading
the whole table every time.

Please note that your entity fetched from the table MUST implement the `Laminas\Permissions\Rbac\RoleInterface` interface.

Sample ORM entity models are provided in the `/data` folder for flat role, hierarchical role and permission.

### Handling non existent roles

This provider assumes that all required roles are available in the database.

If the list of roles names to retrieve using this provider includes roles that are
not defined in the database, the role provider will throw an exception.

Therefore, extra care must be taken to ensure that the roles of an identity have
corresponsing roles defined in the database.
