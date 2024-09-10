---
sidebar_label: Roles, permissions and Role providers
title: Roles, Permissions and Role providers
sidebar_position: 4
---

## Roles

A role is an object that returns a list of permissions that the role has.

LmcRbac uses the Role class defined by [laminas-permissions-rbac](https://github.com/laminas/laminas-permissions-rbac).

Roles are defined using by the `\Laminas\Permissions\Rbac\Role` class or by a class
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

A permission can also be an object as long as it can be casted to a string. This could be the
case, for example, when permissions are stored in a database where they could also have a identified and a description.

:::tip
An object can be casted to a string by implementing the `__toString()` method.
:::

## Role Providers
A role provider is an object that returns a list of roles. A role provider must implement the
`Lmc\Rbac\Role\RoleProviderInterface` interface. The only required method is `getRoles`, and must return an array
of `Laminas\Permissions\Rbac\RoleInterface` objects.

Roles can come from one of many sources: in memory, from a file, from a database, etc. However, you can specify only one role provider per application.

### Built-in role providers

LmcRbac comes with two built-in role providers: `Lmc\Rbac\Role\InMemoryRoleProvider` and 
`Lmc\Rbac\Role\ObjectRepositoryRoleProvider`. A role provider must be added to the `role_provider` subkey in the 
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

### `Lmc\Rbac\Role\InMemoryRoleProvider`

This provider is ideal for small/medium sites with few roles/permissions. All the data is specified in a simple associative array in a
PHP file.

Here is an example of the format you need to use:

```php
return [
    'lmc_rbac' => [
        'role_provider' => [
            Lmc\Rbac\Role\InMemoryRoleProvider::class => [
                'admin' => [
                    'children'    => ['member'],
                    'permissions' => ['article.delete']
                ],
                'member' => [
                    'children'    => ['guest'],
                    'permissions' => ['article.edit', 'article.archive']
                ],
                'guest' => [
                    'permissions' => ['article.read']
                ],
            ],
        ],
    ],
];
```

The `children` and `permissions` subkeys are entirely optional. Internally, the `Lmc\Rbac\Role\InMemoryRoleProvider` creates
`Lmc\Rbac\Role\Role` objects with children, if any.

If you are more confident with flat RBAC, the previous config can be re-written to remove any inheritence between roles:

```php
return [
    'lmc_rbac' => [
        'role_provider' => [
            Lmc\Rbac\Role\InMemoryRoleProvider::class => [
                'admin' => [
                    'permissions' => [
                        'article.delete',
                        'article.edit',
                        'article.archive',
                        'article.read'
                    ]
                ],
                'member' => [
                    'permissions' => [
                        'article.edit',
                        'article.archive',
                        'article.read'
                    ]
                ],
                'guest' => [
                    'permissions' => ['article.read']
                ]
            ]
        ]
    ]
];
```

### `Lmc\Rbac\Role\ObjectRepositoryRoleProvider`

This provider fetches roles from a database using `Doctrine\Common\Persistence\ObjectRepository` interface.

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

Please note that your entity fetched from the table MUST implement the `Lmc\Rbac\Role\RoleInterface` interface.

Sample ORM entity models are provided in the `/data` folder for flat role, hierarchical role and permission.

## Creating custom role providers

To create a custom role provider, you first need to create a class that implements the 
`Lmc\Rbac\Role\RoleProviderInterface` interface.

Then, you need to add it to the role provider manager:

```php
return [
    'lmc_rbac' => [
        'role_provider' => [
            MyCustomRoleProvider::class => [
                // Options
            ],
        ],
    ],
];
```
And the role provider is created using the service manager:
```php
return [
    'service_manager' => [
        'factories' => [
            MyCustomRoleProvider::class => MyCustomRoleProviderFactory::class,
        ],
    ],
];
```

## Role Service

LmcRbac provides a role service that will use the Role Providers to provide the roles
associated with a given identity.

It can be retrieved from the container be requesting the `Lmc\Rbac\Service\RoleServiceIntgeface`.

`Lmc\Rbac\Service\RoleServiceInterface` defines the following method:

- `getIdentityRoles(?IdentityInterface $identity = null): iterable`

  | Parameter                                                           | Description                                                                                                                                                                        |
  |----------------|------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------|
  | `$identity` | The identity whose roles to retrieve. <br/>If `$identity` is null, then the `guest` is used. <br/>The `guest` role is definable via configuration and defaults to `'guest'`. |


