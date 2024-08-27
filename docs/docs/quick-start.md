---
title: Quick Start
sidebar_position: 1
---

LmcRbac offers components and services to implement role-based access control (RBAC) in your application.
LmcRbac extends the components provided by [laminas-permissions-rbac](https://github.com/laminas/laminas-permissions-rbac).

LmcRbac can be used in Laminas MVC and in Mezzio applications.

:::tip
If you are upgrading from LmcRbac v1 or from zfc-rbac v3, please read the [Upgrading section](Upgrading/to-v2.md)
:::

## Concepts

[Role-Based Access Control (RBAC)](https://en.wikipedia.org/wiki/Role-based_access_control)
is an approach to restricting system access to authorized users by putting emphasis
on roles and their permissions.

In the RBAC model:

- an **identity** has one of more roles.
- a **role** has one of more permissions.
- a **permission** is typically an action like "read", "write", "delete".
- a **role** can have **child roles** thus providing a hierarchy of roles where a role will inherit the permissions of all its child roles.

### Authorization

An identity will be authorized to perform an action, such as accessing a resource, if it is granted
the permission that controls the execution of the action.

For example, deleting an item could be restricted to identities that have at least one role that has the
`item.delete` permission.  This could be implemented by defining a `member` role that has the `item.delete` and assigning
this role of an authenticated user.

### Dynamic Assertions

In some cases, just checking if the identity has the `item.delete` permission is not enough.
It would also be necessary to check, for example, that the `item` belongs to the identity. Dynamic assertion allow
to specify some extra checks before granting access to perform an action such as, in this case, being the owner of the
resource.

### Identities

An identity is typically provided by an authentication process within the application.

Authentication is not in the scope of `LmcRbac` and it is assumed that an identity entity that can provide the assigned
roles is available when using the authorization service. If no identity is available, as it would be the case when no
user is "logged in", then a guest role is assumed.

## Requirements

- PHP 8.1 or higher

## Installation

LmcRbac only officially supports installation through Composer.

Install the module:

```sh
$ composer require lm-commons/lmc-rbac "~1.0"
```

You will be prompted by the `laminas-component-installer` plugin to inject LM-Commons\LmcRbac.

:::note
**Manual installation:**

Enable the module by adding `LmcRbac` key to your `application.config.php` or `modules.config.php` file for Laminas MVC
applications, or to the `config/config.php` file for Mezzio applications.
:::

Customize the module by copy-pasting
the `lmcrbac.global.php` file to your `config/autoload` folder.

:::note
On older versions of `LmcRbac`, the configuration file is named `config/config.global.php`.
:::

## Defining roles

By default, no roles and no permissions are defined.

Roles and permissions are defined by a Role Provider. `LmcRbac` ships with two roles providers:
- a simple `InMemoryRoleProvider` that uses an associative array to define roles and their permission. This is the default.
- a `ObjectRepositoyRoleProvider` that is based on Doctrine ORM.

To quickly get started, let's use the `InMemoryRoleProvider` role provider.

In the `config/autoload/lmcrbac.global.php`, add the following:

```php
<?php

return [
    'lmc_rbac' => [
        'role_provider' => [
            Lmc\Rbac\Role\InMemoryRoleProvider::class => [
                'guest',
                'user' => [
                    'permissions' => ['create', 'edit'],
                ],
                'admin' => [
                    'children' => ['user'],
                    'permissions' => ['delete'],
                ],
            ],
        ],
    ],
];
```

This defines 3 roles: a `guest` role, a `user` role having 2 permissions, and a `admin` role which has the `user` role as
a child and with its own permission. If the hierarchy is flattened:

- `guest` has no permission
- `user` has permissions `create` and `edit`
- `admin` has permissions `create`, `edit` and `delete`

## Basic authorization

The authorization service can get retrieved from the service manager container and used to check if a permission
is granted to an identity:

```php
<?php

    /** @var \Psr\Container\ContainerInterface $container */
    $authorizationService = $container->get('\Lmc\Rbac\Service\AuthorizationServiceInterface');
    
    /** @var \Lmc\Rbac\Identity\IdentityInterface $identity */
    if ($authorizationService->isGranted($identity, 'create')) {
        /** do something */
    }
```

If `$identity` has the role `user` and/or `admin` then the authorization is granted. If the identity has the role `guest`, then authorization
is denied.

:::info
If `$identity` is null (no identity), then the guest role is assumed which is set to `'guest'` by default. The guest role
can be configured in the `lmcrbac.config.php` file.  More on this in the [Configuration](configuration.md) section.
:::

:::warning
`LmcRbac` does not provide any logic to instantiate an identity entity. It is assumed that
the application will instantiate an entity that implements `\Lmc\Rbac\Identity\IdentityInterface` which defines the `getRoles()`
method.
:::

## Using assertions

Even if an identity has the `user` role granting it the `edit` permission, it should not have the authorization to edit another identity's resource.

This can be achieved using dynamic assertion.

An assertion is a function that implements the `\Lmc\Rbac\Assertion\AssertionInterface` and is configured in the configuration
file.

Let's modify the `lmcrbac.config.php` file as follows:

```php
<?php
return [
    'lmc_rbac' => [
        'role_provider' => [
            /* roles and permissions
        ],
        'assertion_map' => [
            'edit' => function ($permission, IdentityInterface $identity = null, $resource = null) {
                        if ($resource->getOwnerId() === $identity->getId() {
                            return true;
                        } else {
                            return false;
                      }
        ],
    ],
];
```

Then use the authorization service passing the resource (called a 'context') in addition to the permission:

```php
<?php

    /** @var \Psr\Container\ContainerInterface $container */
    $authorizationService = $container->get('\Lmc\Rbac\Service\AuthorizationServiceInterface');
    
    /** @var \Lmc\Rbac\Identity\IdentityInterface $identity */
    if ($authorizationService->isGranted($identity, 'edit', $resource)) {
        /** do something */
    }
```

Dynanmic assertions are further discussed in the [Dynamic Assertions](assertions) section. 
