---
sidebar_label: Dynamic Assertions
sidebar_position: 6
title: Dynamic Assertions
---

Dynamic Assertions provide the capability to perform extra validations when 
the authorization service's `isGranted()` method is called.

As described in [Authorization Service](authorization-service#reference), it is possible to pass a context to the
`isGranted()` method. This context is then passed to dynamic assertion functions. This context can be any object type.

You can define dynamic assertion functions and assigned them to permission via configuration.

## Defining a dynamic assertion function

A dynamic assertion must implement the `Lmc\Rbac\Assertion\AssertionInterace` which defines only one method:

```php
public function assert(
        string $permission,
        ?IdentityInterface $identity = null,
        mixed $context = null
    ): bool
```
The assertion returns `true` when the access is granted, `false` otherwise.

A simple assertion could be to check that user represented by `$identity`, for the permission
represented by `$permission` owns the resource represented by `$context`.

```php
<?php

class MyAssertion implements \Lmc\Rbac\Assertion\AssertionInterface
{
    public function assert(string $permission, ?IdentityInterface $identity = null, $context = null): bool
    {
        // for 'edit' permission
        if ('edit' === $permission) {
            /** @var MyObjectClass $context */
            return $context->getOwnerId() === $identity->getId();
        }
        // This should not happen since this assertion should only be
        // called when the 'edit' permission is checked 
        return true;
    }
}
```
## Configuring Assertions

Dynamic assertions are configured in LmcRbac via an assertion map defined in the LmcRbac configuration where assertions
are associated with permissions.

The `assertion_map` key in the configuration is used to define the assertion map. If an assertion needs to be created via 
a factory, use the `assertion_manager` config key. The Assertion Manager is a standard
plugin manager and its configuration should be a service manager configuration array.

```php
<?php
use Laminas\ServiceManager\Factory\InvokableFactory

return [
    'lmc_rbac' => [
        /* the rest of the file */
        'assertion_map' => [
            'edit'  => \My\Namespace\MyAssertion::class,
        ],
        'assertion_manager' => [
            'factories' => [
                \My\Namespace\MyAssertion::class => InvokableFactory::class
            ],
        ],
    ],
];
```
It is also possible to configure an assertion using a callable instead of a class:

```php
<?php

use Lmc\Rbac\Permission\PermissionInterface;

return [
    'lmc_rbac' => [
        /* the rest of the file */
        'assertion_map' => [
            'edit'  => function assert(string $permission, ?IdentityInterface $identity = null, $context = null): bool
                        {
                            // for 'edit' permission
                            if ('edit' === $permission) {
                                /** @var MyObjectClass $context */
                                return $context->getOwnerId() === $identity->getId();
                            }
                            // This should not happen since this assertion should only be
                            // called when the 'edit' permission is checked 
                            return true;
                        },
        ],
    ],
];
```
## Dynamic Assertion sets

LmcRbac supports the creation of dynamic assertion sets where multiple assertions can be combined using 'and/or' logic.
Assertion sets are configured by associating an array of assertions to a permission in the assertion map:

```php
<?php

return [
    'lmc_rbac' => [
        /* the rest of the file */
        'assertion_map' => [
            'edit'  => [
                \My\Namespace\AssertionA::class,
                \My\Namespace\AssertionB::class,
            ],
            'read' => [
                'condition' => \Lmc\Rbac\Assertion\AssertionSet::CONDITION_OR,
                \My\Namespace\AssertionC::class,
                \My\Namespace\AssertionD::class,
            ],
            'delete' => [
                'condition' => \Lmc\Rbac\Assertion\AssertionSet::CONDITION_OR,
                \My\Namespace\AssertionE::class,
                [
                    'condition' => \Lmc\Rbac\Assertion\AssertionSet::CONDITION_AND,
                    \My\Namespace\AssertionF::class,
                    \My\Namespace\AssertionC::class,                
                ],
            ],
        /** the rest of the file */
    ],
];
```
By default, an assertion set combines assertions using a 'and' condition. This is demonstrated by the map associated with
the `'edit'` permission above.

It is possible to combine assertions using a 'or' condition by adding a `condition` equal to `AssertionSet::CONDITION_OR` 
to the assertion set as demonstrated by the map associated with the `'read'` permission above.

Furthermore, it is possible to nest assertion sets in order to create more complex logic as demonstrated by the map 
associated with the `'delete'` permission above.

The default logic is to combine assertions using 'and' logic but this can be explicitly set as shown above for `'delete'`
permission.

## Defining dynamic assertions at run-time

Although dynamic assertions are typically defined in the application's configuration, it is possible to set
dynamic assertions at run-time by using the Authorization Service utility methods for adding/getting assertions.

These methods are described in the Authorization Service [reference](authorization-service.md#reference).
