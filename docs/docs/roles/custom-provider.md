---
title: Building Custom Providers
sidebar_position: 4
---

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
### Role Factory

A Role Factory is a factory that can be used to create basic role instances for a role returned by the role provider.

LmcRbac provide a convenience interface `RoleFactoryInterface` that can be used by a role provider to create roles.

```php
namespace Lmc\Rbac\Role;

use Laminas\Permissions\Rbac\RoleInterface;

interface RoleFactoryInterface
{
    public function createRole(string $roleName): RoleInterface;
}
```

LmcRbac does not provide an implementation for this interface and it is left to the custom role provider to implement
the factory.

Therefore, in your application, you need to define a factory that returns a factory
in your container config. For example:

```php title="src/MyRoleFactory.php"
<?php

namespace MyApp;

use Lmc\Rbac\Role\RoleFactoryInterface;
use Laminas\Permissions\Rbac\Role;
use Laminas\Permissions\Rbac\RoleInterface;

class MyRoleFactory implements RoleFactoryInterface
{
    public function createRole(string $roleName): RoleInterface {
    {
        return new Role($roleName)
    }    
}
```

```php title="/config/autoload/config.php"
return [
    'dependencies' => [
        'factories' => [
            Lmc\Rbac\Role\RoleProviderInterface::class => function (ContainerInterface $container) {
                return new MyApp\MyRoleFactory();
            } 
        ],
    ],
];
```




