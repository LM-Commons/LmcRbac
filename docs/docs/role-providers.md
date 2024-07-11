---
sidebar_label: Role providers
title: Role providers
sidebar_position: 4
---

A role provider is an object that returns a list of roles. A role provider must implement the
`LmcRbac\Role\RoleProviderInterface` interface. The only required method is `getRoles`, and must return an array
of `LmcRbac\Role\RoleInterface` objects.

Roles can come from one of many sources: in memory, from a file, from a database, etc. However, you can specify only one role provider per application.

## Built-in role providers

LmcRbac comes with two built-in role providers: `LmcRbac\Role\InMemoryRoleProvider` and `LmcRbac\Role\ObjectRepositoryRoleProvider`. A role
provider must be added to the `role_provider` subkey in the configuration file:

```php
return [
    'lmc_rbac' => [
        'role_provider' => [
            // Role provider config here!
        ]
    ]
];
```

### `LmcRbac\Role\InMemoryRoleProvider`

This provider is ideal for small/medium sites with few roles/permissions. All the data is specified in a simple associative array in a
PHP file.

Here is an example of the format you need to use:

```php
return [
    'lmc_rbac' => [
        'role_provider' => [
            'LmcRbac\Role\InMemoryRoleProvider' => [
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

The `children` and `permissions` subkeys are entirely optional. Internally, the `LmcRbac\Role\InMemoryRoleProvider` creates
either a `LmcRbac\Role\Role` object if the role does not have any children, or a `LmcRbac\Role\HierarchicalRole` if
the role has at least one child.

If you are more confident with flat RBAC, the previous config can be re-written to remove any inheritence between roles:

```php
return [
    'lmc_rbac' => [
        'role_provider' => [
            'LmcRbac\Role\InMemoryRoleProvider' => [
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

### `LmcRbac\Role\ObjectRepositoryRoleProvider`

This provider fetches roles from a database using `Doctrine\Common\Persistence\ObjectRepository` interface.

You can configure this provider by giving an object repository service name that is fetched from the service manager
using the `object_repository` key:

```php
return [
    'lmc_rbac' => [
        'role_provider' => [
            'LmcRbac\Role\ObjectRepositoryRoleProvider' => [
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
            'LmcRbac\Role\ObjectRepositoryRoleProvider' => [
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

Please note that your entity fetched from the table MUST implement the `LmcRbac\Role\RoleInterface` interface.

Sample ORM entity models are provided in the `/data` folder for flat role, hierarchical role and permission.

## Creating custom role providers

To create a custom role provider, you first need to create a class that implements the 
`LmcRbac\Role\RoleProviderInterface` interface.

Then, you need to add it to the role provider manager:

```php
return [
    'lmc_rbac' => [
        'role_provider' => [
            'Application\Role\CustomRoleProvider' => [
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
            'Application\Role\CustomRoleProvider' => 'Application\Factory\CustomRoleProviderFactory'
        ],
    ],
];
```

