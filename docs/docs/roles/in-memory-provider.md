---
title: Lmc\Rbac\Role\InMemoryRoleProvider
sidebar_position: 1
---

### `Lmc\Rbac\Role\InMemoryRoleProvider` (built-in)

This built-in provider is ideal for small/medium sites with few roles/permissions. All the data is specified in a simple associative array in a
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
`Laminas\Permissions\Rbac\Role` objects with children, if any.

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

### Handling non existent roles

If the list of roles names to retrieve using this provider includes roles that are
not defined in the provider's configuration, the role provider will create `Laminas\Permissions\Role\Role` objects
for them with no permissions.


