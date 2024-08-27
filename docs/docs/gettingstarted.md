---
sidebar_label: Getting Started
sidebar_position: 2
title: Getting started
---
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
