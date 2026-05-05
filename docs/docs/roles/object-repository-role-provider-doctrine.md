---
title: Lmc\Rbac\Role\Doctrine\ObjectRepositoryRoleProvider
sidebar_position: 3
---

:::info
New since v2.3
:::

### `Lmc\Rbac\Role\Doctrine\ObjectRepositoryRoleProvider`

This provider fetches roles from a database using a Doctrine ORM Object Repository.

### Installation

```shell
$ composer require lm-commons/lmc-rbac-role-provider-doctrine-orm
```

:::note
You will need to include Doctrine ORM as a dependency in your project. It is not included by default.
:::

### Configuration

You configure this provider by giving an object repository service name that is fetched from the container
using the `object_repository` key:

```php
return [
    'lmc_rbac' => [
        'role_provider' => [
            Lmc\Rbac\Role\Doctrine\ObjectRepositoryRoleProvider::class => [
                'object_repository'  => 'App\Repository\RoleRepository',
                'role_name_property' => 'name',
                'role_factory'       => MyRoleFactory::class,
            ],
        ],
    ],
];
```

Or you can specify the `object_manager` and `class_name` options. The value referenced by
`object_manager` must be available from the container configuration.

```php
return [
    'lmc_rbac' => [
        'role_provider' => [
            Lmc\Rbac\Role\ObjectRepositoryRoleProvider::class => [
                'object_manager'     => 'my.doctrine.entitymanager.for.roles',
                'class_name'         => 'App\Entity\Role',
                'role_name_property' => 'name',
                'role_factory'       => MyRoleFactory::class,
            ],
        ],
    ],
];
```

In both cases, you need to define the `role_name_property` value, which is the name of the entity's property
that holds the actual role name. This is used internally to only load the identity roles, instead of loading
the whole table every time.

Please note that your entity fetched from the table MUST implement the
`Laminas\Permissions\Rbac\RoleInterface` interface.

Sample ORM entity models are provided in the `/data` folder for flat role, hierarchical role and permission.

:::note
The ORM Object/Entity Manager is not configured by this library.
The configuration will need to be done by your application.
:::


### Handling non existent roles

You also need to define the `role_factory` value to specify a Role Factory class that implements the
`Lmc\Rbac\Role\RoleFactoryInterface`. The Role Factory can be used to create a
Role as a fallback when a requested role is not found in the database.  

The Role Factory class must be defined in the application's container configuration.

#### Example

Here's an example of a simple Role Factory:

```php
final class MyRoleFactory implements Lmc\Rbac\Role\RoleFactoryInterface
{
    public function createRole(string $roleName): RoleInterface
    {
        return new Asset\Role($roleName);
    }
}
```
and a corresponding sample container configuration:
```php
// in a config file
use Laminas\ServiceManager\Factory;

return [
    'dependencies' => [
        'factories' => [
            MyRoleFactory::class => InvokableFactory::class,    
        ],
    ],
]; 
```
